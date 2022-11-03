<?php

namespace Webkul\CMS\Models;

use Webkul\Core\Eloquent\TranslatableModel;
use Webkul\CMS\Contracts\CmsPage as CmsPageContract;
use Webkul\Core\Models\ChannelProxy;

class CmsPage extends TranslatableModel implements CmsPageContract
{
    protected $fillable = ['layout','image'];

    public $translatedAttributes = [
        'content',
        'meta_description',
        'meta_title',
        'page_title',
        'meta_keywords',
        'faqs',
        'content_title',
        'html_content',
        'url_key',
    ];

    protected $with = ['translations'];

    /**
     * Get the channels.
     */
    public function channels()
    {
        return $this->belongsToMany(ChannelProxy::modelClass(), 'cms_page_channels');
    }
}