@extends('admin::layouts.master')

@section('page_title')
    {{ __('abandoncart::app.abandon-cart.view-title', ['abandon_cart_id' => $cart->id]) }}
@stop

@section('content-wrapper')
    <div class="content full-page">
        <div class="page-header">
            <div class="page-title">
                <h1>
                    <i class="icon angle-left-icon back-link" onclick="window.location = history.length > 1 ? document.referrer : '{{ route('admin.dashboard.index') }}'"></i>

                    {{ __('abandoncart::app.abandon-cart.view-title', ['abandon_cart_id' => $cart->id]) }}
                </h1>
            </div>

            <div class="page-action">
                <a href="{{ route('admin.sales.abandon-cart.mail', $cart->id) }}" class="btn btn-lg btn-primary">
                    {{ __('abandoncart::app.datagrid.send-mail') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            <div class="sale-container">

                <accordian :title="'{{ __('abandoncart::app.abandon-cart.cart-and-account') }}'" :active="true">
                    <div slot="body">

                        <div class="sale-section">
                            <div class="secton-title">
                                <span>{{ __('abandoncart::app.abandon-cart.cart-info') }}</span>
                            </div>

                            <div class="section-content">
                                <div class="row">
                                    <span class="title">
                                        {{ __('abandoncart::app.datagrid.date') }}
                                    </span>

                                    <span class="value">
                                        {{ $cart->created_at }}
                                    </span>
                                </div>

                                <div class="row">
                                    <span class="title">
                                        {{ __('abandoncart::app.datagrid.mail-sent') }}
                                    </span>

                                    <span class="value">
                                        @if ($cart->is_mail_sent)
                                            {{ __('abandoncart::app.datagrid.yes') }}
                                        @else
                                            {{ __('abandoncart::app.datagrid.no') }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="sale-section">
                            <div class="secton-title">
                                <span>{{ __('admin::app.sales.orders.account-info') }}</span>
                            </div>

                            <div class="section-content">
                                <div class="row">
                                    <span class="title">
                                        {{ __('admin::app.sales.orders.customer-name') }}
                                    </span>

                                    <span class="value">
                                       {{ $cart->customer_first_name }} {{ $cart->customer_last_name }}
                                    </span>
                                </div>

                                <div class="row">
                                    <span class="title">
                                        {{ __('admin::app.sales.orders.email') }}
                                    </span>

                                    <span class="value">
                                        {{ $cart->customer_email }}
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </accordian>

                <accordian :title="'{{ __('abandoncart::app.abandon-cart.products-information') }}'" :active="true">
                    <div slot="body">

                        <div class="table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>{{ __('admin::app.sales.orders.SKU') }}</th>
                                        <th>{{ __('admin::app.sales.orders.product-name') }}</th>
                                        <th>{{ __('shop::app.customer.account.order.view.qty') }}</th>
                                        <th>{{ __('admin::app.sales.orders.price') }}</th>
                                        <th>{{ __('admin::app.sales.orders.subtotal') }}</th>
                                        <th>{{ __('admin::app.sales.orders.tax-percent') }}</th>
                                        <th>{{ __('admin::app.sales.orders.tax-amount') }}</th>
                                        @if ($cart->base_discount_amount > 0)
                                            <th>{{ __('admin::app.sales.orders.discount-amount') }}</th>
                                        @endif
                                        <th>{{ __('admin::app.sales.orders.grand-total') }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($cart->items as $item)
                                        <tr>
                                            <td>
                                                {{ $item->sku }}
                                            </td>

                                            <td>
                                                {{ $item->name }}

                                                @if (isset($item->additional['attributes']))
                                                    <div class="item-options">

                                                        @foreach ($item->additional['attributes'] as $attribute)
                                                            <b>{{ $attribute['attribute_name'] }} : </b>{{ $attribute['option_label'] }}</br>
                                                        @endforeach

                                                    </div>
                                                @endif
                                            </td>

                                            <td>{{$item->quantity}}</td>

                                            <td>{{ core()->formatBasePrice($item->base_price) }}</td>

                                            <td>{{ core()->formatBasePrice($item->base_total) }}</td>

                                            <td>{{ $item->tax_percent }}%</td>

                                            <td>{{ core()->formatBasePrice($item->base_tax_amount) }}</td>

                                            @if ($cart->base_discount_amount > 0)
                                                <td>{{ core()->formatBasePrice($item->base_discount_amount) }}</td>
                                            @endif

                                            <td>{{ core()->formatBasePrice($item->base_total + $item->base_tax_amount - $item->base_discount_amount) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="summary-comment-container">
                            <table class="sale-summary">
                                <tr>
                                    <td>{{ __('admin::app.sales.orders.subtotal') }}</td>
                                    <td>-</td>
                                    <td>{{ core()->formatBasePrice($cart->base_sub_total) }}</td>
                                </tr>

                                @if ($cart->haveStockableItems())
                                    <tr>
                                        <td>{{ __('admin::app.sales.orders.shipping-handling') }}</td>
                                        <td>-</td>

                                        <td>
                                            @if (isset($cart->selected_shipping_rate))
                                                {{ core()->formatBasePrice($cart->selected_shipping_rate->base_price) }}
                                            @else
                                                {{ core()->formatBasePrice($cart->base_shipping_amount) }}
                                            @endif
                                        </td>
                                    </tr>
                                @endif

                                @if ($cart->base_discount_amount > 0)
                                    <tr>
                                        <td>
                                            {{ __('admin::app.sales.orders.discount') }}

                                            @if ($cart->coupon_code)
                                                ({{ $cart->coupon_code }})
                                            @endif
                                        </td>
                                        <td>-</td>
                                        <td>{{ core()->formatBasePrice($cart->base_discount_amount) }}</td>
                                    </tr>
                                @endif

                                <tr class="border">
                                    <td>{{ __('admin::app.sales.orders.tax') }}</td>
                                    <td>-</td>
                                    <td>{{ core()->formatBasePrice($cart->base_tax_total) }}</td>
                                </tr>

                                <tr class="bold">
                                    <td>{{ __('admin::app.sales.orders.grand-total') }}</td>
                                    <td>-</td>
                                    <td>{{ core()->formatBasePrice($cart->base_grand_total) }}</td>
                                </tr>

                            </table>
                        </div>

                    </div>
                </accordian>
            </div>
        </div>
    </div>
@stop