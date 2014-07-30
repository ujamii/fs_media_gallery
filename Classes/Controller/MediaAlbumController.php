<?php
namespace MiniFranske\FsMediaGallery\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Frans Saris <franssaris@gmail.com>
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

use MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum;
use MiniFranske\FsMediaGallery\Utility\PageUtility;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Exception\StopActionException;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * MediaAlbumController
 */
class MediaAlbumController extends ActionController {

	/**
	 * mediaAlbumRepository
	 *
	 * @var \MiniFranske\FsMediaGallery\Domain\Repository\MediaAlbumRepository
	 * @inject
	 */
	protected $mediaAlbumRepository;

	/**
	 * @var ConfigurationManagerInterface
	 */
	protected $configurationManager;

	/**
	 * Injects the Configuration Manager
	 *
	 * @param ConfigurationManagerInterface $configurationManager Instance of the Configuration Manager
	 * @return void
	 */
	public function injectConfigurationManager(ConfigurationManagerInterface $configurationManager) {
		$this->configurationManager = $configurationManager;

		$frameworkSettings = $this->configurationManager->getConfiguration(
			ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK,
			'fsmediagallery',
			'fsmediagallery_mediagallery'
		);
		// merge Framework (TypoScript) and Flexform settings
		if (isset($frameworkSettings['settings']['overrideFlexformSettingsIfEmpty'])) {
			$flexformSettings = $this->configurationManager->getConfiguration(
				ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS
			);
			/** @var $typoScriptUtility \MiniFranske\FsMediaGallery\Utility\TypoScriptUtility */
			$typoScriptUtility = GeneralUtility::makeInstance('MiniFranske\\FsMediaGallery\\Utility\\TypoScriptUtility');
			$mergedSettings = $typoScriptUtility->override($flexformSettings, $frameworkSettings);
			$this->settings = $mergedSettings;
		}
		$this->settings['_typoscript'] = $frameworkSettings['settings'];
		// check some settings
		if (!isset($this->settings['list']['itemsPerPage']) || $this->settings['list']['itemsPerPage'] < 1) {
			$this->settings['list']['itemsPerPage'] = 12;
		}
		if (!isset($this->settings['album']['itemsPerPage']) || $this->settings['album']['itemsPerPage'] < 1) {
			$this->settings['album']['itemsPerPage'] = 12;
		}
	}

	/**
	 * action show
	 *
	 * @param int $mediaAlbum (this is not directly mapped to a object to handle 404 on our own)
	 * @return void
	 */
	public function showAction($mediaAlbum = 0) {
		$mediaAlbums = NULL;
		$mediaAlbum = (int)$mediaAlbum ?: NULL;
		$mediaGalleryUids = array();
		$useAlbumFilterAsExclude = !empty($this->settings['useAlbumFilterAsExclude']);
		$showBackLink = TRUE;

		if(!empty($this->settings['mediagalleries'])) {
			$mediaGalleryUids = GeneralUtility::trimExplode(',', $this->settings['mediagalleries']);
		}

		if ($mediaAlbum) {
			/** @var MediaAlbum $mediaAlbum */
			$mediaAlbum = $this->mediaAlbumRepository->findByUid($mediaAlbum);
			if ($mediaAlbum && $mediaGalleryUids !== array() && !$useAlbumFilterAsExclude && !in_array($mediaAlbum->getUid(), $mediaGalleryUids)) {
				$mediaAlbum = NULL;
			}
			if ($mediaAlbum && $mediaGalleryUids !== array() && $useAlbumFilterAsExclude && in_array($mediaAlbum->getUid(), $mediaGalleryUids)) {
				$mediaAlbum = NULL;
			}
			if ($mediaAlbum && $mediaGalleryUids === array() && !$this->checkAlbumPid($mediaAlbum)) {
				$mediaAlbum = NULL;
			}
			if (!$mediaAlbum) {
				$this->pageNotFound(LocalizationUtility::translate('no_album_found', $this->extensionName));
			}
		}

		$mediaAlbums = $this->mediaAlbumRepository->findByParentalbum($mediaAlbum, $mediaGalleryUids, $useAlbumFilterAsExclude);

		// when only 1 album skip gallery view
		if ($mediaAlbum === NULL && !empty($this->settings['skipGalleryWhenOneAlbum']) && count($mediaAlbums) === 1) {
			$mediaAlbum = $mediaAlbums[0];
			$mediaAlbums = $this->mediaAlbumRepository->findByParentalbum($mediaAlbum, $mediaGalleryUids, $useAlbumFilterAsExclude);
			$showBackLink = FALSE;
		}

		$this->view->assign('showBackLink', $showBackLink);
		$this->view->assign('mediaAlbums', $mediaAlbums);
		$this->view->assign('mediaAlbum', $mediaAlbum);
	}

	/**
	 * List Action
	 *
	 * @param int $mediaAlbum (this is not directly mapped to a object to handle 404 on our own)
	 * @return void
	 */
	public function listAction($mediaAlbum = 0) {
		if ($mediaAlbum) {
			// todo: add option whether to show album in list view
			// if an album is given, display it
			// ATTENTION: using $this->forward instead $this->redirect disables widget params used in the target action
			$this->redirect('showAlbum', NULL, NULL, array('mediaAlbum' => $mediaAlbum));
		}
		$pidList = PageUtility::extendPidListByChildren($this->settings['startingpoint'], $this->settings['recursive']);
		$mediaAlbums = $this->mediaAlbumRepository->findByStoragePage($pidList);
		$this->view->assign('mediaAlbums', $mediaAlbums);
	}

	/**
	 * Show single Album (defined in FlexForm/TS) Action
	 * As showAlbumAction() displays any album by the given param this function gets its value from TS/Felxform
	 * This could be merged with showAlbumAction() if there is a way to determine which switchableControllerActions is defined in Felxform.
	 *
	 * @return void
	 */
	public function showAlbumByConfigAction() {
		$this->forward('showAlbum', NULL, NULL, array('mediaAlbum' => $this->settings['mediaAlbum']));
	}

	/**
	 * Show single Album Action
	 *
	 * @param int $mediaAlbum (this is not directly mapped to a object to handle 404 on our own)
	 * @return void
	 */
	public function showAlbumAction($mediaAlbum = NULL) {
		$mediaAlbum = (int)$mediaAlbum ?: NULL;
		$pidList = PageUtility::extendPidListByChildren($this->settings['startingpoint'], $this->settings['recursive']);
		$mediaAlbum = $this->mediaAlbumRepository->findByUidAndStoragePage($mediaAlbum, $pidList);
		if (!$mediaAlbum) {
			$this->pageNotFound(LocalizationUtility::translate('no_album_found', $this->extensionName));
		}
		$this->view->assign('mediaAlbum', $mediaAlbum);
		$this->view->assign('showBackLink', FALSE);
	}

	/**
	 * Show single image from album
	 *
	 * @param \MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum $mediaAlbum
	 * @param int $mediaItemUid
	 * @ignorevalidation
	 */
	public function showImageAction(MediaAlbum $mediaAlbum, $mediaItemUid) {
		$this->view->assign('mediaAlbum', $mediaAlbum);
		$this->view->assign('mediaItem', ResourceFactory::getInstance()->getFileObject($mediaItemUid));
	}

	/**
	 * Show random image
	 *
	 * @return void
	 */
	public function randomImageAction() {
		$filterByUids = GeneralUtility::trimExplode(',', $this->settings['mediagalleries'], TRUE);
		$mediaAlbum = $this->mediaAlbumRepository->findRandom(NULL, $filterByUids, !empty($this->settings['useAlbumFilterAsExclude']));
		$this->view->assign('mediaAlbum', $mediaAlbum);
	}

	/**
	 * If there were validation errors, we don't want to write details like
	 * "An error occurred while trying to call Tx_Community_Controller_UserController->updateAction()"
	 *
	 * @return string|boolean The flash message or FALSE if no flash message should be set
	 */
	protected function getErrorFlashMessage() {
		return FALSE;
	}

	/**
	 * Check if album pid is in allowed storage
	 *
	 * @param MediaAlbum $mediaAlbum
	 * @return bool
	 */
	protected function checkAlbumPid(MediaAlbum $mediaAlbum) {
		$frameworkConfiguration = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		$allowedStoragePages = GeneralUtility::trimExplode(
			',',
			$frameworkConfiguration['persistence']['storagePid']
		);
		if (in_array($mediaAlbum->getPid(), $allowedStoragePages)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * Page not found wrapper
	 *
	 * @param string $message
	 * @throws StopActionException
	 */
	protected function pageNotFound($message) {
		if (!empty($GLOBALS['TSFE'])) {
			$GLOBALS['TSFE']->pageNotFoundAndExit($message);
		} else {
			echo $message;
		}
		throw new StopActionException();
	}

}