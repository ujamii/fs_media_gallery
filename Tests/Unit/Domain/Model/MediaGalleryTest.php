<?php

namespace MiniFranske\FsMediaGallery\Tests;
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
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class \MiniFranske\FsMediaGallery\Domain\Model\MediaGallery.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Media Gallery
 *
 * @author Frans Saris <franssaris@gmail.com>
 */
class MediaGalleryTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {
	/**
	 * @var \MiniFranske\FsMediaGallery\Domain\Model\MediaGallery
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new \MiniFranske\FsMediaGallery\Domain\Model\MediaGallery();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getTitleReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle() { 
		$this->fixture->setTitle('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTitle()
		);
	}
	
	/**
	 * @test
	 */
	public function getDescriptionReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setDescriptionForStringSetsDescription() { 
		$this->fixture->setDescription('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getDescription()
		);
	}
	
	/**
	 * @test
	 */
	public function getMediaGalleryAlbumsReturnsInitialValueForMediaAlbum() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getMediaGalleryAlbums()
		);
	}

	/**
	 * @test
	 */
	public function setMediaGalleryAlbumsForObjectStorageContainingMediaAlbumSetsMediaGalleryAlbums() { 
		$mediaGalleryAlbum = new \MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum();
		$objectStorageHoldingExactlyOneMediaGalleryAlbums = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneMediaGalleryAlbums->attach($mediaGalleryAlbum);
		$this->fixture->setMediaGalleryAlbums($objectStorageHoldingExactlyOneMediaGalleryAlbums);

		$this->assertSame(
			$objectStorageHoldingExactlyOneMediaGalleryAlbums,
			$this->fixture->getMediaGalleryAlbums()
		);
	}
	
	/**
	 * @test
	 */
	public function addMediaGalleryAlbumToObjectStorageHoldingMediaGalleryAlbums() {
		$mediaGalleryAlbum = new \MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum();
		$objectStorageHoldingExactlyOneMediaGalleryAlbum = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneMediaGalleryAlbum->attach($mediaGalleryAlbum);
		$this->fixture->addMediaGalleryAlbum($mediaGalleryAlbum);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneMediaGalleryAlbum,
			$this->fixture->getMediaGalleryAlbums()
		);
	}

	/**
	 * @test
	 */
	public function removeMediaGalleryAlbumFromObjectStorageHoldingMediaGalleryAlbums() {
		$mediaGalleryAlbum = new \MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$localObjectStorage->attach($mediaGalleryAlbum);
		$localObjectStorage->detach($mediaGalleryAlbum);
		$this->fixture->addMediaGalleryAlbum($mediaGalleryAlbum);
		$this->fixture->removeMediaGalleryAlbum($mediaGalleryAlbum);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getMediaGalleryAlbums()
		);
	}
	
}
?>