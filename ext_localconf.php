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

$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['ajax_page'] = \UniversityOfCopenhagen\KuPhonebook\Controller\MyEidController::class . '::methodName';