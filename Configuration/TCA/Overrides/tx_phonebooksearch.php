<?php

/*
 * This file is part of the package ku_phonebook.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3_MODE') or die();

/**
 * Registers backend previewRenderer for custom content element "KU Phonebook".
 */

$GLOBALS['TCA']['tt_content']['types']['ku_phonebook']['previewRenderer'] = \UniversityOfCopenhagen\KuPhonebook\Backend\Preview\imageWithOverlayPreviewRenderer::class;