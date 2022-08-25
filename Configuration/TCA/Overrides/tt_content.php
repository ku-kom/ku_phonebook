
<?php
if (!defined('TYPO3_MODE')) { die('Access denied.'); }

call_user_func(function () {

	# Define extension key
	$_EXTKEY = 'ku_phonebook';

	# Should move code from ext_tables.php to here > To register plugin
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	    $_EXTKEY,
	    'Pi1',
	    'LLL:EXT:ku_phonebook/Resources/Private/Language/locallang_be.xlf:title',
		'EXT:ku_phonebook/Resources/Public/Icons/Extension.svg'
	);

	# Prepare plugin's signature
	$extensionName = strtolower(\TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY)); 
	$pluginName = strtolower('Pi1'); 
	$pluginSignature = $extensionName.'_'.$pluginName; 

	# Add list_type to tt_content
	$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';

	# Add Flexform
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
		$pluginSignature, 
		'FILE:EXT:'.$_EXTKEY . '/Configuration/FlexForms/pi1_name.xml'
	);
});