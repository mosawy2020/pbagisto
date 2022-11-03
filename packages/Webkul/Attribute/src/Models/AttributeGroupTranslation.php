<?php

namespace Webkul\Attribute\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Attribute\Contracts\AttributeGroupTranslation as AttributeGroupTranslationContract;
use Webkul\Core\Eloquent\TranslatableModel;

class AttributeGroupTranslation extends model implements AttributeGroupTranslationContract
{
    public $timestamps = false;

    protected $fillable = ['title'];

    /**
     * Get the attributes that owns the attribute group.
     */

}