<?php
namespace MiniFranske\FsMediaGallery\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Frans Saris <franssaris@gmail.com>
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
 *
 *
 * @package fs_media_gallery
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class MediaGalleryController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * mediaGalleryRepository
	 *
	 * @var \MiniFranske\FsMediaGallery\Domain\Repository\MediaGalleryRepository
	 * @inject
	 */
	protected $mediaGalleryRepository;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$mediaGalleries = $this->mediaGalleryRepository->findAll();
		$this->view->assign('mediaGalleries', $mediaGalleries);
	}

	/**
	 * action show
	 *
	 * @param \MiniFranske\FsMediaGallery\Domain\Model\MediaGallery $mediaGallery
	 * @return void
	 */
	public function showAlbumsAction(\MiniFranske\FsMediaGallery\Domain\Model\MediaGallery $mediaGallery) {
		
		$this->view->assign('mediaGallery', $mediaGallery);
	}

	/**
	 * action new
	 *
	 * @param \MiniFranske\FsMediaGallery\Domain\Model\MediaGallery $newMediaGallery
	 * @dontvalidate $newMediaGallery
	 * @return void
	 */
	public function newAction(\MiniFranske\FsMediaGallery\Domain\Model\MediaGallery $newMediaGallery = NULL) {
		$this->view->assign('newMediaGallery', $newMediaGallery);
	}

	/**
	 * action create
	 *
	 * @param \MiniFranske\FsMediaGallery\Domain\Model\MediaGallery $newMediaGallery
	 * @return void
	 */
	public function createAction(\MiniFranske\FsMediaGallery\Domain\Model\MediaGallery $newMediaGallery) {
		$this->mediaGalleryRepository->add($newMediaGallery);
		$this->flashMessageContainer->add('Your new MediaGallery was created.');
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param \MiniFranske\FsMediaGallery\Domain\Model\MediaGallery $mediaGallery
	 * @return void
	 */
	public function editAction(\MiniFranske\FsMediaGallery\Domain\Model\MediaGallery $mediaGallery) {
		$this->view->assign('mediaGallery', $mediaGallery);
	}

	/**
	 * action update
	 *
	 * @param \MiniFranske\FsMediaGallery\Domain\Model\MediaGallery $mediaGallery
	 * @return void
	 */
	public function updateAction(\MiniFranske\FsMediaGallery\Domain\Model\MediaGallery $mediaGallery) {
		$this->mediaGalleryRepository->update($mediaGallery);
		$this->flashMessageContainer->add('Your MediaGallery was updated.');
		$this->redirect('list');
	}

	/**
	 * action delete
	 *
	 * @param \MiniFranske\FsMediaGallery\Domain\Model\MediaGallery $mediaGallery
	 * @return void
	 */
	public function deleteAction(\MiniFranske\FsMediaGallery\Domain\Model\MediaGallery $mediaGallery) {
		$this->mediaGalleryRepository->remove($mediaGallery);
		$this->flashMessageContainer->add('Your MediaGallery was removed.');
		$this->redirect('list');
	}

}
?>