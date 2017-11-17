<?php

/**
 * Add instagram extension to the wizard in page module
 *
 * @package TYPO3
 * @subpackage tx_wsinstagram
 */
class InstagramWizicon {

	const KEY = 'ws_instagram';
	const PLUGIN_KEY = 'wsinstagram_instagram';

	/**
	 * Processing the wizard items array
	 *
	 * @param array $wizardItems The wizard items
	 * @return array array with wizard items
	 */
	public function proc($wizardItems) {

		$wizardItems['plugins_tx_' . self::PLUGIN_KEY] = array(
			'icon'			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath(self::KEY) . 'ext_icon.svg',
			'title'			=> $GLOBALS['LANG']->sL('LLL:EXT:'.self::KEY.'/Resources/Private/Language/locallang_db.xlf:wizicon.instagram.title'),
			'description'	=> $GLOBALS['LANG']->sL('LLL:EXT:'.self::KEY.'/Resources/Private/Language/locallang_db.xlf:wizicon.instagram.description'),
			'params'		=> '&defVals[tt_content][CType]=list&defVals[tt_content][list_type]='.self::PLUGIN_KEY
		);

		return $wizardItems;
	}

}