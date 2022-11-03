@extends('admin::layouts.content')

@section('page_title')
    {{ __('admin::app.notification.add-title') }}
@stop
@push('css')
<style>
.btn.btn-success {
    background: #11a86b;
  }
  </style>
@endpush

@section('content')
    <div class="content">
        <form method="POST" action="{{ route('admin.notifications.fcm.store') }}" id="myform" @submit.prevent="onSubmit" enctype="multipart/form-data">
            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="window.location = '{{ route('admin.notifications.fcm.index') }}'"></i>

                        {{ __('admin::app.notification.add-title') }}
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('admin::app.notification.save-btn-title') }}
                    </button>

                    <button type="submit" id="save_send_btn" onclick="changeRoute('test')" class="btn btn-lg btn-success">
                        {{ __('admin::app.notification.save-send-btn-title') }}
                    </button>


                </div>
            </div>

            <div class="page-content">
                <div class="form-container">
                    @csrf()

                    <input type="hidden" name="locale" value="all"/>

                    {!! view_render_event('bagisto.admin.notification.create_form_accordian.general.before') !!}

                    <accordian title="{{ __('admin::app.catalog.categories.general') }}" :active="true">
                        <div slot="body">
                            {!! view_render_event('bagisto.admin.catalog.category.create_form_accordian.general.controls.before') !!}

                            <div class="control-group" :class="[errors.has('title') ? 'has-error' : '']">
                                <label for="title" class="required">{{ __('admin::app.datagrid.title') }}</label>
                                <input type="text" v-validate="'required'" class="control" id="title" name="title" value="{{ old('title') }}" data-vv-as="&quot;{{ __('admin::app.datagrid.title') }}&quot;" />
                                <span class="control-error" v-if="errors.has('title')">@{{ errors.first('title') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('content') ? 'has-error' : '']">
                                <label for="content" class="required">{{ __('admin::app.admin.system.content') }}</label>
                                <textarea  v-validate="'required'" class="control" id="content" name="content"  data-vv-as="&quot;{{ __('admin::app.admin.system.content') }}&quot;" >{{ old('content') }}</textarea>
                                <span class="control-error" v-if="errors.has('content')">@{{ errors.first('content') }}</span>
                            </div>

                            <div class="control-group {!! $errors->has('image.*') ? 'has-error' : '' !!}">
                                <label>{{ __('admin::app.catalog.categories.image') }}</label>

                                <image-wrapper button-label="{{ __('admin::app.catalog.products.add-image-btn-title') }}" input-name="image" :multiple="false"></image-wrapper>

                                <span class="control-error" v-if="{!! $errors->has('image.*') !!}">
                                    @foreach ($errors->get('image.*') as $key => $message)
                                        @php echo str_replace($key, 'Image', $message[0]); @endphp
                                    @endforeach
                                </span>

                                <span class="control-info mt-10">{{ __('admin::app.catalog.categories.image-size') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('customer_group_id') ? 'has-error' : '']">
                                <label for="customer_group_id" >{{ __('admin::app.customers.customers.customer_group') }}</label>
                                <select  class="control" id="customer_group_id" name="customer_group_id" v-validate="'required'" data-vv-as="&quot;{{ __('admin::app.customers.customers.customer_group') }}&quot;">
                                    <option selected="selected" value="all"> {{ __('admin::app.notification.status.all') }} </option>
                                    @foreach ($customer_groups as $group)
                                        <option value="{{ $group->id }}"> {{ $group->name}} </option>
                                    @endforeach
                                </select>
                                <span class="control-error" v-if="errors.has('customer_group_id')">@{{ errors.first('status') }}</span>

                            </div>


                        </div>
                    </accordian>

                    {!! view_render_event('bagisto.admin.notification.create_form_accordian.general.after') !!}

                </div>
            </div>
        </form>
    </div>
@stop
@push('scripts')
<script>
    function changeRoute(route) {
        $('#myform').attr('action' ,'test')
    }

</script>

@endpush

