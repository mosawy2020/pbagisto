@extends('shop::layouts.master')

@section('content-wrapper')
    <div class="account-content row no-margin velocity-divide-page">
        <div class="container">
            <div class="sidebar left">
                @include('shop::customers.account.partials.sidemenu')
            </div>

            <div class="account-layout right mt10">
                {{-- @if (request()->route()->getName() !== 'customer.profile.index')
                    @if (Breadcrumbs::exists())
                        {{ Breadcrumbs::render() }}
                    @endif
                @endif --}}
                <div class="account-main-content">
                    @yield('page-detail-wrapper')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ asset('vendor/webkul/ui/assets/js/ui.js') }}"></script>
@endpush