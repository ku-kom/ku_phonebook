<?php

declare(strict_types=1);

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

ExtensionUtility::registerPlugin(
    'ku_phonebook',
    'KuPhonebook',
    'LLL:EXT:ku_phonebook/Resources/Private/Language/locallang.xlf:phonebook_label',
    'ku-phonebook-icon'
);