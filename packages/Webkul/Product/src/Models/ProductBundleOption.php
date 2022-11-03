<?php

namespace Webkul\Product\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Webkul\Core\Eloquent\TranslatableModel;
use Webkul\Product\Contracts\ProductBundleOption as ProductBundleOptionContract;

class ProductBundleOption extends TranslatableModel implements ProductBundleOptionContract
{
    use HasFactory , Translatable ;
    public $timestamps = false;

    public $translatedAttributes = ['label'];

    // protected $with = ['translations'];

    protected $fillable = [
        'type',
        'is_required',
        'sort_order',
        'product_id',
         'max_count'
    ];

    /**
     * Get the product that owns the image.
     */
    public function product()
    {
        return $this->belongsTo(ProductProxy::modelClass());
    }

    /**
     * Get the bundle option products that owns the bundle option.
     */
    public function bundle_option_products()
    {
        return $this->hasMany(ProductBundleOptionProductProxy::modelClass());
    }
}