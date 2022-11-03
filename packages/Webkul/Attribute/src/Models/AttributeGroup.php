<?php

namespace Webkul\Attribute\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Attribute\Contracts\AttributeGroup as AttributeGroupContract;
use Webkul\Core\Eloquent\TranslatableModel;

class AttributeGroup extends TranslatableModel implements AttributeGroupContract
{
    public $timestamps = false;

    protected $fillable = ['name', 'position', 'is_user_defined'];
    public $translatedAttributes = ['title'];

    /**
     * Get the attributes that owns the attribute group.
     */
    public function custom_attributes()
    {
        return $this->belongsToMany(AttributeProxy::modelClass(), 'attribute_group_mappings')
                    ->withPivot('position')
                    ->orderBy('pivot_position', 'asc');
    }
}