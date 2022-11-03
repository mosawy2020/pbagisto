<?php

namespace Webkul\ImageGallery\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageGalleryTranslation extends Model
{
    use HasFactory;
    public $fillable = [
        'title',
        'description'
        
    ];

    
}




