@if ($product->type == 'bundle')
    @push('css')
        <style type="text/css">
            .bundle-options-wrapper .bundle-option-list {
                border: unset;
            }
            .bundle-option-item .radio input {
                top: 4px;
            }
        </style>
    @endpush
    {{-- {{ dd(app('Webkul\Product\Helpers\BundleOption')->getBundleConfig($product)) }} --}}

    {!! view_render_event('bagisto.shop.products.view.bundle-options.before', ['product' => $product]) !!}
    {{-- {{ dd(   json_encode(app('Webkul\Product\Helpers\BundleOption')->getBundleConfig($product))     )}} --}}
    <div id="shimmer-list" class="shimmer-list">
      @foreach (range(0, 7) as $item )
        <div class="shimmer-wrapper">
          <div class="shimmer-attributes shimmer-animate"></div>
        </div>
      @endforeach
    </div>
    <bundle-option-list></bundle-option-list>


    {!! view_render_event('bagisto.shop.products.view.bundle-options.after', ['product' => $product]) !!}

    @push('scripts')
        <script type="text/x-template" id="bundle-option-list-template">

            <div class="col-12 bundle-options-wrapper">
                <input  name="bundle_options" type="hidden" ref="bundle_options" >

                <div class="bundle-option-list">
                    <bundle-option-item
                        @get-selected="getSelected"
                        v-for="(option, index) in options"
                        :option="option"
                        :key="index"
                        :index="index"
                        @onProductSelected="productSelected(option, $event)">
                    </bundle-option-item>
                </div>

                <!--<div class="bundle-summary">


                    <quantity-changer quantity-text="{{ __('shop::app.products.quantity') }}"></quantity-changer>

                    <div class="control-group">
                        <label>{{ __('shop::app.products.total-amount') }}</label>

                        <div class="bundle-price no-margin">
                            @{{ formated_total_price | currency(currency_options) }}
                        </div>
                    </div>

                    <ul type="none" class="bundle-items">
                        <li v-for="(option, index) in options">
                            @{{ option.label }}

                            <div class="selected-products">
                                <div v-for="(product, index1) in option.products" v-if="product.is_default">
                                    @{{ product.qty + ' x ' + product.name }}
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>-->
                <div class="add-to-cart-qty-wrapper">
                    <h3 class="mb10">{{ __('shop::app.products.your-customization') }}</h3>
                    <div class="qty-wrapper">
                        <i class="qty-icon">
                          <svg enable-background="new 0 0 28 27.1" version="1.1" viewBox="0 0 28 27.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                            <path class="st0" d="m21.3 26.6c0 0.3 0.1 0.4 0.1 0.4s0.1 0.1 0.4 0c2-0.3 3.9-0.6 5.9-0.9 0.3 0 0.3-0.1 0.3-0.4v-5.9c0-0.4-0.1-0.4-0.4-0.4h-3.3-4.7c-0.3 0-0.5-0.1-0.7-0.3-1.5-1.3-3.4-1.4-5.2-0.3-0.3 0.2-0.5 0.2-0.9 0.2h-1.2-0.2-2.1-0.1c-1 0-1.5 0.4-1.8 1.2l-0.1 0.2-0.3 0.1c-0.2 0-0.3-0.2-0.3-0.2l-3.1-3.1c-0.5-0.5-1.1-0.7-1.8-0.5-0.6 0.1-1.2 0.5-1.5 1.1-0.1 0.1-0.1 0.2-0.1 0.4 0 0.1-0.1 0.2-0.1 0.3v0.6c0.1 0.6 0.5 1.1 0.9 1.5 1.5 1.7 2.8 3.1 4.1 4.3 1.5 1.6 3.4 2.3 5.5 2.3h0.8c0.7 0 1.5 0 2.2-0.1 1.3-0.1 2.3-0.5 3.1-1.1 1.2-0.9 2.6-1.4 4.1-1.6h0.1c0.1 0 0.2 0 0.3 0.1s0.1 0.3 0.1 0.4v1.2 0.5zm0.7-6.5c0.1-0.1 0.3-0.1 0.4-0.1h4.5c0.2 0 0.3 0 0.4 0.1s0.1 0.3 0.1 0.4v4.6c0 0.4-0.3 0.5-0.5 0.6-1.5 0.2-3 0.5-4.6 0.7h-0.1c-0.1 0-0.2 0-0.3-0.1s-0.1-0.3-0.1-0.4v-2-0.7-0.9-1.8c0-0.1 0.1-0.2 0.2-0.4m-1.2 3.7c-1.6 0.1-3.1 0.7-4.5 1.7-0.8 0.5-1.7 0.9-2.8 1-0.4 0-0.8 0.1-1.4 0.1h-0.8-0.8-0.1c-2 0-3.7-0.7-5.1-2.2-0.9-0.9-1.8-1.8-2.7-2.9-0.6-0.6-1.2-1.3-1.8-1.9-0.4-0.5-0.5-1-0.3-1.6 0.2-0.5 0.7-0.9 1.3-0.9 0.5 0 0.9 0.1 1.3 0.5l2.2 2.2c0.9 0.9 1.8 1.8 2.7 2.8 0.2 0.2 0.3 0.2 0.5 0.2h1.1 1.3 0.8c0.3 0 0.4-0.1 0.4-0.3 0-0.1 0-0.1-0.1-0.2s-0.2-0.1-0.3-0.1h-0.7-1.8-0.1c-0.5 0-0.9-0.2-1.2-0.6-0.2-0.4-0.4-0.8-0.2-1.3 0.3-0.6 0.9-0.6 1.1-0.6h1.4 1 1.5c0.3 0 0.6 0 0.8-0.2s0.5-0.3 0.7-0.4c1.5-0.7 3.1-0.4 4.2 0.8 0.5 0.1 0.6 0.1 0.8 0.1h0.6 0.3 0.7c0.1 0 0.3 0 0.4 0.1s0.1 0.3 0.1 0.4v2.8c0 0.3-0.2 0.5-0.5 0.5"/>
                            <path class="st0" d="m18.3 3.8c0-2.1-1.7-3.8-3.8-3.8-1 0-2 0.4-2.7 1.1s-1.1 1.7-1.1 2.7c0 2.1 1.7 3.8 3.8 3.8 1 0 2-0.4 2.7-1.1s1.1-1.7 1.1-2.7m-3.8 3.2c-0.9 0-1.7-0.3-2.3-0.9s-0.9-1.4-0.9-2.3c0-1.8 1.5-3.2 3.2-3.2 1.8 0 3.2 1.5 3.2 3.2 0 0.9-0.3 1.7-1 2.3-0.6 0.6-1.4 0.9-2.2 0.9"/>
                            <path class="st0" d="m8.8 6.9c0-1-0.4-2-1.1-2.7s-1.7-1.1-2.7-1.1c-2.1 0-3.8 1.7-3.8 3.8 0 1 0.4 2 1.1 2.7s1.7 1.1 2.7 1.1c2.1 0 3.8-1.7 3.8-3.8m-3.8 3.2c-0.9 0-1.7-0.3-2.3-1-0.6-0.6-1-1.4-1-2.2 0-1.8 1.5-3.2 3.2-3.2 0.9 0 1.7 0.3 2.3 1 0.7 0.5 1 1.3 1 2.2 0 1.8-1.4 3.2-3.2 3.2"/>
                            <path class="st0" d="m15.4 13.2c0-2.1-1.7-3.8-3.8-3.8-1 0-2 0.4-2.7 1.1s-1.1 1.7-1.1 2.7 0.4 2 1.1 2.7 1.7 1.1 2.7 1.1 2-0.4 2.7-1.1 1.1-1.7 1.1-2.7m-3.8 3.3c-0.9 0-1.7-0.3-2.3-0.9s-1-1.4-1-2.3c0-1.8 1.4-3.2 3.2-3.3 0.9 0 1.7 0.3 2.3 0.9s1 1.4 1 2.3c0.1 1.8-1.4 3.3-3.2 3.3"/>
                          </svg>
                        </i>
                        <quantity-changer quantity-text="{{ __('shop::app.products.quantity') }}"></quantity-changer>
                      </div>
                    <div class="product-actions" v-if="">


                        @if (core()->getConfigData('catalog.products.storefront.buy_now_button_display'))
                        @include ('shop::products.buy-now', [
                            'product' => $product,
                        ])
                        @endif
                        <!--{{ ! (isset($showCartIcon) && !$showCartIcon) }}-->

                        <custome-add-to-cart
                            button-text="{{  __('shop::app.products.add-to-cart') }}"
                            :show-cart-icon="false"
                            :is-disabled="isEmpty"
                            :product="{{  json_encode($product) }}"
                            ></custome-add-to-cart>
                  </div>
                </div>


            </div>
        </script>

        <script type="text/x-template" id="bundle-option-item-template">
            <div class="bundle-option-item">
                <div :class="`control-group custom-form mb10 ${errors.has('bundle_options[' + option.id + '][]') ? 'has-error' : ''}`">
                    <label :class="[option.is_required ? 'required' : '']">@{{ option.label }}</label>
                    <div class="option-desc">@{{ option.desc }}</div>

                    <div v-if="option.type == 'select'">
                        <select class="control styled-select" :name="'bundle_options[' + option.id + '][]'" v-model="selected_product" v-validate="option.is_required ? 'required' : ''" :data-vv-as="option.label + '&quot;'">
                            <option value="">{{ __('shop::app.products.choose-selection') }}</option>
                            <option v-for="(product, index2) in option.products" :value="product.id">
                                @{{ product.name + ' + ' + product.price.final_price.formated_price }}
                            </option>
                        </select>
                    </div>

                    <div v-if="option.type == 'radio'">
                        <span class="radio col-12 ml5" v-if="! option.is_required">
                            <input
                                type="radio"
                                :name="'bundle_options[' + option.id + '][]'"
                                v-model="selected_product"
                                value="0" />

                            <label class="radio-view no-padding" :for="'bundle_options[' + option.id + '][]'"></label>
                            {{ __('shop::app.products.none') }}
                        </span>

                        <span class="radio col-12 ml5" v-for="(product, index2) in option.products">
                            <input
                                type="radio"
                                :name="'bundle_options[' + option.id + '][]'"
                                v-model="selected_product"
                                v-validate="option.is_required ? 'required' : ''"
                                :data-vv-as="'&quot;' + option.label + '&quot;'"
                                :value="product.id" />

                            @{{ product.name }}

                            <span class="price">
                                + @{{ product.price.final_price.formated_price }}
                            </span>
                        </span>
                    </div>

                    <div v-if="option.type == 'checkbox'">
                          <span class="checkbox col-12 ml5" v-for="(product, index2) in option.products">
                            <input type="checkbox" :name="'bundle_options[' + option.id + '][]'" :value="product.id" v-model="selected_product" v-validate="option.is_required ? 'required' : ''" :data-vv-as="'&quot;' + option.label + '&quot;'" :id="'bundle_options[' + option.id + '][]'">

                            @{{ product.name }}

                            <span class="price">
                                + @{{ product.price.final_price.formated_price }}
                            </span>
                        </span>
                    </div>
                    <!--<input name="bundle_options" value='{"4":["8","8"],"5":["10","10","10"]}'>-->
                    <div v-if="option.type == 'multiselect'" class="custom-options-wrapper row">
                        <div class="col-12 col-md-3 text-center" v-for="item in option.max_count">
                            <bundle-single-item ref="button" :key="item" :itemID="item" :options="option" @get-selected="getSelected"></bundle-single-item>
                        </div>
                    </div>
                    <!--<div v-if="option.type == 'multiselect'">
                        <select class="control styled-select" :name="'bundle_options[' + option.id + '][]'" v-model="selected_product" v-validate="option.is_required ? 'required' : ''" :data-vv-as="'&quot;' + option.label + '&quot;'" multiple>
                            <option v-for="(product, index2) in option.products" :value="product.id">
                                @{{ product.name  }}
                                @{{ product.name + ' + ' + product.price.final_price.formated_price }}
                            </option>
                        </select>
                    </div>-->

                    <span class="control-error" v-if="errors.has('bundle_options[' + option.id + '][]')" v-text="errors.first('bundle_options[' + option.id + '][]')"></span>
                </div>

                <div v-if="option.type == 'select' || option.type == 'radio'">
                    <quantity-changer
                        :control-name="'bundle_option_qty[' + option.id + ']'"
                        :validations="parseInt(selected_product) ? 'required|numeric|min_value:1' : ''"
                        :quantity="product_qty"
                        quantity-text="{{ __('shop::app.products.quantity') }}"
                        @onQtyUpdated="qtyUpdated($event)">
                    </quantity-changer>
                </div>

            </div>
        </script>

        <script type="text/x-template" id="bundle-single-item-template">
            <div>
               <!--<div>value @{{ selectedProduct ? selectedProduct.id : 'null' }}</div> -->
                <button @click="showModal()"  type="button" class="option"><i class="rango-plus"></i>
                  <template v-if="selectedProduct">
                    <img  class="selected-product-image" :src="selectedProduct.images[0].medium_image_url">
                    <i class="selected-product-icon">
                      <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16.3px" height="14.3px" viewBox="0 0 16.3 14.3" style="overflow:visible;enable-background:new 0 0 16.3 14.3;" xml:space="preserve"> <g id="xVwFQD.tif_1_"> <g> <path class="st0" d="M7.8,14.3c-0.3,0-0.5-0.1-0.8-0.1C5.9,14,4.9,13.7,4,13.1c-1.1-0.7-2-1.7-2.5-2.9C1.3,9.8,1.2,9.4,1.1,9 C1,8.8,1.1,8.6,1.3,8.5c0.2-0.1,0.4,0,0.4,0.3C1.8,9.2,2,9.7,2.2,10.1c0.7,1.4,1.8,2.3,3.2,3c1,0.4,2,0.6,3.1,0.5 c1.8-0.2,3.4-0.9,4.6-2.3c0.5-0.6,0.8-1.2,1.1-1.9c0,0,0-0.1,0-0.1c0,0,0,0,0,0c-0.5,0.2-0.9,0.4-1.4,0.6 c-0.1,0.1-0.2,0.1-0.4,0.2c-0.2,0.1-0.4,0-0.5-0.1c-0.1-0.2,0-0.4,0.2-0.5c0.6-0.3,1.1-0.5,1.7-0.8c0.3-0.1,0.6-0.3,0.8-0.4 c0.3-0.1,0.4-0.1,0.6,0.2c0.3,0.9,0.7,1.7,1,2.6c0.1,0.2,0,0.4-0.1,0.5c-0.2,0.1-0.4,0-0.5-0.2c-0.1-0.3-0.2-0.5-0.3-0.8 c-0.1-0.4-0.3-0.7-0.4-1.1c0,0.1-0.1,0.2-0.1,0.2c-0.7,1.9-2.1,3.3-4,4.1c-0.8,0.3-1.5,0.5-2.4,0.5c-0.1,0-0.1,0-0.2,0 C8.1,14.3,8,14.3,7.8,14.3z"/> <path class="st0" d="M0,3c0.1-0.2,0.2-0.3,0.4-0.3c0.2,0,0.3,0.1,0.3,0.3c0.2,0.6,0.5,1.1,0.7,1.7c0,0,0,0.1,0.1,0.2 c0.1-0.2,0.2-0.4,0.3-0.7c0.8-1.7,2-2.9,3.8-3.6c1-0.4,2-0.6,3.1-0.5c1.5,0.1,2.8,0.5,4,1.4c1,0.8,1.8,1.7,2.3,2.9 c0.1,0.3,0.3,0.6,0.3,1c0.1,0.3-0.1,0.5-0.4,0.4c-0.2,0-0.2-0.1-0.3-0.3c-0.1-0.2-0.1-0.4-0.2-0.6c-0.6-1.5-1.6-2.6-3-3.4 C10.7,1.1,9.9,0.8,9,0.7C7.6,0.6,6.2,0.8,5,1.6c-1.4,0.8-2.3,2-2.8,3.5c0,0,0,0,0,0c0.1,0,0.1,0,0.2-0.1c0.5-0.2,1.1-0.5,1.6-0.7 c0.3-0.1,0.5,0,0.5,0.2c0,0.2-0.1,0.3-0.2,0.4C3.8,5.1,3.4,5.3,3,5.4C2.5,5.6,2.1,5.8,1.7,6C1.4,6.2,1.2,6.1,1.1,5.8 C0.7,5,0.4,4.1,0.1,3.3c0,0,0-0.1-0.1-0.1C0,3.1,0,3,0,3z"/> </g> </g> </svg>
                    </i>
                </template>
                </button>
                <bundle-modal v-if="isModalVisible" @close="closeModal" :itemID="itemID" @save-selected="getSelected" :options="options"></bundle-modal>
            </div>
        </script>

        <script type="text/x-template" id="bundle-modal-template">
            <div class="bundle-modal modal fade show"  >
                <div class="modal-dialog container">
                   <div class="modal-header">

                    <h5 class="modal-title">@{{ options.label }}</h5>
                        <button type="button" class="close" @click="close">
                            <i class="rango-plus"></i>
                        </button>
                   </div>
                    <div class="modal-products row">
                        <div class="col-md-6 col-12" v-for="(product,index) in options.products">
                            <div class="product-card">
                                <div class="product-card-img">
                                  <div class="img">
                                      <img :src="product.images[0].medium_image_url" ref="image" class="main-image" :class="[changedImageProduct == product ? 'zoominMode' : '']">
                                      <img :src="product.images[1] ? product.images[1].medium_image_url : product.images[0].medium_image_url"  :class="[changedImageProduct == product ? 'selected' : '']" class="hover-image">
                                  </div>
                                </div>
                                <div class="product-actions">
                                    <button type="button" @click="changeImage(product , index)" class="show-color" :class="[changedImageProduct == product ? 'selected' : '']">
                                        <!-- Generator: Adobe Illustrator 25.2.3, SVG Export Plug-In  -->
                                      <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16.1px" height="11.9px" viewBox="0 0 16.1 11.9" style="overflow:visible;enable-background:new 0 0 16.1 11.9;" xml:space="preserve"> <g> <g> <path class="st0" d="M0,7.7c0.3-0.3,0.6-0.6,0.9-0.9c1.2-1,2.4-1.9,3.9-2.4C5.8,4,6.9,3.8,8.1,3.8c1.4,0,2.7,0.4,4,1 c1.5,0.7,2.7,1.6,3.8,2.8c0.2,0.2,0.2,0.4,0,0.6c-1.5,1.6-3.3,2.8-5.4,3.4C8.6,12.1,6.8,12,5,11.4c-1.8-0.7-3.4-1.8-4.8-3.2 C0.1,8.1,0.1,8,0,7.9C0,7.9,0,7.8,0,7.7z M8,11.3c1.9,0,3.5-1.5,3.5-3.4c0-1.9-1.5-3.5-3.4-3.5c-1.9,0-3.5,1.5-3.5,3.4 C4.6,9.7,6.1,11.3,8,11.3z M10.9,5c1.5,1.6,1.6,4.2,0,5.8c0.1,0,0.1,0,0.2,0c1.6-0.6,2.9-1.6,4.1-2.7c0.1-0.1,0-0.1,0-0.2 c-0.8-0.8-1.7-1.5-2.6-2C12,5.4,11.5,5.2,10.9,5z M5.1,5C5.1,5,5.1,5,5.1,5C3.5,5.6,2.1,6.6,0.8,7.8c-0.1,0.1,0,0.1,0,0.1 C1.9,9,3.1,9.8,4.5,10.5c0.2,0.1,0.4,0.2,0.6,0.3C3.5,9.1,3.6,6.5,5.1,5z"/> <path class="st0" d="M8.3,1.3c0,0.3,0,0.6,0,0.9c0,0.2-0.1,0.4-0.3,0.4c-0.2,0-0.3-0.1-0.3-0.4c0-0.6,0-1.2,0-1.8 C7.7,0.1,7.8,0,8,0c0.2,0,0.3,0.1,0.3,0.4C8.3,0.7,8.3,1,8.3,1.3z"/> <path class="st0" d="M10.9,3.3c-0.3,0-0.4-0.2-0.3-0.4c0,0,0-0.1,0-0.1c0.3-0.5,0.6-1,0.9-1.5C11.6,1.1,11.7,1,11.8,1 c0.2,0,0.4,0.3,0.2,0.5c-0.3,0.5-0.6,1.1-0.9,1.6C11.1,3.2,11,3.3,10.9,3.3z"/> <path class="st0" d="M5.5,3c0,0.1-0.1,0.2-0.2,0.2c-0.1,0-0.2,0-0.3-0.1c0,0-0.1-0.1-0.1-0.1C4.6,2.5,4.3,2,4,1.5 C3.9,1.3,3.9,1.2,4.1,1.1C4.3,1,4.5,1,4.6,1.2c0.3,0.5,0.6,1,0.9,1.5C5.5,2.8,5.5,2.9,5.5,3z"/> <path class="st0" d="M8,9.4c-0.9,0-1.6-0.7-1.6-1.6C6.5,7,7.2,6.3,8,6.3c0.9,0,1.6,0.7,1.6,1.6C9.6,8.7,8.9,9.4,8,9.4z"/> </g> </g> </svg>

                                    </button>
                                    <h5>@{{ product.name }}</h5>
                                    <button class="add-product-option" type="button" :disabled="disableConfigurable(product)"  :class="[selected_product == product ? 'selected' : '']" @click="addProductOption(product , options.id)">
                                        <i class="rango-plus"></i>
                                    </button>
                                </div>
                                <div class="more-options"  >
                                  <button  type="button" @click="openCollapse(product)" :class="[collapsedProduct == product ? 'opened' : '']" class="open-collapse-btn">
                                    <span>المزيد من الخيارات</span>
                                    <i class="icon-bold-chevron-down"></i>
                                  </button>
                                  <div class="animatted-accordion-wrapper"  >
                                    <animated-accordion  v-if="collapsedProduct == product " active-index="0" class="animated-accordion">
                                      <animated-accordion-item>
                                        <!-- This slot will handle the title/header of the accordion and is the part you click on -->
                                        <template slot="accordion-trigger">
                                          <div class="accorion-trigger-header">
                                            <h5>{{ __('shop::app.products.description') }}</h5>
                                            <i class="icon-bold-chevron-down"></i>
                                          </div>
                                        </template>
                                        <!-- This slot will handle all the content that is passed to the accordion -->
                                        <template slot="accordion-content">
                                          <div class="inner-desc" v-html="product.description">

                                          </div>
                                        </template>
                                      </animated-accordion-item>

                                      <animated-accordion-item v-if="product.type == 'configurable'">
                                        <!-- This slot will handle the title/header of the accordion and is the part you click on -->
                                        <template slot="accordion-trigger">
                                          <div class="accorion-trigger-header">
                                            <h5>{{ __('admin::app.catalog.products.configurable-attributes') }}</h5>
                                            <i class="icon-bold-chevron-down"></i>
                                          </div>
                                        </template>
                                        <!-- This slot will handle all the content that is passed to the accordion -->
                                        <template slot="accordion-content">
                                          <div class="configurable-options" v-if="product.type == 'configurable'">
                                            <input :id="`configurable_${product.product_id}`" type="hidden" :value="product.configurable_data.defaultVariant|toString">
                                            <input :id="`config_${product.product_id}`" type="hidden" :value="product.configurable_data.config|toString">

                                            <product-options
                                              :default-variant-id="`configurable_${product.product_id}`"
                                              :config-id="`config_${product.product_id}`"
                                              @save-selected="getSelected"
                                              >
                                            </product-options>
                                        </div>
                                        </template>
                                      </animated-accordion-item>


                                    </animated-accordion>
                                  </div>
                                </div>

                                <!--<a href="/">link test</a>-->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" :disabled="selected_product == null ? true : false"  class="primary-button" @click="saveSelected">حفظ</button>
                    </div>
                </div>
            </div>
        </script>

        <script type="text/x-template" id="custome-add-to-cart-template">
            <button
                type="submit"
                :disabled="isDisabled"
                id="add_to_cart_single"
                class="theme-btn">
                    <i v-if="showCartIcon" class="material-icons text-down-3">shopping_cart</i>

                    @{{ buttonText }}
            </button>
        </script>
        <script type="text/x-template" id="product-options-template">
            <div class="col-12 attributes" v-if="childAttributes.length > 0">
                <input
                    type="hidden"
                    :value="selectedProductId"
                    id="selected_configurable_option"
                    name="selected_configurable_option"/>

                <div
                    :key="index"
                    v-for='(attribute, index) in childAttributes'
                    :class="`attribute control-group ${errors.has('super_attribute[' + attribute.id + ']') ? 'has-error' : ''}
                    `">
                    <label class="required">@{{ attribute.label }}</label>

                    <span
                        class="custom-form"
                        v-if="
                            ! attribute.swatch_type
                            || attribute.swatch_type == ''
                            || attribute.swatch_type == 'dropdown'
                        ">

                        <select
                            v-validate="'required'"
                            class="control styled-select"
                            :disabled="attribute.disabled"
                            :id="['attribute_' + attribute.id]"
                            :name="['super_attribute[' + attribute.id + ']']"
                            @change="configure(attribute, $event.target.value)"
                            :data-vv-as="'&quot;' + attribute.label + '&quot;'">

                            <option
                                :value="option.id"
                                v-for='(option, index) in attribute.options'
                                :selected="index == attribute.selectedIndex">
                                @{{ option.label }}
                            </option>

                        </select>

                        <div class="select-icon-container">
                            <span class="select-icon rango-arrow-down"></span>
                        </div>
                    </span>

                    <span class="swatch-container" v-else>
                        <label class="swatch"
                            v-for='(option, index) in attribute.options'
                            v-if="option.id"
                            :data-id="option.id"
                            :for="['attribute_' + attribute.id + '_option_' + option.id]">

                            <input
                                type="radio"
                                :value="option.id"
                                v-validate="'required'"
                                :name="['super_attribute[' + attribute.id + ']']"
                                :id="['attribute_' + attribute.id + '_option_' + option.id]"
                                :data-vv-as="'&quot;' + attribute.label + '&quot;'"
                                @change="configure(attribute, $event.target.value)"
                                :checked="index == attribute.selectedIndex">

                            <span v-if="attribute.swatch_type == 'color'" :style="{ background: option.swatch_value }"></span>

                            <img v-if="attribute.swatch_type == 'image'" :src="option.swatch_value" :title="option.label" alt="" />

                            <span v-if="attribute.swatch_type == 'text'">
                                @{{ option.label }}
                            </span>

                        </label>

                        <span v-if="! attribute.options.length" class="no-options">{{ __('shop::app.products.select-above-options') }}</span>
                    </span>

                    <span class="control-error" v-if="errors.has('super_attribute[' + attribute.id + ']')" v-text="errors.first('super_attribute[' + attribute.id + ']')"></span>
                </div>

            </div>
        </script>


        <script type="text/javascript">

            Vue.component('bundle-option-list', {
                template: '#bundle-option-list-template',
                inject: ['$validator'],

                data: function() {
                    return {
                        options: [],
                        currency_options: @json(core()->getAccountJsSymbols()),
                        config: @json(app('Webkul\Product\Helpers\BundleOption')->getBundleConfig($product)),
                        final_seleted_products:{},
                        checkArr:[],
                        isEmpty :true
                    }
                },

                computed: {
                    formated_total_price: function() {
                        var total = 0;

                        for (var key in this.options) {
                            for (var key1 in this.options[key].products) {
                                if (! this.options[key].products[key1].is_default)
                                    continue;

                                total += this.options[key].products[key1].qty * this.options[key].products[key1].price.final_price.price;
                            }
                        }

                        return total;
                    }
                },

                created: function() {
                    for (var key in this.config.options) {
                        this.options.push(this.config.options[key])
                    }

                    this.config.options.map(item=>{

                        let arr = new Array(item.max_count).fill(0);
                        this.final_seleted_products[item.id] = arr
                    })
                    // document.getElementById('add_to_cart_single').disabled = this.isEmpty


                },
                mounted(){
                  document.getElementById('shimmer-list').remove();
                },
                methods: {
                    productSelected: function(option, value) {

                        var selectedProductIds = Array.isArray(value) ? value : [value];

                        for (var key in option.products) {
                            option.products[key].is_default = selectedProductIds.indexOf(option.products[key].id) > -1 ? 1 : 0;
                        }
                    },
                    getSelected(value){
                      console.log(value)
                        this.final_seleted_products[value.option.id][value.selectedIndex] = value.selectedConfigurableProductID ? value.selectedConfigurableProductID : value.product.id

                        let final_items = this.final_seleted_products
                        this.checkArr=[]

                        for(const item in final_items){
                            this.checkArr.push(this.checkarray(item));
                        }

                        if (this.checkArr.includes(true)) {

                        }else{
                            this.isEmpty = false
                            this.$refs.bundle_options.value = JSON.stringify(this.final_seleted_products);

                        }

                    },
                    checkarray(item){
                       return this.final_seleted_products[item].includes(0)
                    }
                }
            });

            Vue.component('bundle-option-item', {
                template: '#bundle-option-item-template',

                props: ['index', 'option'],

                inject: ['$validator'],

                data: function() {
                    return {
                        selected_product: (this.option.type == 'checkbox' || this.option.type == 'multiselect')  ? [] : null,
                        qty_validations: '',
                        selectedProduct: null,

                    }
                },

                computed: {
                    product_qty: function() {
                        var self = this;
                        self.qty = 0;

                        self.option.products.forEach(function(product, key){
                            if (self.selected_product == product.id)
                                self.qty =  self.option.products[key].qty;
                        });

                        return self.qty;
                    }
                },

                watch: {
                    selected_product: function (value) {
                        this.qty_validations = this.selected_product ? 'required|numeric|min_value:1' : '';
                        this.$emit('onProductSelected', value)
                    }
                },

                created: function() {
                    for (var key1 in this.option.products) {
                        if (! this.option.products[key1].is_default)
                            continue;

                        if (this.option.type == 'checkbox' || this.option.type == 'multiselect') {
                            this.selected_product.push(this.option.products[key1].id)
                        } else {
                            this.selected_product = this.option.products[key1].id
                        }
                    }
                },

                methods: {
                    qtyUpdated: function(qty) {
                        if (! this.option.products[this.selected_product])
                            return;

                        this.option.products[this.selected_product].qty = qty;
                    },
                    getSelected(value){
                        this.selectedProduct = value
                        this.$emit('get-selected', value);
                    }

                }
            });

            Vue.component('bundle-single-item', {
                template: '#bundle-single-item-template',

                props: ['options' , 'itemID'],

                inject: ['$validator'],

                data: function() {
                    return {
                        selectedProduct: null,
                        isModalVisible: false,
                    }
                },

                computed: {

                },

                watch: {

                },

                created: function() {

                },

                methods: {
                    itemClicked() {
                        this.$emit("item-clicked");
                    },
                    showModal(id) {
                        this.selected_item = id;
                        this.isModalVisible = true;
                        document.body.classList.add('modal-open');

                    },
                    closeModal() {
                        this.isModalVisible = false;
                        document.body.classList.remove('modal-open');
                    },
                    getSelected(value){
                      console.log(value)
                        this.selectedProduct = value ? value.product : null;
                        let obj = {"product":this.selectedProduct , "option":this.options , "selectedIndex": value.selectedIndex}
                        if(value.selectedConfigurableProductID){
                          obj.selectedConfigurableProductID = value.selectedConfigurableProductID
                        }
                        this.$emit('get-selected', obj );
                    }
                }
            });

            Vue.directive('click-outside-div', {
              bind: function (el, binding, vnode) {
                  console.log(el , binding, vnode)
                el.clickOutsideEvent = function (event) {
                  // here I check that click was outside the el and his children
                  if (!(el == event.target || el.contains(event.target))) {
                    // and if it did, call method provided in attribute value
                    vnode.context[binding.expression](event);
                  }
                };
                document.body.addEventListener('click', el.clickOutsideEvent)
              },
              unbind: function (el) {
                document.body.removeEventListener('click', el.clickOutsideEvent)
              },
            });

            Vue.component('bundle-modal', {
                template: '#bundle-modal-template',

                props: ['options', 'option' , 'itemID'],

                inject: ['$validator'],

                data: function() {
                    return {
                        selected_product: null,
                        selectedProducts:[],
                        changedImageProduct:null,
                        collapsedProduct:null,
                        selectedConfigurableProductID: null
                    }
                },

                computed: {

                },

                watch: {

                },

                created: function() {

                },

                methods: {
                    close() {
                        this.$emit("close");
                    },
                    addProductOption(product , optionID){
                        this.selected_product = product
                    },
                    saveSelected(){
                        let obj = {'product':this.selected_product , 'selectedIndex': this.itemID - 1  } ;
                        if(this.selected_product.type == "configurable" ){
                          if (this.selectedConfigurableProductID ){
                            obj.selectedConfigurableProductID = this.selectedConfigurableProductID
                          }
                        }
                        this.$emit("save-selected" , obj)
                        this.$emit("close");
                    },
                    getSelected(value){
                        if(value.errors == 0){
                          this.selectedConfigurableProductID = value.product_configurable_id
                        }else{
                          this.selectedConfigurableProductID = null
                        }
                    },
                    changeImage(product , index){
                      if (this.changedImageProduct == product){
                        this.changedImageProduct = null
                      }else{
                        this.changedImageProduct = product;
                      }
                    },
                    disableConfigurable(product){
                        if (product.type == "configurable" && !this.selectedConfigurableProductID){
                            return true
                        }
                        return false
                    },
                    openCollapse(value){
                      if(this.collapsedProduct && this.collapsedProduct == value){
                        this.collapsedProduct = null
                      }else{
                        this.collapsedProduct = value
                      }
                    },
                    closeClick(){
                      console.log('hiii')
                      // if(this.collapsedProduct){
                      // this.collapsedProduct = null
                      // }
                    }
                },
                filters: {
                    toString: function(value) {
                        return JSON.stringify(value);;
                    }
                }

            });

            Vue.component('custome-add-to-cart', {
                template: '#custome-add-to-cart-template',


                props: ['product', 'isDisabled', 'showCartIcon' , 'buttonText'],

                data: function() {
                    return {

                    }
                },

                computed: {

                },

                watch: {
                    isEmpty: function (val) {
                        if(val == false){
                            this.$refs.bundle_options.value = JSON.stringify(this.final_seleted_products);
                        }
                    },
                },

                created: function() {
                },

                methods: {

                }
            });

            Vue.component('product-options', {
              template: "#product-options-template",
              inject: ["$validator"],
              props: {
                defaultVariantId: {
                  type: String,
                  required: true,
                },
                configId: {
                  type: String,
                  required: true,
                },
              },
              data: function () {
                return {
                  defaultVariant: null,

                  config: null,

                  galleryImages: [],

                  simpleProduct: null,

                  childAttributes: [],

                  selectedProductId: "",
                };
              },
              created() {},
              mounted: function () {
                this.defaultVariant = JSON.parse(
                  document.getElementById(this.defaultVariantId).value
                );
                this.config = JSON.parse(document.getElementById(this.configId).value);
                this.$nextTick(() => {
                  if (this.config) {
                    this.init();
                    this.initDefaultSelection();
                  }
                });
              },

              methods: {
                init: function () {
                  let config = JSON.parse(document.getElementById(this.configId).value);

                  let childAttributes = this.childAttributes,
                    attributes = config.attributes.slice(),
                    index = attributes.length,
                    attribute;

                  while (index--) {
                    attribute = attributes[index];

                    attribute.options = [];

                    if (index) {
                      attribute.disabled = true;
                    } else {
                      this.fillSelect(attribute);
                    }

                    attribute = Object.assign(attribute, {
                      childAttributes: childAttributes.slice(),
                      prevAttribute: attributes[index - 1],
                      nextAttribute: attributes[index + 1],
                    });

                    childAttributes.unshift(attribute);
                  }
                },

                initDefaultSelection: function () {
                  if (this.defaultVariant) {
                    this.childAttributes.forEach((attribute) => {
                      let attributeValue = this.defaultVariant[attribute.code];

                      this.configure(attribute, attributeValue);
                    });
                  }
                },

                configure: function (attribute, value) {
                  this.simpleProduct = this.getSelectedProductId(attribute, value);

                  if (value) {
                    attribute.selectedIndex = this.getSelectedIndex(attribute, value);

                    if (attribute.nextAttribute) {
                      attribute.nextAttribute.disabled = false;

                      this.fillSelect(attribute.nextAttribute);
                      this.resetChildren(attribute.nextAttribute);
                    } else {
                      this.selectedProductId = this.simpleProduct;
                    }
                  } else {
                    attribute.selectedIndex = 0;
                    this.resetChildren(attribute);
                    this.clearSelect(attribute.nextAttribute);
                  }
                  setTimeout(() => {
                    this.saveSelected()
                  }, 50);


                  // this.reloadPrice();
                  // this.changeProductImages();
                  // this.changeStock(this.simpleProduct);
                },

                getSelectedIndex: function (attribute, value) {
                  let selectedIndex = 0;

                  attribute.options.forEach(function (option, index) {
                    if (option.id == value) {
                      selectedIndex = index;
                    }
                  });

                  return selectedIndex;
                },

                getSelectedProductId: function (attribute, value) {
                  let options = attribute.options,
                    matchedOptions;

                  matchedOptions = options.filter(function (option) {
                    return option.id == value;
                  });

                  if (
                    matchedOptions[0] != undefined &&
                    matchedOptions[0].allowedProducts != undefined
                  ) {
                    return matchedOptions[0].allowedProducts[0];
                  }

                  return undefined;
                },

                fillSelect: function (attribute) {
                  let options = this.getAttributeOptions(attribute.id);
                  let prevOption;
                  let index = 1;
                  let allowedProducts;
                  let i;
                  let j;

                  this.clearSelect(attribute);

                  attribute.options = [{ id: "", label: this.config.chooseText, products: [] }];

                  if (attribute.prevAttribute) {
                    prevOption =
                      attribute.prevAttribute.options[attribute.prevAttribute.selectedIndex];
                  }

                  if (options) {
                    for (i = 0; i < options.length; i++) {
                      allowedProducts = [];

                      if (prevOption) {
                        for (j = 0; j < options[i].products.length; j++) {
                          if (
                            prevOption.allowedProducts &&
                            prevOption.allowedProducts.indexOf(options[i].products[j]) > -1
                          ) {
                            allowedProducts.push(options[i].products[j]);
                          }
                        }
                      } else {
                        allowedProducts = options[i].products.slice(0);
                      }

                      if (allowedProducts.length > 0) {
                        options[i].allowedProducts = allowedProducts;

                        attribute.options[index] = options[i];

                        index++;
                      }
                    }
                  }
                },

                resetChildren: function (attribute) {
                  if (attribute.childAttributes) {
                    attribute.childAttributes.forEach(function (set) {
                      set.selectedIndex = 0;
                      set.disabled = true;
                    });
                  }
                },

                clearSelect: function (attribute) {
                  if (!attribute) return;

                  if (
                    !attribute.swatch_type ||
                    attribute.swatch_type == "" ||
                    attribute.swatch_type == "dropdown"
                  ) {
                    let element = document.getElementById(`attribute_${attribute.id}`);

                    if (element) {
                      element.selectedIndex = "0";
                    }
                  } else {
                    let elements = document.getElementsByName(`super_attribute[${attribute.id}]`);

                    elements.forEach(function (element) {
                      element.checked = false;
                    });
                  }
                },

                getAttributeOptions: function (attributeId) {
                  let options;

                  this.config.attributes.forEach(function (attribute, index) {
                    if (attribute.id == attributeId) {
                      options = attribute.options;
                    }
                  });

                  return options;
                },

                reloadPrice: function () {
                  let selectedOptionCount = 0;

                  this.childAttributes.forEach(function (attribute) {
                    if (attribute.selectedIndex) {
                      selectedOptionCount++;
                    }
                  });

                  let priceLabelElement = document.querySelector(".price-label");
                  let priceElement = document.querySelector(".final-price");
                  let regularPriceElement = document.querySelector(".regular-price");

                  if (this.childAttributes.length == selectedOptionCount) {
                    priceLabelElement.style.display = "none";

                    priceElement.innerHTML = this.config.variant_prices[
                      this.simpleProduct
                    ].final_price.formated_price;

                    if (regularPriceElement) {
                      regularPriceElement.innerHTML = this.config.variant_prices[
                        this.simpleProduct
                      ].regular_price.formated_price;
                    }

                    eventBus.$emit("configurable-variant-selected-event", this.simpleProduct);
                  } else {
                    priceLabelElement.style.display = "inline-block";

                    priceElement.innerHTML = this.config.regular_price.formated_price;

                    eventBus.$emit("configurable-variant-selected-event", 0);
                  }
                },

                changeProductImages: function () {
                  galleryImages.splice(0, galleryImages.length);

                  this.galleryImages.forEach(function (image) {
                    galleryImages.push(image);
                  });

                  if (this.simpleProduct) {
                    this.config.variant_images[this.simpleProduct].forEach(function (image) {
                      galleryImages.push(image);
                    });

                    this.config.variant_videos[this.simpleProduct].forEach(function (video) {
                      galleryImages.push(video);
                    });
                  }

                  galleryImages.forEach(function (image) {
                    if (image.type == "video") {
                      image.small_image_url = image.medium_image_url = image.large_image_url = image.original_image_url =
                        image.video_url;
                    }
                  });

                  eventBus.$emit("configurable-variant-update-images-event", galleryImages);
                },

                changeStock: function (productId) {
                  let inStockElement = document.querySelector(".disable-box-shadow");

                  if (productId) {
                    inStockElement.style.display = "block";
                  } else {
                    inStockElement.style.display = "none";
                  }
                },
                saveSelected(){
                  this.$emit("save-selected" , {'product_configurable_id': this.selectedProductId , 'errors': this.errors.items.length })
                },
              },

            });



            // Vue.mixin({
            //     data: function() {
            //         return {
            //             bundle_options: {}
            //         }
            //     }
            // })
        </script>




    @endpush
@endif