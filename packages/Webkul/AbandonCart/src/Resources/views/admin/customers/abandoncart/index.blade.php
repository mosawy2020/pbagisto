@extends('admin::layouts.content')

@section('page_title')
    {{ __('abandoncart::app.abandon-cart.name') }}
@stop

@section('content')
    <div class="content" style="height: 100%;">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('abandoncart::app.abandon-cart.name') }}</h1>
            </div>
        </div>

        <div class="page-content">
            @inject('cart', 'Webkul\AbandonCart\DataGrids\AbandonCartDataGrid')
            
            {!! $cart->render() !!}
        </div>
    </div>
@stop