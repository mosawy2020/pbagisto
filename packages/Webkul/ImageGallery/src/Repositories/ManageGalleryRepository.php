<?php

namespace Webkul\ImageGallery\Repositories;

use Illuminate\Container\Container as App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Event;
use Webkul\Core\Eloquent\Repository;
use Webkul\ImageGallery\Models\ManageGallery;
use Webkul\ImageGallery\Models\ImageGallery;
use Webkul\ImageGallery\Models\ManageGalleryProxy;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class ManageGalleryRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'Webkul\ImageGallery\Models\ManageGallery';
    }

    public function create(array $data)
    {
        $model=$this->getModel();;
        foreach (core()->getAllLocales() as $locale) {
            foreach ($model->translatedAttributes as $attribute) {
                if (isset($data[$attribute])) {
                    $data[$locale->code][$attribute] = $data[$attribute];
                }
            }

                  }





                //   dd($data['brands']) ;
                  if(isset($data['brands']))
                  {


                     foreach ($data['brands'] as $index => $image) {
// dd($image) ;
                         $data['brands'][$index] = $this->uploadImage($image,null,'gallary');
                        //  $data['brands'][$index]

                  }

                  $data['brands']=json_encode($data['brands']);
                 }
                //  else
                //  unset($data['brands']);

        $managegallery = $this->model->create($data);
        // dd($managegallery) ;

        return $managegallery;
    }


    public function getCategoryTree($id = null)
    {
        return $id
               ? $this->model::orderBy('id', 'ASC')->where('id', '!=', $id)->get()
               : $this->model::orderBy('id', 'ASC')->get();
    }

    public function getCategoryTreeForShopImage($id = null)
    {

        $images = ManageGallery::where('id', $id)->get();
// dd($images);
        foreach ($images as $image) {

            $string[] = $image->image_ids;
        }
        // dd($str/ing) ;

        foreach ($string as $str) {
            $strarr[] = array_map('intval', explode(',', $str));
        }


        foreach ($images as $key => $image) {
            $image->image_ids = $strarr[$key];
        }
      $images =  $this-> __get($images);
        // foreach ($images as $key => $image) {

        //     if (!in_array($image->thumbnail_image_id, $image->image_ids, TRUE))
        //     {
        //     array_unshift($image->image_ids,$image->thumbnail_image_id);
        //     }
        // }

        return $images;
    }

    public function &__get($images)
  { $newimages = [] ;
    foreach ($images as $key => $image) {
$arr = $image ;
$curids = $arr->image_ids ;
        if (!in_array($image->thumbnail_image_id, $image->image_ids, TRUE))
        {
        array_unshift($curids,$image->thumbnail_image_id);
        }
        $arr->image_ids = $curids ;
        $newimages[$key] = $arr ;
    }
    return $newimages ;
   }

    public function getCategoryTreeForShop($id = null)
    {
         $managegalleries= $id
               ? $this->model::orderBy('id', 'ASC')->where('id', '!=', $id)->get()
               : $this->model::orderBy('id', 'ASC')->get();

        if(sizeof($managegalleries)<=0)
        {
            return redirect()->back();
        }

        foreach ($managegalleries as $managegallery) {
            $string[] = $managegallery->image_ids;
        }

        foreach ($string as $str) {
            $strarr[] = array_map('intval', explode(',', $str));
        }

        foreach ($managegalleries as $key => $managegallery) {
            $managegallery->image_ids = $strarr[$key];
        }

        return $managegalleries;
    }


    public function getCategoryTreeWithoutDescendant($id = null)
    {
        return $id
               ? $this->model::orderBy('id', 'ASC')->where('id', '!=', $id)->get()
               : $this->model::orderBy('id', 'ASC')->get();
    }



    public function isSlugUnique($id, $slug)
    {
        $exists = ManageGalleryProxy::modelClass()::where('id', '<>', $id)
            ->where('slug', $slug)
            ->limit(1)
            ->select(DB::raw(1))
            ->exists();

        return $exists ? false : true;
    }


    public function update(array $data, $id, $attribute = "id")
    {
        $category = $this->find($id);

$brands=json_decode($category->brands,true);


//dd(request());

        if(isset($data['brands']))
        {


           foreach ($data['brands'] as $index => $image) {

            if(isset($brands[$index]) )
          {
             if( $data['brands'][$index]==null)
             {

                $data['brands'][$index]=$brands[$index];
             } else
             $data['brands'][$index] = $this->uploadImage($image,null,'gallary');



            }
            else
               $data['brands'][$index] = $this->uploadImage($image,null,'gallary');


        }
    //dd($data['brands']);



        $data['brands']=json_encode($data['brands']);
       }else
       unset($data['brands']);






        $category->update($data);

        return $category;
    }


    public function uploadImageIds($data, $managegallery, $type = "array")
    {
        if (isset($data[$type])) {
            $request = request();

            foreach ($data[$type] as $imageId => $image) {
                $file = $type . '.' . $imageId;
                $dir = 'managegallery/' . $managegallery->id;

                if ($request->hasFile($file)) {
                    if ($managegallery->{$type}) {
                        Storage::delete($managegallery->{$type});
                    }

                    $managegallery->{$type} = $request->file($file)->store($dir);
                    $managegallery->save();
                }
            }
        } else {
            if ($managegallery->{$type}) {
                Storage::delete($managegallery->{$type});
            }

            $managegallery->{$type} = null;
            $managegallery->save();
        }
    }






    public function uploadImage($file,$image_path=null,$dir){


        if (is_file($file)) {
            if(isset($image_path['image_1'])){
                    Storage::delete($image_path['image_1']);
                 }

                // File::delete(public_path('storage/'.$image_path['image_1']));

                // dd($image_path);
                $image      = $file;
                $image_name = time() . '.' . $image->extension();


                $path = $image->store(($dir . $image_name));



                return $path;
            }
        }


    // /**
    //  * @param  array|null  $columns
    //  * @return array
    //  */
    // public function getPartial($columns = null)
    // {
    //     $categories = $this->model->all();

    //     $trimmed = [];

    //     foreach ($categories as $key => $category) {
    //         if ($category->name != null || $category->name != "") {
    //             $trimmed[$key] = [
    //                 'id'   => $category->id,
    //                 'name' => $category->name,
    //                 'slug' => $category->slug,
    //             ];
    //         }
    //     }

    //     return $trimmed;
    // }
}