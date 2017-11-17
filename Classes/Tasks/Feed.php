<?php
namespace Webstobe\WsInstagram\Tasks;

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

class Feed extends \TYPO3\CMS\Scheduler\Task\AbstractTask {

	/**
	 * Tries to get the feed from the facebook app and saves it to a json-file.
	 *
	 * @return boolean
	 */
	public function execute() {

		$tempFolder = 'temp';

		if (!is_dir($this->localFolder) && !is_dir($this->localFolder.$tempFolder.DIRECTORY_SEPARATOR)) {

            throw new \BadMethodCallException(
                'Required folders do not exist.'."\n",
                2
            );
            return FALSE;

        }
		$localTempFile = $this->localFolder.$tempFolder.DIRECTORY_SEPARATOR.$this->localFile;
		$localFile = $this->localFolder.$this->localFile;

		$instagramApi = new Instagram(
			array(
				'apiKey'      => $this->clientId,
				'apiSecret'   => $this->clientSecret,
				'apiCallback' => ''
			)
		);
		$instagramApi->setAccessToken($this->accessToken);

		$instagram = array(
			'user' => $instagramApi->getUser(),
			'media' => $instagramApi->getUserMedia()
		);


		if ($instagramApi->getUserMedia()) {
			if (!file_put_contents($localTempFile, json_encode($instagram))) {
				throw new \BadMethodCallException(
					'Feed could not be saved.'."\n",
					2
				);
				return FALSE;
			} else {
				if (filesize($localTempFile) > 0) {
					if (file_exists($localFile)) { unlink($localFile); }
					copy($localTempFile, $localFile);
				}
			}
		} else {
			throw new \BadMethodCallException(
				'Feed could not be loaded.'."\n",
				2
			);
			return FALSE;
		}

		return TRUE;
	
	}

}