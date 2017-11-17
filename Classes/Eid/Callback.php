<?php
namespace Webstobe\WsInstagram\Eid;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 Cornel Widmer <cornel@webstobe.ch>, Webstobe GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('ws_instagram').'Classes/Vendor/Instagram/Instagram.php');

use MetzWeb\Instagram\Instagram;

/**
 *
 *
 * @package ws_instagram
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Callback {

	public function execute () {
		$extConfig = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['ws_instagram']);

		$settings = array(
			'apiKey'      => $extConfig['clientId'],
			'apiSecret'   => $extConfig['clientSecret'],
			'apiCallback' => $extConfig['clientCallback']
		);

		// OVERRIDE WITH SETTINGS FROM THE GET PARAMS
		if (null != \TYPO3\CMS\Core\Utility\GeneralUtility::_GET('clientId') && strlen(\TYPO3\CMS\Core\Utility\GeneralUtility::_GET('clientId'))) $settings['apiKey'] = \TYPO3\CMS\Core\Utility\GeneralUtility::_GET('clientId');
		if (null != \TYPO3\CMS\Core\Utility\GeneralUtility::_GET('clientSecret') && strlen(\TYPO3\CMS\Core\Utility\GeneralUtility::_GET('clientSecret'))) $settings['apiSecret'] = \TYPO3\CMS\Core\Utility\GeneralUtility::_GET('clientSecret');
		if (null != \TYPO3\CMS\Core\Utility\GeneralUtility::_GET('apiCallback') && strlen(\TYPO3\CMS\Core\Utility\GeneralUtility::_GET('apiCallback'))) $settings['apiCallback'] = \TYPO3\CMS\Core\Utility\GeneralUtility::_GET('apiCallback');

		$instagramApi = new Instagram($settings);

		$data = $instagramApi->getLoginUrl();

		if (isset($_REQUEST['code']) && strlen(trim($_REQUEST['code']))) {
			$data = $instagramApi->getOAuthToken($_REQUEST['code'], true);
		}

		return $data;
	}

}

$callback = new \Webstobe\WsInstagram\Eid\Callback();

echo $callback->execute();
