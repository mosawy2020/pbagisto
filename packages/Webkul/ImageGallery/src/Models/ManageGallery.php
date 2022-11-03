<?php

namespace Webkul\ImageGallery\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\ImageGallery\Models\ManageGalleryProxy;
use Webkul\ImageGallery\Contracts\ManageGallery as ManageGalleryContract;
use Webkul\Core\Eloquent\TranslatableModel;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Webkul\ImageGallery\Repositories\ManageGalleryRepository;

class ManageGallery extends TranslatableModel implements ManageGalleryContract
{
    //
    protected $fillable = [
        
        'gallery_code',
        'image_ids',
        'thumbnail_image_id',
        'status',
        'brands'
    ];





    
    public $translatedAttributes = [
        'title',
        'description'
        
    ];

    protected $with = ['translations'];

}
