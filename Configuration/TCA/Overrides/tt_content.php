<?php

/*
 * This file is part of the package ku_phonebook.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3_MODE') or die();

// KU Phonebook box custom select
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', [
    'ku_phonebook' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:ku_phonebook/Resources/Private/Language/locallang_be.xlf:phonebook_label',
        'config' => [
            'type' => 'text',
            'renderType' => 'input',
            'size' => '20',
            'eval' => 'null',
            'placeholder' => 'LLL:EXT:ku_phonebook/Resources/Private/Language/locallang_be.xlf:phonebook_label',
        ],
    ],
]);

// KU Phonebook box CType select
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'LLL:EXT:ku_phonebook/Resources/Private/Language/locallang_be.xlf:title',
        'ku_phonebook',
        'ku-phonebook-icon',
    ],
    'image',
    'after'
);

// KU Phonebook palette
$ku_phonebook = [
    'showitem' => '
    --palette--; LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xml:palette.general; general,header,header_position,ku_phonebook,
    --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.appearanceLinks;appearanceLinks,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
    --palette--;;language,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
    --palette--;;hidden,
    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
    categories,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
    rowDescription,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
    ',
];

$GLOBALS['TCA']['tt_content']['types']['ku_phonebook'] = $ku_phonebook;