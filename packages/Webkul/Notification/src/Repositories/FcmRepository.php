<?php

namespace Webkul\Notification\Repositories;

use Illuminate\Support\Facades\Storage;
use Webkul\Core\Eloquent\Repository;
use Webkul\Customer\Models\Customer;
use Webkul\Notification\Http\Notifications\FcmNotification;
use Webkul\Notification\Models\DeviceToken;

class FcmRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Webkul\Notification\Contracts\Fcm';
    }

    /**
     * Return Filtered Notification resources
     *
     * @return objects
     */
    public function create($data)
    {
        if (isset($data['locale']) && $data['locale'] == 'all') {
            $model = app()->make($this->model());

            foreach (core()->getAllLocales() as $locale) {
                foreach ($model->translatedAttributes as $attribute) {
                    if (isset($data[$attribute])) {
                        $data[$locale->code][$attribute] = $data[$attribute];
                        $data[$locale->code]['locale_id'] = $locale->id;
                    }
                }
            }
        }
        return $this->model->create($data);
    }

    private function setSameAttributeValueToAllLocale(array $data, ...$attributeNames)
    {
        $requestedLocale = core()->getRequestedLocaleCode();
        $model = app()->make($this->model());

        foreach ($attributeNames as $attributeName) {
            foreach (core()->getAllLocales() as $locale) {
                foreach ($model->translatedAttributes as $attribute) {
                    if ($attribute === $attributeName) {
                        $data[$locale->code][$attribute] = isset($data[$requestedLocale][$attribute])
                            ? $data[$requestedLocale][$attribute]
                            : $data[$data['locale']][$attribute];
                    }
                }
            }
        }

        return $data;
    }

    public function uploadImages($data, $category, $type = 'image')
    {
        if (isset($data[$type])) {
            $request = request();
            $category = $this->find($category);
            foreach ($data[$type] as $imageId => $image) {
                $file = $type . '.' . $imageId;
                $dir = 'fcm/' . $category->id;

                if ($request->hasFile($file)) {
                    if ($category->{$type}) {
                        Storage::delete($category->{$type});
                    }

                    $category->{$type} = $request->file($file)->store($dir);
                    $category->save();
                }
            }
        } else {
            if ($category->{$type}) {
                Storage::delete($category->{$type});
            }

            $category->{$type} = null;
            $category->save();
        }
    }

    public function update($data, $id, $send = false)
    {

        $fcm = $this->find($id);
        $res = $fcm->fill($data)->save();
        $fcm->load("customergroup.customers.deviceTokens");
        $locale = app()->getLocale();
        // send fcm
        if ($send) {
            if ($data["customer_group_id"] === null) {
                $user = new Customer([], true);
                $user->notify(new FcmNotification(@$data["$locale"]["title"], @$data["$locale"]["content"], @$data["image"]));
            } else if (isset($fcm->customergroup?->customers))
                foreach ($fcm->customergroup?->customers as $customer) {
                    $notification = $customer->notify(new FcmNotification(@$data["$locale"]["title"], @$data["$locale"]["content"], @$data["image"]));
                }
        }


        $data = $this->setSameAttributeValueToAllLocale($data, ['title', 'content']);
        return $res;
    }
}