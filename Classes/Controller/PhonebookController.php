<?php

declare(strict_types=1);

/*
 * This file is part of the package ku_phonebook.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace UniversityOfCopenhagen\KuPhonebook\Controller;

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Http\RequestFactory;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

//class PhonebookController
class PhonebookController extends ActionController
{
    // Initiate the RequestFactory, which allows to run multiple requests
    // (prefer dependency injection)
    public function __construct(
        private readonly RequestFactory $requestFactory,
    ) {
    }

    public function phonebookSearchAction(): ResponseInterface
    {  
        // Webservive endpoint is set in TYPO3 > Admin Tools > Settings > Extension Configuration 
        $url = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('ku_phonebook', 'uri');

        $query = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('q');

        // See: https://docs.guzzlephp.org/en/stable/request-options.html
        $additionalOptions = [
            'form_params' => [
                'format' => 'json',
                'startrecord' => '0',
                'recordsperpage' => '100',
                'searchstring' => $query
            ]
        ];

        // Return a PSR-7 compliant response object
        $response = $this->requestFactory->request($url, 'POST', $additionalOptions);

        return $this->responseFactory->createResponse()
        ->withAddedHeader('Content-Type', 'text/html; charset=utf-8')
        ->withBody($this->streamFactory->createStream($this->view->render()));

        // if ($response->getStatusCode() === 200) {
        //     $content = $response->getBody()->getContents();
        //     \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($content);
        //     return $content;
        // }
 
     }
}
