mod.wizards {
    newContentElement {
        wizardItems {
            plugins {
                elements {
                    fsmediagallery_mediagallery {
                        icon = ../typo3conf/ext/fs_media_gallery/Resources/Public/Icons/plugin.png
                        title = LLL:EXT:fs_media_gallery/Resources/Private/Language/locallang_be.xlf:plugin.title
                        description = LLL:EXT:fs_media_gallery/Resources/Private/Language/locallang_be.xlf:plugin.description
                        tt_content_defValues {
                            CType = list
                            list_type = fsmediagallery_mediagallery
                        }
                    }
                }
            }
        }
    }
}