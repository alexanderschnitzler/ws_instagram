<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Webstobe.' . $_EXTKEY,
    'Instagram',
    array(
        'Instagram' => 'show, info',
    ),
    // non-cacheable actions
    array(
        'Instagram' => 'show, info',
    )
);

// REGISTER EID
$TYPO3_CONF_VARS['FE']['eID_include']['instagramCallback'] = 'EXT:ws_instagram/Classes/Eid/Callback.php';

// REGISTER TASKS
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Webstobe\\WsInstagram\\Tasks\\Feed'] = array(
    'extension'        => $_EXTKEY,
    'title'            => 'LLL:EXT:ws_instagram/Resources/Private/Language/locallang_db.xlf:task.instagram.title',
    'description'      => 'LLL:EXT:ws_instagram/Resources/Private/Language/locallang_db.xlf:task.instagram.description',
    'additionalFields' => 'Webstobe\\WsInstagram\\Tasks\\FeedAdditionalFields'
);