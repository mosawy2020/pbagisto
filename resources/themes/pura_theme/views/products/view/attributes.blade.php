@inject ('productViewHelper', 'Webkul\Product\Helpers\View')

{!! view_render_event('bagisto.shop.products.view.attributes.before', ['product' => $product]) !!}
    @php
        $customFamiliesValues = $productViewHelper->getAdditionalData($product);
        //  dd($customFamiliesValues)
    @endphp

    @if ($customFamiliesValues)

        @foreach ($customFamiliesValues as $family)
            <animated-accordion-item>
              <!-- This slot will handle the title/header of the accordion and is the part you click on -->
              <template slot="accordion-trigger">
                <div class="accorion-trigger-header">
                    <h3 class="no-margin display-inbl">
                        {{ $family->translation?->title }}
                    </h3>
                    <i class="icon-bold-chevron-down"></i>
                </div>
              </template>
              <!-- This slot will handle all the content that is passed to the accordion -->
              <template slot="accordion-content">
                <div class="inner-desc" >
                    <table class="full-specifications">

                        @foreach ($family['values'] as $attribute)
                            <tr>
                                @if ($attribute['type'] == 'textarea' )

                                @else
                                    @if ($attribute['label'])
                                        <td class='fw6'>{{ $attribute['label'] }}</td>
                                    @else
                                        <td>{{ $attribute['admin_name'] }}</td>
                                    @endif
                                @endif

                                @if ($attribute['type'] == 'file' && $attribute['value'])
                                    <td>
                                        <a  href="{{ route('shop.product.file.download', [$product->product_id, $attribute['id']])}}" style="color:black;">
                                            <i class="icon rango-download-1"></i>
                                        </a>
                                    </td>
                                @elseif ($attribute['type'] == 'image' && $attribute['value'])
                                    <td>
                                        <a href="{{ route('shop.product.file.download', [$product->product_id, $attribute['id']])}}">
                                            <img src="{{ Storage::url($attribute['value']) }}" style="height: 20px; width: 20px;" alt=""/>
                                        </a>
                                    </td>

                                @elseif ($attribute['type'] == 'textarea' )
                                    <td>
                                        <div>{!! $attribute['value'] !!}</div>
                                    </td>
                                @else
                                    <td>{{ $attribute['value'] }}</td>
                                @endif
                            </tr>
                        @endforeach
                    </table>
                </div>
              </template>
            </animated-accordion-item>

        @endforeach

    @endif

{!! view_render_event('bagisto.shop.products.view.attributes.after', ['product' => $product]) !!}