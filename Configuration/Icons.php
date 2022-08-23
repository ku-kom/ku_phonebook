<?php

/**
 * Icon Registry
 */

defined('TYPO3_MODE') || die();

   return [
       // icon identifier
       'ku-phonebook-icon' => [
           'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
           'source' => 'EXT:ku_phonebook/Resources/Public/Icons/Extension.svg',
       ],
   ];