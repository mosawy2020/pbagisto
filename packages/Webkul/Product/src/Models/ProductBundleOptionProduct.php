<?php

namespace Webkul\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Product\Helpers\ConfigurableOption;
use Webkul\Product\Contracts\ProductBundleOptionProduct as ProductBundleOptionProductContract;

class ProductBundleOptionProduct extends Model implements ProductBundleOptionProductContract
{
    public $timestamps = false;
    
    protected $fillable = [
        'qty',
        'is_user_defined',
        'sort_order',
        'is_default',
        'product_bundle_option_id',
        'product_id',
    ];

    /**
     * Get the bundle option that owns this resource.
     */
    public function bundle_option()
    {
        return $this->belongsTo(ProductBundleOptionProxy::modelClass());
    }

    /**
     * Get the product that owns the image.
     */
    public function product()
    {
        return $this->belongsTo(ProductProxy::modelClass());
    }



// public function products(){

// $confg_product=[];
// $arr=[];
// $products=Product::where("id",$this->product_id)->get();

// foreach($products as $product)
// {
// $defaultVariant = $product->getTypeInstance()->getDefaultVariant();
// $config = ConfigurableOption->getConfigurationConfig($product);
// $galleryImages = productimage()->getGalleryImages($product);

// $confg_product=[$defaultVariant,$config,$galleryImages];

// $arr[]=$confg_product;
// }


// return $arr;




// }



}
