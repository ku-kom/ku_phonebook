<?php

/*
 * This file is part of the package ku_phonebook.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3_MODE') or die();

// KU Phonebook box custom select
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', [
    'ku_color_family' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:ku_phonebook/Resources/Private/Language/locallang_be.xlf:select_color',
        'config' => [
            'type' => 'text',
            'renderType' => 'input',
            'items' => [
                ['LLL:EXT:ku_phonebook/Resources/Private/Language/locallang_be.xlf:ku_color_red_header', '--div--'],
                ['LLL:EXT:ku_phonebook/Resources/Private/Language/locallang_be.xlf:ku_color_red1', 'box-red1'],
                ['LLL:EXT:ku_phonebook/Resources/Private/Language/locallang_be.xlf:ku_color_red2', 'box-red2'],
                ['LLL:EXT:ku_phonebook/Resources/Private/Language/locallang_be.xlf:ku_color_red3', 'box-red3'],
                ['LLL:EXT:ku_phonebook/Resources/Private/Language/locallang_be.xlf:ku_color_blue_header', '--div--'],
                ['LLL:EXT:ku_phonebook/Resources/Private/Language/locallang_be.xlf:ku_color_blue1', 'box-blue1'],
                ['LLL:EXT:ku_phonebook/Resources/Private/Language/locallang_be.xlf:ku_color_blue2', 'box-blue2'],
                ['LLL:EXT:ku_phonebook/Resources/Private/Language/locallang_be.xlf:ku_color_blue3', 'box-blue3'],
                ['LLL:EXT:ku_phonebook/Resources/Private/Language/locallang_be.xlf:ku_color_teal_header', '--div--'],
                ['LLL:EXT:ku_phonebook/Resources/Private/Language/locallang_be.xlf:ku_color_teal1', 'box-teal1'],
                ['LLL:EXT:ku_phonebook/Resources/Private/Language/locallang_be.xlf:ku_color_teal2', 'box-teal2'],
                ['LLL:EXT:ku_phonebook/Resources/Private/Language/locallang_be.xlf:ku_color_teal3', 'box-teal3'],
                ['LLL:EXT:ku_phonebook/Resources/Private/Language/locallang_be.xlf:ku_color_green_header', '--div--'],
                ['LLL:EXT:ku_phonebook/Resources/Private/Language/locallang_be.xlf:ku_color_green1', 'box-green1'],
                ['LLL:EXT:ku_phonebook/Resources/Private/Language/locallang_be.xlf:ku_color_green2', 'box-green2'],
                ['LLL:EXT:ku_phonebook/Resources/Private/Language/locallang_be.xlf:ku_color_green3', 'box-green3'],
                ['LLL:EXT:ku_phonebook/Resources/Private/Language/locallang_be.xlf:ku_color_grey_header', '--div--'],
                ['LLL:EXT:ku_phonebook/Resources/Private/Language/locallang_be.xlf:ku_color_grey1', 'box-grey1'],
                ['LLL:EXT:ku_phonebook/Resources/Private/Language/locallang_be.xlf:ku_color_grey2', 'box-grey2'],
                ['LLL:EXT:ku_phonebook/Resources/Private/Language/locallang_be.xlf:ku_color_grey3', 'box-grey3'],
                ['LLL:EXT:ku_phonebook/Resources/Private/Language/locallang_be.xlf:ku_color_light_header', '--div--'],
                ['LLL:EXT:ku_phonebook/Resources/Private/Language/locallang_be.xlf:ku_color_light1', 'box-light1'],
                ['LLL:EXT:ku_phonebook/Resources/Private/Language/locallang_be.xlf:ku_color_light2', 'box-light2'],
                ['LLL:EXT:ku_phonebook/Resources/Private/Language/locallang_be.xlf:ku_color_light3', 'box-light3'],
            ],
            'default' => 'box-blue2',

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
    --palette--; LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xml:palette.general; general,header,header_position,ku_color_family,image,ku_overlay_button_1,ku_overlay_link_1,ku_overlay_button_2,ku_overlay_link_2,
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