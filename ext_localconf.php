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
  'ku_phonebook',
  'pi1',
  [
    \UniversityOfCopenhagen\KuPhonebook\Controller\ExampleController::class => 'list'
  ]
);


call_user_func(
  function () {

      /**
       * Ajax: Example call: ?eID=searchstring
       */
      $GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['searchstring'] =
      \UniversityOfCopenhagen\KuPhonebook\Controller\ExampleController::class;
  }
);