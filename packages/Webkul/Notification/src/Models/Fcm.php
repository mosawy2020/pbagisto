<?php

namespace Webkul\Notification\Models;

use Illuminate\Support\Facades\Storage;
use Webkul\Core\Eloquent\TranslatableModel;
use Illuminate\Database\Eloquent\Model;
use Webkul\Customer\Models\CustomerGroup;
use Webkul\Notification\Contracts\Fcm as FcmContract;

class Fcm extends TranslatableModel implements FcmContract
{
    public $translatedAttributes = [
        'content',
        'title'
    ];
    protected $fillable = [
        'customer_group_id'
    ];
    protected $appends = ['image_url'] ;

    /**
     * Get Order Details.
     */
    //TODO loadrelations
    public function customerGroup()
    {

        return $this->belongsTo(CustomerGroup::class);
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return;
        }

        return Storage::url($this->image);
    }


}