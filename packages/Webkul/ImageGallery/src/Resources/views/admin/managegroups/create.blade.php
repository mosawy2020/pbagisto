@extends('admin::layouts.content')

@section('page_title')
    {{ __('imagegallery::app.manage_group.create.page_title') }}
@stop

@push('css')
    <style>
        .table td .label {
            margin-right: 10px;
        }
        .table td .label:last-child {
            margin-right: 0;
        }
        .table td .label .icon {
            vertical-align: middle;
            cursor: pointer;
        }
        #datagrid-filters.datagrid-filters
        {
            display: none;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">

@endpush

@section('content')
    <div class="content">
        <form method="POST" action="" @submit.prevent="onSubmit" enctype="multipart/form-data">

            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ route('admin.dashboard.index') }}';"></i>
                        {{ __('imagegallery::app.manage_group.create.page_title') }}
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('imagegallery::app.manage_group.create.action') }}
                    </button>
                </div>
            </div>

            <div class="page-content">
                @csrf()

                <?php $familyId = request()->input('family') ?>


                <accordian :title="'{{ __('imagegallery::app.manage_group.create.accordian_title') }}'" :active="true">
                    <div slot="body">
                        <div class="control-group" :class="[errors.has('group_code') ? 'has-error' : '']">
                            <label for="group_code" class="required">{{ __('imagegallery::app.manage_group.create.group_code') }}</label>
                            <input type="text" v-validate="'required'" class="control" id="group_code" name="group_code" value="{{ old('group_code') }}" data-vv-as="&quot;{{ __('Group Code') }}&quot;" v-slugify-target="'slug'"/>
                            <span class="control-error" v-if="errors.has('group_code')">@{{ errors.first('group_code') }}</span>
                        </div>
                        <div class="control-group">
                            <label style="width:100%;">
                                {{ __('imagegallery::app.manage_group.create.group_banner_text') }}

                            </label>

                            <textarea class="control enable-wysiwyg" id="banner_text" name="banner_text">

                            </textarea>
                        </div>
                        <div class="control-group" :class="[errors.has('group_banner') ? 'has-error' : '']">
                            <label for="group_banner" class="required">{{ __('imagegallery::app.images.edit.image') }}</label>
                            <image-single remove-button-label="{{ __('admin::app.catalog.products.add-image-btn-title') }}"
                                input-name="banner"
                                id="group_banner"
                                :image="{}"
                                :required="true"
                                :multiple="false"></image-single>
                        </div>
                        <div class="control-group" :class="[errors.has('status') ? 'has-error' : '']">
                            <label for="status" class="required">{{ __('imagegallery::app.manage_group.create.status') }}</label>
                            <select class="control" v-validate="'required'" id="status" name="status" data-vv-as="&quot;{{ __('Status') }}&quot;">
                                <option value="1">
                                    {{ __('imagegallery::app.manage_group.create.enable') }}
                                </option>
                                <option value="0">
                                    {{ __('imagegallery::app.manage_group.create.disable') }}
                                </option>
                            </select>
                            <span class="control-error" v-if="errors.has('status')">@{{ errors.first('status') }}</span>
                        </div>
                        <div class="control-group">
                            <input type="text" name="extradata" class="extradata" id="extradata" hidden="hidden">
                        </div>
                    </div>
                </accordian>
                <accordian :title="'{{ __('imagegallery::app.manage_group.create.galleries') }}'" :active="true">
                    <div slot="body">
                        <div class="control-group">
                            <table class="table" id="myTable">
                                <thead>
                                    <tr style="height:65px;">
                                        <th class="grid_head">Id</th>
                                        <th class="grid_head">Gallery Title</th>
                                        <th class="grid_head">Gallery Code</th>
                                        <th class="grid_head">Images Ids</th>
                                    </tr>
                                </thead>

                                <tbody style="text-align:center">
                                    @foreach( $imageGalleries as $key =>  $imageGallery)
                                        <tr>
                                            <td data-value="Id">
                                                <span>
                                                    <input type="checkbox" name="gallery_ids[]" value="{{$imageGallery->id}}" class="gridcheckbox"  >

                                                </span>
                                            </td>
                                            <td data-value="Gallery Title">
                                                {{$imageGallery->title}}
                                            </td>
                                            <td data-value="Gallery Code">
                                                {{$imageGallery->gallery_code}}
                                            </td>
                                            <td data-value="Images Ids">
                                                {{$imageGallery->image_ids}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
                    </div>
                </accordian>
            </div>
        </form>
    </div>
@stop

@push('scripts')
@include('admin::layouts.tinymce')
    <script>

        $(document).ready(function () {
            tinyMCEHelper.initTinyMCE({
                selector: 'textarea.enable-wysiwyg, textarea.enable-wysiwyg',
                width: "100%",
                image_advtab: true,
            });
            $('.label .cross-icon').on('click', function(e) {
                $(e.target).parent().remove();
            })
            $('.actions .trash-icon').on('click', function(e) {
                $(e.target).parents('tr').remove();
            })
        });
    </script>


<script>
        $(document).ready(function () {

            $('.gridcheckbox').on('click', function(e) {
                var imgid = $(this).val()
                var imgids = $('.extradata').val()

                var answer = imgids.concat(imgid , ',')
                $('.extradata').val(answer)
            })
        });
    </script>

<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js">
</script>

<script>
$(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
@endpush