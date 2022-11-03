<?php

namespace Webkul\Notification\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Notification\Contracts\FcmTranslation as FcmTranslationContract;

class FcmTranslation extends Model implements FcmTranslationContract
{
    public $timestamps = false;

    protected $fillable = ['content','title'];
}