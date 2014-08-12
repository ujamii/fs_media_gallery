.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _configuration-extConf:

Extension Manager
=================

Target group: **Developers**

EXT:fs_media_gallery offers some basic configuration inside the Extension Manager.
To set this configuration, switch to the Extension Manager, search for the extension
*fs_media_gallery* and click on it to open the configuration view.


.. container:: ts-properties

   ======================================================================================== ============================== ===================================================================
   Property                                                                                 Data type                      Default
   ======================================================================================== ============================== ===================================================================
   :ref:`allowedActionsInFlexforms <extConf.tx_fsmedia_gallery.allowedActionsInFlexforms>`  :ref:`t3tsref:data-type-list`  nestedList,flatList,showAlbumByParam,showAlbumByConfig,randomAsset
   :ref:`list.flat.orderOptions <extConf.tx_fsmedia_gallery.list.flat.orderOptions>`        :ref:`t3tsref:data-type-list`  datetime,crdate,sorting
   ======================================================================================== ============================== ===================================================================


Property details
^^^^^^^^^^^^^^^^

.. _extConf.tx_fsmedia_gallery.allowedActionsInFlexforms:

allowedActionsInFlexforms
"""""""""""""""""""""""""

Defines plugin actions shown in flexforms so you can disable unwanted plugin modes.
Comma separated list of controller actions which could be selected as
":ref:`Display mode <flexforms.mediagallery.tabs.general.displayMode>`" in flexforms.
Available actions are:

* nestedList
* flatList
* showAlbumByParam
* showAlbumByConfig
* randomAsset

If no action is defined, *all* available actions are selectable.


.. _extConf.tx_fsmedia_gallery.list.flat.orderOptions:

list.flat.orderOptions
""""""""""""""""""""""

Comma separated list of sort options for field ":ref:`Sort albums list by <flexforms.mediagallery.tabs.general.list.flat.orderBy>`" in flexforms.
Available actions are:

* datetime
* crdate
* sorting


.. todo: add screenshot of EM config
