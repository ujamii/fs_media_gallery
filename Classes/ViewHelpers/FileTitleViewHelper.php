<?php
namespace MiniFranske\FsMediaGallery\ViewHelpers;

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
 * File title viewHelper
 */
class FileTitleViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * Get title of a File
     *
     * @param \TYPO3\CMS\Core\Resource\FileInterface|\TYPO3\CMS\Extbase\Domain\Model\File|\TYPO3\CMS\Extbase\Domain\Model\FileReference $file
     * @return string|NULL
     */
    public function render($file)
    {
        if (is_callable(array($file, 'getOriginalResource'))) {
            // Get the original file from the Extbase model
            $file = $file->getOriginalResource();
        }

        if (!$file instanceof \TYPO3\CMS\Core\Resource\FileInterface) {
            return null;
        }

        if ($file->getProperty('title')) {
            return $file->getProperty('title');
        } else {
            return str_ireplace('_', ' ', $file->getNameWithoutExtension());
        }
    }
}