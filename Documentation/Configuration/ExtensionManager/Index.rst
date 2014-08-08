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
   ======================================================================================== ============================== ===================================================================


Property details
^^^^^^^^^^^^^^^^

.. _extConf.tx_fsmedia_gallery.allowedActionsInFlexforms:

allowedActionsInFlexforms
"""""""""""""""""""""""""

Defines plugin actions shown in flexforms so you can disable unwanted plugin modes.
Comma separated list of controller actions which could be selected as plugin action in flexforms.
Available actions are:

* nestedList
* flatList
* showAlbumByParam
* showAlbumByConfig
* randomAsset

If no action is defined, *all* available actions are selectable.

.. todo: add screenshot of EM config
