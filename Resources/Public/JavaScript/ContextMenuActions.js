/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Module: TYPO3/CMS/FsMediaGallery/ContextMenuActions
 *
 * JavaScript to handle fs_media_gallery actions from context menu
 * @exports TYPO3/CMS/FsMediaGallery/ContextMenuActions
 */
define(['jquery', 'TYPO3/CMS/Backend/Modal', 'TYPO3/CMS/Backend/Severity'], function($, Modal, Severity) {
    'use strict';

    /**
     * @exports TYPO3/CMS/Filelist/ContextMenuActions
     */
    var ContextMenuActions = {};
    ContextMenuActions.getReturnUrl = function() {
        return top.rawurlencode(top.list_frame.document.location.pathname + top.list_frame.document.location.search);
    };

    ContextMenuActions.editFile = function(table, uid) {
        top.TYPO3.Backend.ContentContainer.setUrl(
            top.TYPO3.settings.FileEdit.moduleUrl + '&target=' + top.rawurlencode(uid) + '&returnUrl=' + ContextMenuActions.getReturnUrl()
        );
    };

    ContextMenuActions.createFile = function(table, uid) {
        top.TYPO3.Backend.ContentContainer.setUrl(
            top.TYPO3.settings.FileCreate.moduleUrl + '&target=' + top.rawurlencode(uid) + '&returnUrl=' + ContextMenuActions.getReturnUrl()
        );
    };

    return ContextMenuActions;
});
