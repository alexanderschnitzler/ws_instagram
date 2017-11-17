<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

/*
 * FRONTEND PLUGINS
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Webstobe.' . $_EXTKEY,
	'Instagram',
	'LLL:EXT:ws_instagram/Resources/Private/Language/locallang_db.xlf:plugin.instagram'
);

$pluginSignature = str_replace('_','',$_EXTKEY) . '_instagram';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_instagram.xml');

// TYPOSCRIPT
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Webstobe.Instagram');


if (TYPO3_MODE === 'BE') {

    /**
     * Register the wizard for tt_content
     */
    $GLOBALS['TBE_MODULES_EXT']['xMOD_db_new_content_el']['addElClasses']['InstagramWizicon'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Resources/Private/Php/InstagramWizicon.php';

}