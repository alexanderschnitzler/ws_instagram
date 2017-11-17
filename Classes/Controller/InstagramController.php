<?php

namespace Webstobe\WsInstagram\Controller;

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

require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('ws_instagram') . 'Classes/Vendor/Instagram/Instagram.php');

use MetzWeb\Instagram\Instagram;

/**
 *
 *
 * @package ws_instagram
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class InstagramController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     * Handles a request. The result output is returned by altering the given response.
     *
     * @param \TYPO3\CMS\Extbase\Mvc\RequestInterface $request The request object
     * @param \TYPO3\CMS\Extbase\Mvc\ResponseInterface $response The response, modified by this handler
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @return void
     */
    public function processRequest(\TYPO3\CMS\Extbase\Mvc\RequestInterface $request, \TYPO3\CMS\Extbase\Mvc\ResponseInterface $response) {
        try {
            parent::processRequest($request, $response);
        } catch (\TYPO3\CMS\Extbase\Property\Exception $exception) {
            $GLOBALS['TSFE']->pageNotFoundAndExit('Instagram Controller could not load.');
        }
    }

    /**
     * Initializes the current action
     *
     * @return void
     */
    public function initializeAction() {

        if (isset($this->settings['override']['maxEntries']) && strlen($this->settings['override']['maxEntries'])) {
            $this->settings['maxEntries'] = $this->settings['override']['maxEntries'];
        }
        if (isset($this->settings['override']['feedFile']) && strlen($this->settings['override']['feedFile'])) {
            $this->settings['feedFile'] = $this->settings['override']['feedFile'];
        }

    }

    /**
     * Action: Info
     *
     * Displays an occurring error message.
     *
     * @param \array $error
     *
     * @return void
     */
    public function infoAction($error = NULL) {

        if ($error === NULL) {
            $GLOBALS['TSFE']->pageNotFoundAndExit('Unexpected error occured. Info action not able to execute.');
        }

        $this->view->assign('error', $error);

    }

    /**
     * action show
     *
     * @return void
     */
    public function showAction() {

        if (!isset($this->settings['feedFile']) || strlen(trim($this->settings['feedFile'])) === 0) {
            $error = array(
                'severity' => 'ERROR',
                'code' => 400,
                'message' => 'Feed file not found.'
            );
            $this->redirect('info', NULL, NULL, array('error' => $error));
        }

        if (isset($this->settings['override']['templateFile']) && strlen($this->settings['override']['templateFile'])) {
            $this->view->setTemplatePathAndFilename($this->settings['override']['templateFile']);
        }

        $instagram = json_decode(file_get_contents($this->settings['feedFile']));

        // assign variables to view
        $this->view->assignMultiple(array(
            'maxEntries' => $this->settings['maxEntries'],
            'instagram' => $instagram
        ));

    }

}