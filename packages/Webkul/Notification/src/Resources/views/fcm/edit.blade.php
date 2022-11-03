@extends('admin::layouts.content')

@section('page_title')
    {{ __('admin::app.notification.edit-title') }}
@stop

@push('css')
    <style>
        @media only screen and (max-width: 768px){
            .content-container .content .page-header .page-title .control-group .control{
                width: 100% !important;
                margin-top:-25px !important;
            }
        }
        .btn.btn-success {
            background: #11a86b;
        }
    </style>
@endpush

@section('content')
    <div class="content">
        @php
            $locale = core()->getRequestedLocaleCode();
        @endphp
{{--        @if($errors->any())--}}
{{--            {{ implode('', $errors->all('<div>:message</div>')) }}--}}
{{--        @endif--}}
        <form method="POST" action=""  id ="myform" @submit.prevent="onSubmit" enctype="multipart/form-data">
            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="window.location = '{{ route('admin.notifications.fcm.index') }}'"></i>

                        {{ __('admin::app.notification.add-title') }}
                    </h1>

                    <div class="control-group">
                        <select class="control" id="locale-switcher" onChange="window.location.href = this.value">
                            @foreach (core()->getAllLocales() as $localeModel)

                                <option value="{{ route('admin.notifications.fcm.update', $notification->id) . '?locale=' . $localeModel->code }}" {{ ($localeModel->code) == $locale ? 'selected' : '' }}>
                                    {{ $localeModel->name }}
                                </option>

                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('admin::app.notification.save-btn-title') }}
                    </button>

                    <button type="submit" id="save_send_btn" onclick="changeRoute('{{route('admin.notifications.fcm.send', $notification->id)}}')" class="btn btn-lg btn-success">
                        {{ __('admin::app.notification.save-send-btn-title') }}
                    </button>

                </div>
            </div>

            <div class="page-content">
                <div class="form-container">
                    @csrf()

                    <input name="_method" type="hidden" value="PUT">

                    {!! view_render_event('bagisto.admin.notification.edit_form_accordian.general.before', ['notification' => $notification]) !!}

                    <accordian title="{{ __('admin::app.catalog.categories.general') }}" :active="true">
                        <div slot="body">
                            {!! view_render_event('bagisto.admin.catalog.category.edit_form_accordian.general.controls.before', ['notification' => $notification]) !!}

                            <div class="control-group" :class="[errors.has('{{$locale}}[name]') ? 'has-error' : '']">
                                <label for="title" class="required">{{ __('admin::app.datagrid.title') }}
                                    <span class="locale">[{{ $locale }}]</span>
                                </label>
                                <input type="text" v-validate="'required'" class="control" id="title" name="{{$locale}}[title]" value="{{ old($locale)['title'] ?? ($notification->translate($locale)['title'] ?? '') }}" data-vv-as="&quot;{{ __('admin::app.datagrid.title') }}&quot;" v-slugify-target="'slug'"/>
                                <span class="control-error" v-if="errors.has('{{$locale}}[title]')">@{{ errors.first('{!!$locale!!}[title]') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('content') ? 'has-error' : '']">
                                <label for="content" class="required">{{ __('admin::app.admin.system.content') }}</label>
                                <textarea  v-validate="'required'" class="control" id="content" name="{{$locale}}[content]" data-vv-as="&quot;{{ __('admin::app.admin.system.content') }}&quot;">{!! old($locale)['content'] ?? ($notification->translate($locale)['content'] ?? '') !!}</textarea>
                                <span class="control-error" v-if="errors.has('content')">@{{ errors.first('content') }}</span>
                            </div>

                            <div class="control-group {!! $errors->has('image.*') ? 'has-error' : '' !!}">
                                <label>{{ __('admin::app.catalog.categories.image') }}</label>

                                <image-wrapper button-label="{{ __('admin::app.catalog.products.add-image-btn-title') }}" input-name="image" :multiple="false"  :images='"{{ $notification->imageurl }}"'></image-wrapper>

                                <span class="control-error" v-if="{!! $errors->has('image.*') !!}">
                                    @foreach ($errors->get('image.*') as $key => $message)
                                        @php echo str_replace($key, 'Image', $message[0]); @endphp
                                    @endforeach
                                </span>
                            </div>


                            <div class="control-group" :class="[errors.has('customer_group_id') ? 'has-error' : '']">
                                <label for="customer_group_id" class="required">{{ __('admin::app.customers.customers.customer_group') }}</label>
                                <select class="control" v-validate="'required'" id="customer_group_id" name="customer_group_id" data-vv-as="&quot;{{ __('admin::app.customers.customers.customer_group') }}&quot;">

                                    <option {{ $notification->customer_group_id == 'all' ? 'selected' : '' }} value="all"> {{ __('admin::app.notification.status.all') }} </option>
                                    @foreach ($customer_groups as $group)
                                        <option {{ $notification->customer_group_id == $group->id ? 'selected' : '' }} value="{{ $group->id }}"> {{ $group->name}} </option>
                                    @endforeach
                                </select>
                                <span class="control-error" v-if="errors.has('customer_group_id')">@{{ errors.first('customer_group_id') }}</span>
                            </div>

                        </div>
                    </accordian>

                    {!! view_render_event('bagisto.admin.notification.edit_form_accordian.general.after', ['notification' => $notification]) !!}


                </div>
            </div>
        </form>
    </div>
@stop

@push('scripts')
<script>
   function changeRoute(route) {
        $('#myform').attr('action' ,route)
   }

</script>
@endpush