<?php

namespace Webkul\Product\Helpers;

class View extends AbstractProduct
{
    /**
     * Returns the visible custom attributes
     *
     * @param  \Webkul\Product\Contracts\Product|\Webkul\Product\Contracts\ProductFlat  $product
     * @return void|array
     */
    public function getAdditionalData($product)
    {
        $data = [];
        $familyData = [];

        $attributes = $product->attribute_family->custom_attributes()->where('attributes.is_visible_on_front', 1)->get();
        $attributeOptionReposotory = app('Webkul\Attribute\Repositories\AttributeOptionRepository');
        $attributeGroups = $product->attribute_family->attribute_groups()->where('is_user_defined',1)->get();

        foreach($attributeGroups as $group){
            $group['values'] = $group->custom_attributes()->get();
           array_push($familyData, $group);

        }

        foreach($familyData as $family){
            $data = [];
            foreach ($family->values as $attribute) {
                if ($product instanceof \Webkul\Product\Models\ProductFlat) {
                    $value = $product->product->{$attribute->code};
                } else {
                    $value = $product->{$attribute->code};
                }

                if ($attribute->type == 'boolean') {
                    $value = $value ? 'Yes' : 'No';
                } elseif($value) {
                    if ($attribute->type == 'select') {
                        $attributeOption = $attributeOptionReposotory->find($value);

                        if ($attributeOption) {
                            $value = $attributeOption->label ?? null;

                            if (! $value) {
                                continue;
                            }
                        }
                    } elseif ($attribute->type == 'multiselect' || $attribute->type == 'checkbox') {
                        $lables = [];

                        $attributeOptions = $attributeOptionReposotory->findWhereIn('id', explode(",", $value));

                        foreach ($attributeOptions as $attributeOption) {
                            if ($label = $attributeOption->label) {
                                $lables[] = $label;
                            }
                        }

                        $value = implode(", ", $lables);
                    }
                }

                $data[] = [
                    'id'         => $attribute->id,
                    'code'       => $attribute->code,
                    'label'      => $attribute->name,
                    'value'      => $value,
                    'admin_name' => $attribute->admin_name,
                    'type'       => $attribute->type,
                ];
                $family['values'] = $data;

            }
        }

        return $familyData;
    }
}