<?php

/*
 * This file is part of the package ku_phonebook.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die('Access denied.');

// PageTS

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
    @import \'EXT:ku_phonebook/Configuration/TsConfig/Page/All.tsconfig\'
');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
  'UniversityOfCopenhagen.KuPhonebook',
  'Testing',
  [
      \UniversityOfCopenhagen\KuPhonebook\Controller\ExampleController::class => 'doSomething',               
  ],
  // non-cacheable actions
  [
    \UniversityOfCopenhagen\KuPhonebook\ExampleController::class => 'doSomething',
  ]
);

// Register ajax call
$TYPO3_CONF_VARS['FE']['eID_include']['ajaxCall'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('extension_key').'Classes/Ajax/EidDispatcher.php';