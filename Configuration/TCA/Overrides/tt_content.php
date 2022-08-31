<?php

/*
 * This file is part of the package ku_phonebook.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die();

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

call_user_func(function () {
  ExtensionUtility::registerPlugin(
    'ku_phonebook',
    'Pi1',
    'LLL:EXT:ku_phonebook/Resources/Private/Language/locallang.xlf:phonebook_label',
    'ku-phonebook-icon'
  );

});


