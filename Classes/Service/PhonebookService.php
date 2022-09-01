<?php

namespace UniversityOfCopenhagen\KuPhonebook\Service;

/***************************************************************
 *
 * Copyright notice
 *
 * (c) 2019 Thomas Deuling <typo3@coding.ms>
 *
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use DateTime;
use DOMElement;
use Exception;
use DOMdocument;
use TYPO3\CMS\Core\Resource\Exception\ExistingTargetFolderException;
use TYPO3\CMS\Core\Resource\Exception\InsufficientFolderAccessPermissionsException;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\Folder;
use TYPO3\CMS\Core\Resource\ResourceStorage;
use TYPO3\CMS\Core\Resource\StorageRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * RSS-App service
 *
 * @package rss_app
 * @subpackage Service
 *
 * @author Thomas Deuling <typo3@coding.ms>
 */
class PhonebookService
{

    const BASE_PATH = 'uploads/tx_rssapp/';
    const INSTAGRAM_CACHE_BASE_PATH = 'uploads/tx_rssapp_cache/instagram/';

    /**
     * Load the feed
     *
     * @param array $settings Settings
     * @return array feed array
     * @throws Exception
     */
    public function getData($settings): array
    {
        $settings = $this->prepareFolder($settings);
        $file = $settings['fullPath'] . md5($settings['url']) . '.json';
        if (file_exists($file)) {
            $data = file_get_contents($file);
            $jsonArray = json_decode($data, true);
            if ($jsonArray['time'] < (time() - 60 * 60)) {
                $feedArray = $this->fetchData($settings['url'], $file);
                $feedArray['t3cache'] = 'fetched';
            } else {
                $feedArray = $jsonArray['feed'];
                $feedArray['t3cache'] = 'restored';
            }
        } else {
            $feedArray = $this->fetchData($settings['url'], $file);
            $feedArray['t3cache'] = 'fetched';
        }
        return $feedArray;
    }

    /**
     * Prepare directory
     *
     * @param $settings
     * @return array
     * @throws Exception
     */
    protected function prepareFolder($settings): array
    {
        $settings['path'] = self::BASE_PATH;
        $settings['fullPath'] = GeneralUtility::getFileAbsFileName($settings['path']);
        if (!file_exists($settings['fullPath'])) {
            if (!GeneralUtility::mkdir($settings['fullPath'])) {
                throw new Exception('Creating folder ' . $settings['path'] . ' failed!', 1);
            }
        }
        if (!file_put_contents($settings['fullPath'] . '.htaccess', 'deny from all')) {
            throw new Exception('Creating .htaccess in folder ' . $settings['path'] . ' failed!', 2);
        }
        return $settings;
    }

    /**
     * Fetch and cache RSS-App feed
     *
     * @param string $url RSS-Feed url
     * @param string $file Filename for the cache file
     * @return array
     * @throws Exception
     */
    protected function fetchData($url, $file): array
    {
        /** @var DOMdocument $doc */
        $doc = new DOMdocument();
        $doc->load($url);
        $feedArray = [];
        $items = [];
        $tags = [
            'title',
            'link',
            'guid',
            'comments',
            'description',
            'pubDate',
            'category',
            'media:content',
            'dc:creator',
        ];
        foreach ($doc->getElementsByTagName('item') as $node) {
            $node = $this->cacheInstagramImages($node);

            foreach ($tags as $key => $value) {
                switch ($value) {
                    case 'pubDate':
                        if ($node->getElementsByTagName($value)->item(0)) {
                            $items[$value] = new DateTime($node->getElementsByTagName($value)->item(0)->nodeValue);
                        }
                        break;
                    case 'dc:creator':
                        $mediaContent = $node->getElementsByTagNameNS('http://search.yahoo.com/mrss/', 'content');
                        if ($mediaContent->item(0)) {
                            $items['media']['medium'] = $mediaContent->item(0)->getAttribute('medium');
                            $items['media']['url'] = $mediaContent->item(0)->getAttribute('url');
                        }
                        break;
                    case 'media:content':
                        $mediaContent = $node->getElementsByTagNameNS('http://purl.org/dc/elements/1.1/', 'creator');
                        if ($mediaContent->item(0)) {
                            $items['creator'] = $mediaContent->item(0)->nodeValue;
                        }
                        break;
                    default:
                        $items[$value] = $node->getElementsByTagName($value)->item(0)->nodeValue ?? '';
                }
            }
            array_push($feedArray, $items);
        }
        $feedArray = [
            'title' => $doc->getElementsByTagName('title')->item(0)->nodeValue,
            'description' => $doc->getElementsByTagName('description')->item(0)->nodeValue,
            'link' => $doc->getElementsByTagName('link')->item(0)->nodeValue,
            'items' => $feedArray,
        ];
        if ($doc->getElementsByTagName('generator')->item(0)) {
            $feedArray['generator'] = $doc->getElementsByTagName('generator')->item(0)->nodeValue;
        }
        if ($doc->getElementsByTagName('lastBuildDate')->item(0)) {
            $feedArray['lastBuildDate'] = new DateTime($doc->getElementsByTagName('lastBuildDate')->item(0)->nodeValue);
        }
        if ($doc->getElementsByTagName('image')->item(0)) {
            $feedArray['image'] = [
                'url' => $doc->getElementsByTagName('image')->item(0)->getElementsByTagName('url')->item(0)->nodeValue,
                'title' => $doc->getElementsByTagName('image')->item(0)->getElementsByTagName('title')->item(0)->nodeValue,
                'link' => $doc->getElementsByTagName('image')->item(0)->getElementsByTagName('link')->item(0)->nodeValue,
            ];
        }
        //
        // Set cache file
        $cache = [
            'time' => time(),
            'feed' => $feedArray,
        ];
        file_put_contents($file, json_encode($cache, JSON_PRETTY_PRINT));
        return $feedArray;
    }

    /**
     * @param DOMElement $node
     * @return DOMElement
     */
    private function cacheInstagramImages(DOMElement $node): DOMElement
    {
        try {
            $instagramLinkTestString = 'instagram.com';
            $linkNode = $node->getElementsByTagName('link')->item(0);
            $url = null;
            $mediaContent = $node->getElementsByTagNameNS('http://search.yahoo.com/mrss/', 'content')->item(0);
            if ($mediaContent) {
                $url = $mediaContent->getAttribute('url');
            }
            if ($linkNode && $url && $url !== '') {
                $link = $linkNode->nodeValue;
                $link = strtok($link, '?');
                if ($link && $link !== '' && strpos($link, $instagramLinkTestString) !== false) {
                    $identifier = substr($link, strpos($link, $instagramLinkTestString) + strlen($instagramLinkTestString));
                    $path = self::INSTAGRAM_CACHE_BASE_PATH . ltrim($identifier, '/');
                    $folder = $this->getFolder($path);
                    if ($folder) {
                        $file = null;
                        if (!$folder->hasFile('image.jpg')) {
                            $imageFileContents = file_get_contents($url);
                            if ($imageFileContents === 'URL signature expired') {
                                $imageFileContents = file_get_contents($link . '/media/?size=l');
                            }
                            $file = $folder->createFile('image.jpg');
                            $file->setContents($imageFileContents);
                        } else {
                            $files = $folder->getFiles();
                            foreach ($files as $currentFile) {
                                if ($currentFile->getName() === 'image.jpg') {
                                    $file = $currentFile;
                                }
                            }
                        }
                        if ($file instanceof File) {
                            $mediaContent->setAttribute('url', $file->getPublicUrl());
                        }
                    }
                }
            }
        } catch (ExistingTargetFolderException | InsufficientFolderAccessPermissionsException $e) {
        }
        return $node;
    }

    /**
     * @param string $path
     * @return Folder|null
     * @throws InsufficientFolderAccessPermissionsException
     * @throws ExistingTargetFolderException
     */
    public function getFolder(string $path): ?Folder
    {
        /** @var StorageRepository $storageRepository */
        $storageRepository = GeneralUtility::makeInstance(StorageRepository::class);
        /** @var ResourceStorage $resourceStorage */
        $resourceStorage = $storageRepository->findByUid(1);
        if (!$resourceStorage) return null;
        if (!$resourceStorage->hasFolder($path)) {
            $resourceStorage->createFolder($path);
        }
        return $resourceStorage->getFolder($path);
    }
}

