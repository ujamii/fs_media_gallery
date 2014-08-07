.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _configuration-typoscript:

TypoScript Reference
====================

Target group: **Developers**

All configuration options are available in the FlexForm or TypoScript,
with the FlexForm settings taking precedence.

This chapter describes the settings which are available for EXT:fs_media_gallery.
Except of setting the template paths and overriding labels of the locallang-file,
the settings are defined by using :typoscript:`plugin.tx_fsmediagallery.settings.<property>`.

.. contents::
   :local:
   :depth: 1


.. _plugin.tx_fsmediagallery.view:

View and template settings
--------------------------

.. container:: ts-properties

   =========================== ============================== ======================= =================================================================
   Property                    Data type                      :ref:`t3tsref:stdwrap`  Default
   =========================== ============================== ======================= =================================================================
   `templateRootPaths.100`_    :ref:`t3tsref:data-type-path`  no                      :typoscript:`{$plugin.tx_fsmediagallery.view.templateRootPath}`
   `partialRootPaths.100`_     :ref:`t3tsref:data-type-path`  no                      :typoscript:`{$plugin.tx_fsmediagallery.view.partialRootPath}`
   `layoutRootPaths.100`_      :ref:`t3tsref:data-type-path`  no                      :typoscript:`{$plugin.tx_fsmediagallery.view.layoutRootPath}`
   =========================== ============================== ======================= =================================================================


.. tip::

   Since TYPO3 6.2 it is possible to just override a single template file. Multiple fallbacks can be defined which makes it far easier to customize the templates.

EXT:fs_media_gallery uses key 100 pointing to the default paths of its fluid files.
You can simply add overwrite paths so you only have to copy over files you want to change.
All others can remain in the default location.

.. important::

    Please notice the ending **s** in templateRootPath\ **s**\ , partialRootPath\ **s** and
    layoutRootPath\ **s**\ .

.. code-block:: typoscript

    plugin.tx_fsmediagallery {
        view {
            templateRootPaths {
                100 = {$plugin.tx_fsmediagallery.view.templateRootPath}
                200 = fileadmin/templates/ext/tx_fsmediagallery/Templates/
            }
            partialRootPaths {
                100 = {$plugin.tx_fsmediagallery.view.partialRootPath}
                200 = fileadmin/templates/ext/tx_fsmediagallery/Partials/
            }
            layoutRootPaths {
                100 = {$plugin.tx_fsmediagallery.view.layoutRootPath}
                200 = fileadmin/templates/ext/tx_fsmediagallery/Layouts/
            }
        }
    }


Property details
^^^^^^^^^^^^^^^^

.. _plugin.tx_fsmediagallery.view.templateRootPaths.100:

templateRootPaths.100
"""""""""""""""""""""

:typoscript:`plugin.tx_fsmediagallery.view.templateRootPaths.100 =` :ref:`t3tsref:data-type-path`

Root path for the fluid **templates** of the plugin.


.. _plugin.tx_fsmediagallery.view.partialRootPaths.100:

partialRootPaths.100
""""""""""""""""""""

:typoscript:`plugin.tx_fsmediagallery.view.partialRootPaths.100 =` :ref:`t3tsref:data-type-path`

Root path for the fluid **partials** of the plugin.


.. _plugin.tx_fsmediagallery.view.layoutRootPaths.100:

layoutRootPaths.100
"""""""""""""""""""

:typoscript:`plugin.tx_fsmediagallery.view.layoutRootPaths.100 =` :ref:`t3tsref:data-type-path`

Root path for the fluid **layouts** of the plugin.


.. _plugin.tx_fsmediagallery.persistence:

Extbase persistence layer
-------------------------

.. container:: ts-properties

   =========================== ================================================================== ======================= =================================================================
   Property                    Data type                                                          :ref:`t3tsref:stdwrap`  Default
   =========================== ================================================================== ======================= =================================================================
   `persistence.storagePid`_   :ref:`t3tsref:data-type-page-id` or :ref:`t3tsref:data-type-list`  no                      :typoscript:`{$plugin.tx_fsmediagallery.persistence.storagePid}`
   `persistence.recursive`_    :ref:`t3tsref:data-type-integer`                                   no                      :typoscript:`{$plugin.tx_fsmediagallery.persistence.recursive}`
   =========================== ================================================================== ======================= =================================================================


Property details
^^^^^^^^^^^^^^^^

.. _plugin.tx_fsmediagallery.persistence.storagePid:

persistence.storagePid
""""""""""""""""""""""

:typoscript:`plugin.tx_fsmediagallery.persistence.storagePid =` :ref:`t3tsref:data-type-page-id` or :ref:`t3tsref:data-type-list`

The Storage Folder which holds the Album Records.
Multiple foldes can be set using a comma separated list.


.. _plugin.tx_fsmediagallery.persistence.recursive:

persistence.recursive
"""""""""""""""""""""

:typoscript:`plugin.tx_fsmediagallery.persistence.recursive =` :ref:`t3tsref:data-type-integer`

| Recursion level of the :ref:`storagePid <plugin.tx_fsmediagallery.persistence.storagePid>` (startingpoint in flexform).
| ``0`` = no recursion (only items from Storage Folder are used)
| ``1`` ... ``255`` = subfolders of the Storage Folder will be used


.. _plugin.tx_fsmediagallery.settings:

General properties
------------------

The following table describes general settings for the plugin.
They are set by :typoscript:`plugin.tx_news.settings.<property>`

.. container:: ts-properties

   ==================================== ================================= ======================= ===================================================================================
   Property                             Data type                         :ref:`t3tsref:stdwrap`  Default
   ==================================== ================================= ======================= ===================================================================================
   `allowedAssetMimeTypes`_             :ref:`t3tsref:data-type-list`     no                      :typoscript:`{$plugin.tx_fsmediagallery.settings.allowedAssetMimeTypes}`
   `mediaAlbums`_                       :ref:`t3tsref:data-type-list`     no
   `overrideFlexformSettingsIfEmpty`_   :ref:`t3tsref:data-type-list`     no                      :typoscript:`{$plugin.tx_fsmediagallery.settings.overrideFlexformSettingsIfEmpty}`
   `useAlbumFilterAsExclude`_           :ref:`t3tsref:data-type-boolean`  no                      :code:`0`
   ==================================== ================================= ======================= ===================================================================================


Property details
^^^^^^^^^^^^^^^^

.. _plugin.tx_fsmediagallery.settings.overrideFlexformSettingsIfEmpty:

overrideFlexformSettingsIfEmpty
"""""""""""""""""""""""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.overrideFlexformSettingsIfEmpty =` :ref:`t3tsref:data-type-list`

Comma separated list of settings which are allowed to be set by TypoScript if the flexform value is empty.


.. _plugin.tx_fsmediagallery.settings.allowedAssetMimeTypes:

allowedAssetMimeTypes
"""""""""""""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.allowedAssetMimeTypes =` :ref:`t3tsref:data-type-list`

Comma separated list of mime types (if empty, all files are included)


.. _plugin.tx_fsmediagallery.settings.mediaAlbums:

mediaAlbums
"""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.mediaAlbums =` :ref:`t3tsref:data-type-list`

Album selection for ``nestedList`` and ``randomAsset`` views of the plugin (see :ref:`Display Mode <flexforms.mediagallery.tabs.general.mediaAlbums>`).


.. _plugin.tx_fsmediagallery.settings.useAlbumFilterAsExclude:

useAlbumFilterAsExclude
"""""""""""""""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.mediaAlbums =` :ref:`t3tsref:data-type-boolean`

| :code:`0` = Show only items defined in :ref:`settings.mediaAlbums <plugin.tx_fsmediagallery.settings.mediaAlbums>`
| :code:`1` = Exclude items defined in :ref:`settings.mediaAlbums <plugin.tx_fsmediagallery.settings.mediaAlbums>`


.. _plugin.tx_fsmediagallery.settings.list:

Properties for list view
------------------------

The following table describes the settings for the *list* view.
They are set by :typoscript:`plugin.tx_news.settings.list.<property>`

.. container:: ts-properties

   ================================================================================================== ============================================ ======================= ============
   Property                                                                                           Data type                                    :ref:`t3tsref:stdwrap`  Default
   ================================================================================================== ============================================ ======================= ============
   :ref:`hideEmptyAlbums <plugin.tx_fsmediagallery.settings.list.hideEmptyAlbums>`                    :ref:`t3tsref:data-type-boolean`             no                      :code:`1`
   :ref:`itemsPerPage <plugin.tx_fsmediagallery.settings.list.itemsPerPage>`                          :ref:`t3tsref:data-type-positive-integer`    no                      :code:`12`
   :ref:`skipListWhenOnlyOneAlbum <plugin.tx_fsmediagallery.settings.list.skipListWhenOnlyOneAlbum>`  :ref:`t3tsref:data-type-boolean`             no                      :code:`0`
   :ref:`thumb.width <plugin.tx_fsmediagallery.settings.list.thumb.width>`                            :ref:`t3tsref:data-type-pixels`              no                      :code:`180`
   :ref:`thumb.height <plugin.tx_fsmediagallery.settings.list.thumb.height>`                          :ref:`t3tsref:data-type-pixels`              no                      :code:`100`
   :ref:`thumb.resizeMode <plugin.tx_fsmediagallery.settings.list.thumb.resizeMode>`                  :ref:`t3tsref:data-type-string` ``[m|c|s]``  no                      :code:`m`
   ================================================================================================== ============================================ ======================= ============


Property details
^^^^^^^^^^^^^^^^

.. _plugin.tx_fsmediagallery.settings.list.itemsPerPage:

itemsPerPage
""""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.list.itemsPerPage =` :ref:`t3tsref:data-type-positive-integer`

Define how many items are shown on one page.


.. _plugin.tx_fsmediagallery.settings.list.thumb.width:

thumb.width
"""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.list.thumb.width =` :ref:`t3tsref:data-type-pixels`

Height of thumbnail images.


.. _plugin.tx_fsmediagallery.settings.list.thumb.height:

thumb.height
""""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.list.thumb.height =` :ref:`t3tsref:data-type-pixels`

Width of thumbnail images.


.. _plugin.tx_fsmediagallery.settings.list.thumb.resizeMode:

thumb.resizeMode
""""""""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.list.thumb.resizeMode =` :ref:`t3tsref:data-type-string` ``[m|c|s]``

| Defines how thumbnails in list view are scaled.
| :code:`m` = resize proportional; the proportions will be preserved and thus width/height are treated as maximum dimensions for the image. The image will be scaled to fit into width/height rectangle.
| :code:`c` = crop; the proportions will be preserved and the image will be scaled to fit around a rectangle with width/height dimensions. Then, a centered portion from inside of the image (size defined by width/height) will be cut out.
| :code:`s` = squeeze (unproportional exact fit); the proportions will *not* be preserved and the image will be unproportional scaled.


.. _plugin.tx_fsmediagallery.settings.list.hideEmptyAlbums:

hideEmptyAlbums
"""""""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.list.hideEmptyAlbums =` :ref:`t3tsref:data-type-boolean`

If :code:`1` (:code:`TRUE`) albums without media assets are excluded from list views.
See :ref:`settings.allowedAssetMimeTypes <plugin.tx_fsmediagallery.settings.allowedAssetMimeTypes>` to set which files should be included.


.. _plugin.tx_fsmediagallery.settings.list.skipListWhenOnlyOneAlbum:

skipListWhenOnlyOneAlbum
""""""""""""""""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.list.skipListWhenOnlyOneAlbum =` :ref:`t3tsref:data-type-boolean`

If :code:`1` (:code:`TRUE`) the nested album list view is skipped if only one album is to be displayed.


.. _plugin.tx_fsmediagallery.settings.album:

Properties for album view
-------------------------

The following table describes the settings for the *album* view.
They are set by :typoscript:`plugin.tx_news.settings.album.<property>`

.. container:: ts-properties

   ===================================================================================================== ============================================ ======================= =================
   Property                                                                                              Data type                                    :ref:`t3tsref:stdwrap`  Default
   ===================================================================================================== ============================================ ======================= =================
   :ref:`itemsPerPage <plugin.tx_fsmediagallery.settings.album.itemsPerPage>`                            :ref:`t3tsref:data-type-positive-integer`    no                      :code:`12`
   :ref:`lightbox.enable <plugin.tx_fsmediagallery.settings.album.lightbox.enable>`                      :ref:`t3tsref:data-type-boolean`             no                      :code:`1`
   :ref:`lightbox.jsPlugin <plugin.tx_fsmediagallery.settings.album.lightbox.jsPlugin>`                  :ref:`t3tsref:data-type-string`              no                      :code:`colorbox`
   :ref:`lightbox.relPrefix <plugin.tx_fsmediagallery.settings.album.lightbox.relPrefix>`                :ref:`t3tsref:data-type-string`              no                      :code:`albm_`
   :ref:`lightbox.styleClass <plugin.tx_fsmediagallery.settings.album.lightbox.styleClass>`              :ref:`t3tsref:data-type-string`              no                      :code:`lightbox`
   :ref:`lightbox.asset.width <plugin.tx_fsmediagallery.settings.album.lightbox.asset.width>`            :ref:`t3tsref:data-type-pixels`              no                      :code:`1920`
   :ref:`lightbox.asset.height <plugin.tx_fsmediagallery.settings.album.lightbox.asset.height>`          :ref:`t3tsref:data-type-pixels`              no                      :code:`1080`
   :ref:`lightbox.asset.resizeMode <plugin.tx_fsmediagallery.settings.album.lightbox.asset.resizeMode>`  :ref:`t3tsref:data-type-string` ``[m|c|s]``  no                      :code:`m`
   :ref:`thumb.width <plugin.tx_fsmediagallery.settings.album.thumb.width>`                              :ref:`t3tsref:data-type-pixels`              no                      :code:`120`
   :ref:`thumb.height <plugin.tx_fsmediagallery.settings.album.thumb.height>`                            :ref:`t3tsref:data-type-pixels`              no                      :code:`70`
   :ref:`thumb.resizeMode <plugin.tx_fsmediagallery.settings.album.thumb.resizeMode>`                    :ref:`t3tsref:data-type-string` ``[m|c|s]``  no                      :code:`m`
   ===================================================================================================== ============================================ ======================= =================


Property details
^^^^^^^^^^^^^^^^

.. _plugin.tx_fsmediagallery.settings.album.itemsPerPage:

itemsPerPage
""""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.album.itemsPerPage =` :ref:`t3tsref:data-type-positive-integer`

Define how many items are shown on one page.


.. _plugin.tx_fsmediagallery.settings.album.thumb.width:

thumb.width
"""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.album.thumb.width =` :ref:`t3tsref:data-type-pixels`

Height of thumbnail images.


.. _plugin.tx_fsmediagallery.settings.album.thumb.height:

thumb.height
""""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.album.thumb.height =` :ref:`t3tsref:data-type-pixels`

Width of thumbnail images.


.. _plugin.tx_fsmediagallery.settings.album.thumb.resizeMode:

thumb.resizeMode
""""""""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.album.thumb.resizeMode =` :ref:`t3tsref:data-type-string` ``[m|c|s]``

| Defines how thumbnails in album view are scaled.
| :code:`m` = resize proportional; the proportions will be preserved and thus width/height are treated as maximum dimensions for the image. The image will be scaled to fit into width/height rectangle.
| :code:`c` = crop; the proportions will be preserved and the image will be scaled to fit around a rectangle with width/height dimensions. Then, a centered portion from inside of the image (size defined by width/height) will be cut out.
| :code:`s` = squeeze (unproportional exact fit); the proportions will *not* be preserved and the image will be unproportional scaled.


.. _plugin.tx_fsmediagallery.settings.album.lightbox.enable:

lightbox.enable
"""""""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.album.lightbox.enable =` :ref:`t3tsref:data-type-boolean`

If :code:`1`, the album view does not link to detail view but displays media assets using a lightbox/colorbox.


.. _plugin.tx_fsmediagallery.settings.album.lightbox.styleClass:

lightbox.styleClass
"""""""""""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.album.lightbox.styleClass =` :ref:`t3tsref:data-type-string`

CSS class used for lightbox/colorbox elements.


.. _plugin.tx_fsmediagallery.settings.album.lightbox.relPrefix:

lightbox.relPrefix
""""""""""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.album.lightbox.relPrefix =` :ref:`t3tsref:data-type-string`

| Prefix used in ``rel`` attributes of lightbox/colorbox links.
| The default templates build ``rel`` attributes of lightbox/colorbox links like
  ``<a href="..." rel="{settings.album.lightbox.relPrefix}{mediaAlbum.uid}" ...>...</a>``.


.. _plugin.tx_fsmediagallery.settings.album.lightbox.jsPlugin:

lightbox.jsPlugin
"""""""""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.album.lightbox.jsPlugin =` :ref:`t3tsref:data-type-string`

Use this setting to e.g. render different lightbox/colorbox javascript code.


.. _plugin.tx_fsmediagallery.settings.album.lightbox.asset.width:

lightbox.asset.width
""""""""""""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.album.lightbox.asset.width =` :ref:`t3tsref:data-type-pixels`

Height of media assets used by lightbox/colorbox.


.. _plugin.tx_fsmediagallery.settings.album.lightbox.asset.height:

lightbox.asset.height
"""""""""""""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.album.lightbox.asset.height =` :ref:`t3tsref:data-type-pixels`

Width of media assets used by lightbox/colorbox.


.. _plugin.tx_fsmediagallery.settings.album.lightbox.asset.resizeMode:

lightbox.asset.resizeMode
"""""""""""""""""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.album.lightbox.asset.resizeMode =` :ref:`t3tsref:data-type-string` ``[m|c|s]``

| Defines how media assets used by lightbox/colorbox are scaled.
| :code:`m` = resize proportional; the proportions will be preserved and thus width/height are treated as maximum dimensions for the image. The image will be scaled to fit into width/height rectangle.
| :code:`c` = crop; the proportions will be preserved and the image will be scaled to fit around a rectangle with width/height dimensions. Then, a centered portion from inside of the image (size defined by width/height) will be cut out.
| :code:`s` = squeeze (unproportional exact fit); the proportions will *not* be preserved and the image will be unproportional scaled.


.. _plugin.tx_fsmediagallery.settings.detail:

Properties for detail view
--------------------------

The following table describes the settings for the *detail* view.
They are set by :typoscript:`plugin.tx_news.settings.detail.<property>`

.. container:: ts-properties

   ==================================================================================== ============================================ ======================= =============
   Property                                                                             Data type                                    :ref:`t3tsref:stdwrap`  Default
   ==================================================================================== ============================================ ======================= =============
   :ref:`asset.width <plugin.tx_fsmediagallery.settings.detail.asset.width>`            :ref:`t3tsref:data-type-pixels`              no                      :code:`1080`
   :ref:`asset.height <plugin.tx_fsmediagallery.settings.detail.asset.height>`          :ref:`t3tsref:data-type-pixels`              no                      :code:`1920`
   :ref:`asset.resizeMode <plugin.tx_fsmediagallery.settings.detail.asset.resizeMode>`  :ref:`t3tsref:data-type-string` ``[m|c|s]``  no                      :code:`m`
   ==================================================================================== ============================================ ======================= =============


Property details
^^^^^^^^^^^^^^^^

.. _plugin.tx_fsmediagallery.settings.detail.asset.width:

asset.width
"""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.detail.asset.width =` :ref:`t3tsref:data-type-pixels`

Height of media asset in detail view.


.. _plugin.tx_fsmediagallery.settings.detail.asset.height:

asset.height
""""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.detail.asset.height =` :ref:`t3tsref:data-type-pixels`

Width of media asset in detail view.


.. _plugin.tx_fsmediagallery.settings.detail.asset.resizeMode:

asset.resizeMode
""""""""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.detail.asset.resizeMode =` :ref:`t3tsref:data-type-string` ``[m|c|s]``

| Defines how media assets in detail view are scaled.
| :code:`m` = resize proportional; the proportions will be preserved and thus width/height are treated as maximum dimensions for the image. The image will be scaled to fit into width/height rectangle.
| :code:`c` = crop; the proportions will be preserved and the image will be scaled to fit around a rectangle with width/height dimensions. Then, a centered portion from inside of the image (size defined by width/height) will be cut out.
| :code:`s` = squeeze (unproportional exact fit); the proportions will *not* be preserved and the image will be unproportional scaled.


.. _plugin.tx_fsmediagallery.settings.random:

Properties for random view
--------------------------

The following table describes the settings for the *random* view.
They are set by :typoscript:`plugin.tx_news.settings.random.<property>`

.. container:: ts-properties

   ==================================================================================== ============================================ ======================= =============
   Property                                                                             Data type                                    :ref:`t3tsref:stdwrap`  Default
   ==================================================================================== ============================================ ======================= =============
   :ref:`targetPid <plugin.tx_fsmediagallery.settings.random.targetpid>`                :ref:`t3tsref:data-type-page-id`             no
   :ref:`thumb.width <plugin.tx_fsmediagallery.settings.random.thumb.width>`            :ref:`t3tsref:data-type-pixels`              no                      :code:`1080`
   :ref:`thumb.height <plugin.tx_fsmediagallery.settings.random.thumb.height>`          :ref:`t3tsref:data-type-pixels`              no                      :code:`1920`
   :ref:`thumb.resizeMode <plugin.tx_fsmediagallery.settings.random.thumb.resizeMode>`  :ref:`t3tsref:data-type-string` ``[m|c|s]``  no                      :code:`m`
   ==================================================================================== ============================================ ======================= =============


Property details
^^^^^^^^^^^^^^^^

.. _plugin.tx_fsmediagallery.settings.random.targetPid:

targetPid
"""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.random.targetPid =` :ref:`t3tsref:data-type-page-id`

.. todo: add a link to controller actions of plugins

Target page a random assets should link to.
Select a page on which a plugin is configured to display the full album.


.. _plugin.tx_fsmediagallery.settings.random.thumb.width:

thumb.width
"""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.random.thumb.width =` :ref:`t3tsref:data-type-pixels`

Height of thumbnail images of random media assets.


.. _plugin.tx_fsmediagallery.settings.random.thumb.height:

thumb.height
""""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.random.thumb.height =` :ref:`t3tsref:data-type-pixels`

Width of thumbnail images of random media assets.


.. _plugin.tx_fsmediagallery.settings.random.thumb.resizeMode:

thumb.resizeMode
""""""""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.random.thumb.resizeMode =` :ref:`t3tsref:data-type-string` ``[m|c|s]``

| Defines how thumbnails of random media assets are scaled.
| :code:`m` = resize proportional; the proportions will be preserved and thus width/height are treated as maximum dimensions for the image. The image will be scaled to fit into width/height rectangle.
| :code:`c` = crop; the proportions will be preserved and the image will be scaled to fit around a rectangle with width/height dimensions. Then, a centered portion from inside of the image (size defined by width/height) will be cut out.
| :code:`s` = squeeze (unproportional exact fit); the proportions will *not* be preserved and the image will be unproportional scaled.


.. _plugin.tx_fsmediagallery.settings.pagination:

Properties for pagination
-------------------------

The following table describes the settings for the *pagination* in list and album view.
They are set by :typoscript:`plugin.tx_news.settings.pagination.<property>`

.. container:: ts-properties

   ================================================================================================ =================================================== ======================= ===========
   Property                                                                                         Data type                                           :ref:`t3tsref:stdwrap`  Default
   ================================================================================================ =================================================== ======================= ===========
   :ref:`insertAbove <plugin.tx_fsmediagallery.settings.pagination.insertAbove>`                    :ref:`t3tsref:data-type-boolean`                    no                      :code:`0`
   :ref:`insertBelow <plugin.tx_fsmediagallery.settings.pagination.insertBelow>`                    :ref:`t3tsref:data-type-boolean`                    no                      :code:`1`
   :ref:`pagesBefore <plugin.tx_fsmediagallery.settings.pagination.pagesBefore>`                    :ref:`t3tsref:data-type-positive-integer` or ``0``  no                      :code:`4`
   :ref:`pagesAfter <plugin.tx_fsmediagallery.settings.pagination.pagesAfter>`                      :ref:`t3tsref:data-type-positive-integer` or ``0``  no                      :code:`4`
   :ref:`maximumNumberOfLinks <plugin.tx_fsmediagallery.settings.pagination.maximumNumberOfLinks>`  :ref:`t3tsref:data-type-positive-integer`           no                      :code:`10`
   ================================================================================================ =================================================== ======================= ===========


Property details
^^^^^^^^^^^^^^^^

.. _plugin.tx_fsmediagallery.settings.pagination.insertAbove:

insertAbove
"""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.pagination.insertAbove =` :ref:`t3tsref:data-type-boolean`

Set it to ``1`` (``TRUE``) or ``0`` (``FALSE``) to either show or hide the pagination before an item list.

.. _plugin.tx_fsmediagallery.settings.pagination.insertBelow:

insertBelow
"""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.pagination.insertBelow =` :ref:`t3tsref:data-type-boolean`

Set it to ``1`` (``TRUE``) or ``0`` (``FALSE``) to either show or hide the pagination after an item list.

.. _plugin.tx_fsmediagallery.settings.pagination.pagesBefore:

pagesBefore
"""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.pagination.pagesBefore =` :ref:`t3tsref:data-type-positive-integer` or ``0``

Number of page links before the current page.


.. _plugin.tx_fsmediagallery.settings.pagination.pagesAfter:

pagesAfter
""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.pagination.pagesAfter =` :ref:`t3tsref:data-type-positive-integer` or ``0``

Number of page links after the current page.


.. _plugin.tx_fsmediagallery.settings.pagination.maximumNumberOfLinks:

maximumNumberOfLinks
""""""""""""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.pagination.maximumNumberOfLinks =` :ref:`t3tsref:data-type-positive-integer`

Force this number of page browser links on the screen.
An odd number is recommended because it looks more symmetrical.


.. _plugin.tx_fsmediagallery.settings.features:

Other Properties
----------------

They properties in the following table are set by :typoscript:`plugin.tx_news.settings.<property>`

.. container:: ts-properties

   ======================================================================================================= ================================= ======================= ===========
   Property                                                                                                Data type                         :ref:`t3tsref:stdwrap`  Default
   ======================================================================================================= ================================= ======================= ===========
   :ref:`features.skipDefaultArguments <plugin.tx_fsmediagallery.settings.features.skipDefaultArguments>`  :ref:`t3tsref:data-type-boolean`  no                      :code:`1`
   ======================================================================================================= ================================= ======================= ===========


Property details
^^^^^^^^^^^^^^^^

.. _plugin.tx_fsmediagallery.settings.features.skipDefaultArguments:

skipDefaultArguments
""""""""""""""""""""

:typoscript:`plugin.tx_fsmediagallery.settings.features.skipDefaultArguments =` :ref:`t3tsref:data-type-boolean`

todo: add description
