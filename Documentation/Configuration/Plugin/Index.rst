.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _configuration-plugin:

Plugin Configuration
====================

Target group: **Editors**, **Developers**

Most configuration settings can be set through the flexform settings.
As not every configuration is needed for every view, the not needed are hidden.
Every setting can also be set by using :ref:`TypoScript <configuration-typoscript>`.

.. important::

   The settings of the plugin always override the ones from TypoScript.

.. todo: add docu for plugin configuration and screenshots


.. contents::
   :local:
   :depth: 1


.. _flexforms.mediagallery.tabs.general:

Tab "General"
-------------

.. figure:: ../../Images/Configuration/Plugin/flexforms.mediagallery.tabs.general.nested.png
   :width: 718px
   :alt: Tab "General" of plugin in display mode "Selected albums (nested)"

   **Image 1:** Tab "General" of plugin in display mode "Selected albums (nested)"


.. t3-field-list-table::
 :header-rows: 1

 - :Field,20:       Field
   :Modes,15:       Display Modes
   :Description,45: Description
   :TSref,20:       TSref


 - :Field:       Display mode
   :Modes:       all
   :TSref:       none
   :Description:
       .. _flexforms.mediagallery.tabs.general.displayMode:

       Sets the display mode of the Plugin.

       * Selected albums (nested) = ``nestedList``
       * Albums list (flattened) = ``flatList``
       * Single album (URL handover enabled) = ``showAlbumByParam``
       * Single album (URL handover disabled) = ``showAlbumByConfig``
       * Random media asset = ``randomAsset``

       You enable/disable these items via the plugin configuration in the :ref:`Extension Manager <configuration-extConf>`


 - :Field:       Media Albums
   :Modes:       nestedList, randomAsset
   :TSref:       :ref:`settings.mediaAlbums <plugin.tx_fsmediagallery.settings.mediaAlbums>`
   :Description:
       .. _flexforms.mediagallery.tabs.general.mediaAlbums:

       Album selection for ``nestedList`` and ``randomAsset`` views.

       .. important::

          If you want to display a nested album you have to select all of its parent albums.


 - :Field:       Album selection filter
   :Modes:       nestedList, randomAsset
   :TSref:       :ref:`settings.useAlbumFilterAsExclude <plugin.tx_fsmediagallery.settings.useAlbumFilterAsExclude>`
   :Description:
       .. _flexforms.mediagallery.tabs.general.useAlbumFilterAsExclude:

       Include or exclude selected album items


 - :Field:       Startingpoint
   :Modes:       all
   :TSref:       :ref:`presistence.storagePid <plugin.tx_fsmediagallery.persistence.storagePid>`
   :Description:
       .. _flexforms.mediagallery.tabs.general.startingpoint:

       The "Storage Folder" which holds the album records.


 - :Field:       Recursive
   :Modes:       all
   :TSref:       :ref:`presistence.recursive <plugin.tx_fsmediagallery.persistence.recursive>`
   :Description:
       .. _flexforms.mediagallery.tabs.general.recursive:

       Recursion level of the :ref:`Startingpoint <flexforms.mediagallery.tabs.general.startingpoint>`.


.. _flexforms.mediagallery.tabs.list:

Tab "Albums list"
-----------------

.. t3-field-list-table::
 :header-rows: 1

 - :Field,20:       Field
   :Modes,15:       Display Modes
   :Description,45: Description
   :TSref,20:       TSref


 - :Field:       Max. thumbs to display per page
   :Modes:       nestedList, flatList
   :TSref:       :ref:`settings.list.itemsPerPage <plugin.tx_fsmediagallery.settings.list.itemsPerPage>`
   :Description:
       .. _flexforms.mediagallery.tabs.list.itemsPerPage:

       Define how many items are shown on one page.


 - :Field:       Thumb width
   :Modes:       nestedList, flatList
   :TSref:       :ref:`settings.list.thumb.width <plugin.tx_fsmediagallery.settings.list.thumb.width>`
   :Description:
       .. _flexforms.mediagallery.tabs.list.thumb.width:

       Height of thumbnail images.


 - :Field:       Thumb height
   :Modes:       nestedList, flatList
   :TSref:       :ref:`settings.list.thumb.height <plugin.tx_fsmediagallery.settings.list.thumb.height>`
   :Description:
       .. _flexforms.mediagallery.tabs.list.thumb.height:

       Width of thumbnail images.


 - :Field:       Resize mode
   :Modes:       nestedList, flatList
   :TSref:       :ref:`settings.list.thumb.resizeMode <plugin.tx_fsmediagallery.settings.list.thumb.resizeMode>`
   :Description:
       .. _flexforms.mediagallery.tabs.list.thumb.resizeMode:

       Defines how thumbnails in list view are scaled.


 - :Field:       Hide empty albums
   :Modes:       nestedList, flatList
   :TSref:       :ref:`settings.list.hideEmptyAlbums <plugin.tx_fsmediagallery.settings.list.hideEmptyAlbums>`
   :Description:
       .. _flexforms.mediagallery.tabs.list.hideEmptyAlbums:

       Option to exclude albums without media assets from list views.


.. _flexforms.mediagallery.tabs.album:

Tab "Album view"
----------------

.. t3-field-list-table::
 :header-rows: 1

 - :Field,20:       Field
   :Modes,15:       Display Modes
   :Description,45: Description
   :TSref,20:       TSref


 - :Field:       Max. thumbs to display per page
   :Modes:       nestedList, flatList, showAlbumByParam, showAlbumByParam
   :TSref:       :ref:`settings.album.itemsPerPage <plugin.tx_fsmediagallery.settings.album.itemsPerPage>`
   :Description:
       .. _flexforms.mediagallery.tabs.album.itemsPerPage:

       Define how many items are shown on one album page.


 - :Field:       Thumb width
   :Modes:       nestedList, flatList, showAlbumByParam, showAlbumByParam
   :TSref:       :ref:`settings.album.thumb.width <plugin.tx_fsmediagallery.settings.album.thumb.width>`
   :Description:
       .. _flexforms.mediagallery.tabs.album.thumb.width:

       Height of thumbnail images in album view.


 - :Field:       Thumb height
   :Modes:       nestedList, flatList, showAlbumByParam, showAlbumByParam
   :TSref:       :ref:`settings.album.thumb.height <plugin.tx_fsmediagallery.settings.album.thumb.height>`
   :Description:
       .. _flexforms.mediagallery.tabs.album.thumb.height:

       Width of thumbnail images in album view.


 - :Field:       Resize mode
   :Modes:       nestedList, flatList, showAlbumByParam, showAlbumByParam
   :TSref:       :ref:`settings.album.thumb.resizeMode <plugin.tx_fsmediagallery.settings.album.thumb.resizeMode>`
   :Description:
       .. _flexforms.mediagallery.tabs.album.thumb.resizeMode:

       Defines how thumbnails in album view are scaled.


 - :Field:       Use LightBox/Colorbox instead of detail view
   :Modes:       nestedList, flatList, showAlbumByParam, showAlbumByParam
   :TSref:       :ref:`settings.album.lightbox.enable <plugin.tx_fsmediagallery.settings.album.lightbox.enable>`
   :Description:
       .. _flexforms.mediagallery.tabs.album.lightbox.enable:

       Option to do not link to detail view from album list but display media assets using a lightbox/colorbox.



.. _flexforms.mediagallery.tabs.detail:

Tab "Detail view"
-----------------

.. t3-field-list-table::
 :header-rows: 1

 - :Field,20:       Field
   :Modes,15:       Display Modes
   :Description,45: Description
   :TSref,20:       TSref


 - :Field:       Media width
   :Modes:       nestedList, flatList, showAlbumByParam, showAlbumByParam
   :TSref:       :ref:`settings.detail.asset.width <plugin.tx_fsmediagallery.settings.detail.asset.width>`
   :Description:
       .. _flexforms.mediagallery.tabs.detail.asset.width:

       Height of media asset in detail view.


 - :Field:       Media height
   :Modes:       nestedList, flatList, showAlbumByParam, showAlbumByParam
   :TSref:       :ref:`settings.detail.asset.height <plugin.tx_fsmediagallery.settings.detail.asset.height>`
   :Description:
       .. _flexforms.mediagallery.tabs.detail.asset.height:

       Width of media asset in detail view.


 - :Field:       Resize mode
   :Modes:       nestedList, flatList, showAlbumByParam, showAlbumByParam
   :TSref:       :ref:`settings.detail.asset.resizeMode <plugin.tx_fsmediagallery.settings.detail.asset.resizeMode>`
   :Description:
       .. _flexforms.mediagallery.tabs.detail.asset.resizeMode:

       Defines how media assets in detail view are scaled.


.. _flexforms.mediagallery.tabs.random:

Tab "Random asset"
------------------

.. t3-field-list-table::
 :header-rows: 1

 - :Field,20:       Field
   :Modes,15:       Display Modes
   :Description,45: Description
   :TSref,20:       TSref


 - :Field:       Album page
   :Modes:       randomAsset
   :TSref:       :ref:`settings.random.targetPid <plugin.tx_fsmediagallery.settings.random.targetPid>`
   :Description:
       .. _flexforms.mediagallery.tabs.random.targetPid:

       Target page a random assets should link to. Select a page on which a plugin is configured to display the full album (:ref:`Display Mode <flexforms.mediagallery.tabs.general.displayMode>` = ``showAlbumByParam``, ``nestedList`` or ``flatList``).


 - :Field:       Thumbnail width
   :Modes:       randomAsset
   :TSref:       :ref:`settings.random.thumb.width <plugin.tx_fsmediagallery.settings.random.thumb.width>`
   :Description:
       .. _flexforms.mediagallery.tabs.random.thumb.width:

       Height of thumbnail images of random media assets.


 - :Field:       Thumbnail height
   :Modes:       randomAsset
   :TSref:       :ref:`settings.random.thumb.height <plugin.tx_fsmediagallery.settings.random.thumb.height>`
   :Description:
       .. _flexforms.mediagallery.tabs.random.thumb.height:

       Width of thumbnail images of random media assets.


 - :Field:       Resize mode
   :Modes:       randomAsset
   :TSref:       :ref:`settings.random.thumb.resizeMode <plugin.tx_fsmediagallery.settings.random.thumb.resizeMode>`
   :Description:
       .. _flexforms.mediagallery.tabs.random.thumb.resizeMode:

       Defines how thumbnails of random media assets are scaled.
