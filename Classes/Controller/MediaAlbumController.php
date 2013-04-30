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
class MediaAlbumController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * mediaAlbumRepository
	 *
	 * @var \MiniFranske\FsMediaGallery\Domain\Repository\MediaAlbumRepository
	 * @inject
	 */
	protected $mediaAlbumRepository;

	/**
	 * fileCollectionRepository
	 *
	 * @var \TYPO3\CMS\Core\Resource\FileCollectionRepository
	 * @inject
	 */
	protected $fileCollectionRepository;
	
	/**
	 * AssetRepository
	 *
	 * @var TYPO3\CMS\Media\Domain\Repository\AssetRepository
	 * @inject
	 */
	protected $assetRepository;
	
	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$mediaAlbums = $this->mediaAlbumRepository->findAll();
		$this->view->assign('mediaAlbums', $mediaAlbums);
	}

	/**
	 * action show
	 *
	 * @param \MiniFranske\FsMediaGallery\Domain\Model\MediaGallery $mediaGallery
	 * @param \MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum $mediaAlbum
	 * @param int $page the page number
	 * @return void
	 */
	public function showAction(\MiniFranske\FsMediaGallery\Domain\Model\MediaGallery $mediaGallery, \MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum $mediaAlbum, $page = 1) {
		$this->view->assign('mediaGallery', $mediaGallery);
		$this->view->assign('mediaAlbum', $mediaAlbum);
		
		/** @var $fileCollection t3lib_file_Collection_StaticFileCollection */
		$fileCollection = $this->fileCollectionRepository->findByUid($mediaAlbum->getUid());
		$fileCollection->loadContents();
//foreach($fileCollection as $item) {
//	debug($item->toArray());
//}
		$this->view->assign('fileCollection', $fileCollection);
	}
	
	/**
	 * Show single image from album
	 * 
	 * @param \MiniFranske\FsMediaGallery\Domain\Model\MediaGallery $mediaGallery
	 * @param \MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum $mediaAlbum
	 * @param int $mediaItemUid
	 */
	public function showImageAction(\MiniFranske\FsMediaGallery\Domain\Model\MediaGallery $mediaGallery, \MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum $mediaAlbum, $mediaItemUid) {
		$this->view->assign('mediaGallery', $mediaGallery);
		$this->view->assign('mediaAlbum', $mediaAlbum);
		
		$this->view->assign('mediaItem', $this->assetRepository->findByUid($mediaItemUid));
	}

	/**
	 * action new
	 *
	 * @param \MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum $newMediaAlbum
	 * @dontvalidate $newMediaAlbum
	 * @return void
	 */
	public function newAction(\MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum $newMediaAlbum = NULL) {
		$this->view->assign('newMediaAlbum', $newMediaAlbum);
	}

	/**
	 * action create
	 *
	 * @param \MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum $newMediaAlbum
	 * @return void
	 */
	public function createAction(\MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum $newMediaAlbum) {
		$this->mediaAlbumRepository->add($newMediaAlbum);
		$this->flashMessageContainer->add('Your new MediaAlbum was created.');
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param \MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum $mediaAlbum
	 * @return void
	 */
	public function editAction(\MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum $mediaAlbum) {
		$this->view->assign('mediaAlbum', $mediaAlbum);
	}

	/**
	 * action update
	 *
	 * @param \MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum $mediaAlbum
	 * @return void
	 */
	public function updateAction(\MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum $mediaAlbum) {
		$this->mediaAlbumRepository->update($mediaAlbum);
		$this->flashMessageContainer->add('Your MediaAlbum was updated.');
		$this->redirect('list');
	}

	/**
	 * action delete
	 *
	 * @param \MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum $mediaAlbum
	 * @return void
	 */
	public function deleteAction(\MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum $mediaAlbum) {
		$this->mediaAlbumRepository->remove($mediaAlbum);
		$this->flashMessageContainer->add('Your MediaAlbum was removed.');
		$this->redirect('list');
	}

}
?>