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

/**
 * MediaAlbumController
 */
class MediaAlbumController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * mediaAlbumRepository
	 *
	 * @var \MiniFranske\FsMediaGallery\Domain\Repository\MediaAlbumRepository
	 * @inject
	 */
	protected $mediaAlbumRepository;

	/**
	 * List root of media gallery
	 *
	 * @param integer $mediaAlbum
	 * @return void
	 */
	public function listAction($mediaAlbum = null) {

		if ($mediaAlbum) {
			$mediaAlbum = $this->mediaAlbumRepository->findByUid($mediaAlbum);
			$mediaAlbums = $this->mediaAlbumRepository->findByParentalbum($mediaAlbum);
		} elseif (!empty($this->settings['mediagalleries'])) {
			$mediaAlbums = array();
			foreach (explode(',', $this->settings['mediagalleries']) as $uid) {
				$mediaAlbums[] = $this->mediaAlbumRepository->findByUid($uid);
			}
		} else {
			$mediaAlbums = $this->mediaAlbumRepository->findByParentalbum(false);
		}
		$this->view->assign('mediaAlbums', $mediaAlbums);
	}

	/**
	 * action show
	 *
	 * @param integer $mediaAlbum
	 * @param integer $page the page number
	 * @return void
	 */
	public function showAction($mediaAlbum, $page = 0) {
		$mediaAlbum = $this->mediaAlbumRepository->findByUid($mediaAlbum);
		$this->view->assign('mediaAlbum', $mediaAlbum);
	}

	/**
	 * Show single image from album
	 *
	 * @param \MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum $mediaAlbum
	 * @param int $mediaItemUid
	 * @ignorevalidation
	 */
	public function showImageAction(\MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum $mediaAlbum, $mediaItemUid) {
		$this->view->assign('mediaAlbum', $mediaAlbum);
		$this->view->assign('mediaItem', \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance()->getFileObject($mediaItemUid));
	}

	/**
	 * Show random image
	 *
	 * @return void
	 */
	public function randomImageAction() {
		$mediaAlbums = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $this->settings['mediagalleries'], TRUE);
		$mediaAlbum = $this->mediaAlbumRepository->findByUid($mediaAlbums[rand(1,count($mediaAlbums))-1]);
		$this->view->assign('mediaAlbum', $mediaAlbum);
	}



	/**
	 * If there were validation errors, we don't want to write details like
	 * "An error occurred while trying to call Tx_Community_Controller_UserController->updateAction()"
	 *
	 * @return string|boolean The flash message or FALSE if no flash message should be set
	 */
	protected function getErrorFlashMessage() {
		debug($this->arguments->getValidationResults());
		return FALSE;
	}
}