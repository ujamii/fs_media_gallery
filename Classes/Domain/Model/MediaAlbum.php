<?php
namespace MiniFranske\FsMediaGallery\Domain\Model;

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
 * Media album
 */
class MediaAlbum extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * fileCollectionRepository
	 *
	 * @var \TYPO3\CMS\Core\Resource\FileCollectionRepository
	 * @inject
	 */
	protected $fileCollectionRepository;

	/**
	 * mediaAlbumRepository
	 *
	 * @var \MiniFranske\FsMediaGallery\Domain\Repository\MediaAlbumRepository
	 * @inject
	 */
	protected $mediaAlbumRepository;

	/**
	 * @var array
	 */
	protected $assetCache;

	/**
	 * Assets
	 * An array of \TYPO3\CMS\Core\Resource\File
	 * @var array
	 */
	protected $assets;

	/**
	 * @var integer
	 */
	protected $assetsCount;

	/**
	 * @var bool
	 */
	protected $hidden;

	/**
	 * Title
	 *
	 * @var \string
	 */
	protected $title;

	/**
	 * Description visible online
	 *
	 * @var \string
	 */
	protected $webdescription;

	/**
	 * @var \MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum|NULL
	 * @lazy
	 */
	protected $parentalbum;

	/**
	 * Child albums
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum>
	 * @lazy
	 */
	protected $albumCache;

	/**
	 * @var DateTime
	 */
	protected $datetime;

	/**
	 * Set hidden
	 *
	 * @param boolean $hidden
	 */
	public function setHidden($hidden) {
		$this->hidden = $hidden;
	}

	/**
	 * Get hidden
	 *
	 * @return boolean
	 */
	public function getHidden() {
		return $this->hidden;
	}

	/**
	 * Returns the title
	 *
	 * @return \string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param \string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the webdescription
	 *
	 * @return \string $webdescription
	 */
	public function getWebdescription() {
		return $this->webdescription;
	}

	/**
	 * Sets the webdescription
	 *
	 * @param \string $webdescription
	 * @return void
	 */
	public function setWebdescription($webdescription) {
		$this->webdescription = $webdescription;
	}

	/**
	 * Set parentalbum
	 *
	 * @param \MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum $parentalbum
	 */
	public function setParentalbum(\MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum $parentalbum) {
		$this->parentalbum = $parentalbum;
	}

	/**
	 * Get parentalbum
	 *
	 * @return \MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum
	 */
	public function getParentalbum() {
		return $this->parentalbum;
	}

	/**
	 * @return array<\TYPO3\CMS\Core\Resource\File>
	 */
	public function getAssets() {
		if($this->assetCache === NULL) {
			try {
				/** @var $fileCollection \TYPO3\CMS\Core\Resource\Collection\AbstractFileCollection */
				$fileCollection = $this->fileCollectionRepository->findByUid($this->getUid());
				$fileCollection->loadContents();
				$this->assetCache = $fileCollection->getItems();
			} catch (\Exception $exception) {
				// failing albums get disabled
				$this->setHidden(TRUE);
				$this->mediaAlbumRepository->update($this);
				$this->assetCache = array();
			}
		}
		return $this->assetCache;
	}

	/**
	 * Get assetsCount
	 *
	 * @return integer
	 */
	public function getAssetsCount() {
		if ($this->assetCache === NULL) {
			return count($this->getAssets());
		}
		return count($this->assetCache);
	}

	/**
	 * Get child albums
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum>>
	 */
	public function getAlbums() {
		if($this->albumCache === NULL) {
			$this->albumCache = $this->mediaAlbumRepository->findByParentalbum($this);
		}
		return $this->albumCache;
	}

	/**
	 * Get random child album
	 *
	 * @return MediaAlbum
	 */
	public function getRandomAlbum() {

		// if albums are loaded use these
		if ($this->albumCache !== NULL) {
			$albums = $this->getAlbums();
			return $albums[rand(0,count($albums)-1)];

		// else fetch random asset from repository
		} else {
			return $this->mediaAlbumRepository->findRandom($this);
		}
	}

	/**
	 * @return \TYPO3\CMS\Core\Resource\File
	 */
	public function getRandomAsset() {

		// check if we need to fetch it from child album
		$randomAlbum = $this->getRandomAlbum();
		if ($randomAlbum) {
			return $randomAlbum->getRandomAsset();
		}

		if (count($this->getAssets())) {
			$assets = $this->getAssets();
			return $assets[rand(1,count($assets))-1];
		} else {
			return NULL;
		}
	}

	/**
	 * Get datetime
	 *
	 * @return DateTime
	 */
	public function getDatetime() {
		return $this->datetime;
	}

	/**
	 * Set date time
	 *
	 * @param DateTime $datetime datetime
	 * @return void
	 */
	public function setDatetime($datetime) {
		$this->datetime = $datetime;
	}

}