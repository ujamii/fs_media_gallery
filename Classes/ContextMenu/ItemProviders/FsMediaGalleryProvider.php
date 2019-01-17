<?php
namespace MiniFranske\FsMediaGallery\ContextMenu\ItemProviders;

use TYPO3\CMS\Backend\ContextMenu\ItemProviders\AbstractProvider;

class FsMediaGalleryProvider extends AbstractProvider
{
    protected $itemsConfiguration = [
        'new' => [
            'label' => 'Add Album',
            'iconIdentifier' => 'action-add-album',
            'callbackAction' => 'createFile'
        ],
    ];

    /**
     * @return bool
     */
    public function canHandle(): bool
    {
        return $this->table === 'sys_file';
    }


}