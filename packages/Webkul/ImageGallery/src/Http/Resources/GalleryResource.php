<?php

 namespace Webkul\ImageGallery\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Webkul\ImageGallery\Models\ImageGallery;

use Illuminate\Support\Facades\Storage;
class GalleryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       // return parent::toArray($request);

$arr=[];

       if(isset($this->image_ids))

       {
        $images=explode(',',$this->image_ids);
        foreach($images as $image)

        $arr[]=Storage::url(ImageGallery::find($image)->image);
       }

return [



'id'=>$this->id,
'title'=>$this->title,
'description'=>$this->description,
'images'=>$arr




];
   
       
    }
}
