@extends('admin::layouts.content')

@section('page_title')
  {{ __('admin::app.settings.sliders.edit-title') }}
@stop

@section('content')
  <div class="content">
    @php $locale = core()->getRequestedLocaleCode(); @endphp

    <form method="POST" action="{{ route('admin.sliders.update', $slider->id) }}" @submit.prevent="onSubmit"
      enctype="multipart/form-data">
      <div class="page-header">
        <div class="page-title">
          <h1>
            <i class="icon angle-left-icon back-link" onclick="window.location = '{{ route('admin.sliders.index') }}'"></i>

            {{ __('admin::app.settings.sliders.edit-title') }}

            @if ($slider->locale)
              <span class="locale">[{{ $slider->locale }}]</span>
            @endif

          </h1>
        </div>

        <div class="page-action">
          <button type="submit" class="btn btn-lg btn-primary">
            {{ __('admin::app.settings.sliders.save-btn-title') }}
          </button>
        </div>
      </div>

      <div class="page-content">
        <div class="form-container">

          @csrf()

          {!! view_render_event('bagisto.admin.settings.slider.edit.before') !!}

          <div class="control-group multi-select" :class="[errors.has('locale[]') ? 'has-error' : '']">
            <label for="locale">{{ __('admin::app.datagrid.locale') }}</label>

            <select class="control" id="locale" name="locale[]"
              data-vv-as="&quot;{{ __('admin::app.datagrid.locale') }}&quot;" value="" v-validate="'required'"
              multiple>
              @foreach (core()->getAllLocales() as $localeModel)
                <option value="{{ $localeModel->code }}"
                  {{ in_array($localeModel->code, explode(',', $slider->locale)) ? 'selected' : '' }}>
                  {{ $localeModel->name }}
                </option>
              @endforeach
            </select>

            <span class="control-error" v-if="errors.has('locale[]')">@{{ errors.first('locale[]') }}</span>
          </div>

          <div class="control-group" :class="[errors.has('title') ? 'has-error' : '']">
            <label for="title" class="required">{{ __('admin::app.settings.sliders.name') }}</label>
            <input type="text" class="control" name="title" v-validate="'required'"
              data-vv-as="&quot;{{ __('admin::app.settings.sliders.name') }}&quot;"
              value="{{ $slider->title ?: old('title') }}">
            <span class="control-error" v-if="errors.has('title')">@{{ errors.first('title') }}</span>
          </div>

          <?php $channels = core()->getAllChannels(); ?>
          <div class="control-group" :class="[errors.has('channel_id') ? 'has-error' : '']">
            <label for="channel_id">{{ __('admin::app.settings.sliders.channels') }}</label>
            <select class="control" id="channel_id" name="channel_id"
              data-vv-as="&quot;{{ __('admin::app.settings.sliders.channels') }}&quot;" value=""
              v-validate="'required'">
              @foreach ($channels as $channel)
                <option value="{{ $channel->id }}" @if ($channel->id == $slider->channel_id) selected @endif>
                  {{ __(core()->getChannelName($channel)) }}
                </option>
              @endforeach
            </select>
            <span class="control-error" v-if="errors.has('channel_id')">@{{ errors.first('channel_id') }}</span>
          </div>

          <div class="control-group date">
            <label for="expired_at">{{ __('admin::app.settings.sliders.expired-at') }}</label>
            <date>
              <input type="text" name="expired_at" class="control"
                value="{{ old('expired_at') ?: $slider->expired_at }}" />
            </date>
          </div>

          <div class="control-group">
            <label for="sort_order">{{ __('admin::app.settings.sliders.sort-order') }}</label>
            <input type="text" class="control" id="sort_order" name="sort_order"
              value="{{ $slider->sort_order ?? old('sort_order') }}" />
          </div>


          <div class="control-group">
            <label for="content">{{ __('admin::app.settings.sliders.content') }}</label>

            <div class="panel-body">
              <textarea id="tiny" class="control" id="add_content" name="content" rows="5">{{ $slider->content ?: old('content') }}</textarea>
            </div>

            <span class="control-error" v-if="errors.has('content')">@{{ errors.first('content') }}</span>
          </div>



          <div class="control-group">
            <label for="button_text">{{ __('admin::app.settings.sliders.button_text') }}</label>
            <input type="text" class="control" id="button_text" name="button_text"
              value="{{ $slider->button_text ?: old('button_text') }}" />
          </div>

          <div class="control-group">
            <label style="width:100%;">
              {{ __('velocity::app.admin.meta-data.activate-video') }}
              <span class="locale"></span>
            </label>

            <label class="switch">
              <input id="activate_video" name="activate_video" type="checkbox" class="control"
                data-vv-as="&quot;slides&quot;" {{ $slider->video_url ? 'checked' : '' }} />

              <span class="slider round"></span>
            </label>
          </div>



          <div id="image-wrapper" class="control-group {!! $errors->has('image.*') ? 'has-error' : '' !!}">
            <label class="required">{{ __('admin::app.catalog.categories.image') }}</label>
            <span class="control-info mt-10">{{ __('admin::app.settings.sliders.image-size') }}</span>

            <image-wrapper button-label="{{ __('admin::app.settings.sliders.image') }}" input-name="image"
              :multiple="false" :images='"{{ Storage::url($slider->path) }}"'></image-wrapper>

            <span class="control-error" v-if="{!! $errors->has('image.*') !!}">
              @foreach ($errors->get('image.*') as $key => $message)
                @php echo str_replace($key, 'Image', $message[0]); @endphp
              @endforeach
            </span>
          </div>


          <div id="video-wrapper" class="control-group">
            <label for="video_url">{{ __('admin::app.settings.sliders.video_url') }}</label>
            <input type="url" class="control" id="video_url" name="video_url"
              value="{{ $slider->video_url ?: old('video_url') }}" />
          </div>


          {!! view_render_event('bagisto.admin.settings.slider.edit.after', ['slider' => $slider]) !!}
        </div>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
  @include('admin::layouts.tinymce')

  <script>
    $(document).ready(function() {
      tinyMCEHelper.initTinyMCE({
        selector: 'textarea#tiny',
        height: 400,
        width: "100%",
        image_advtab: true,
        templates: [{
            title: 'Test template 1',
            content: 'Test 1'
          },
          {
            title: 'Test template 2',
            content: 'Test 2'
          }
        ],
      });
      $('#image-wrapper , #video-wrapper').hide()
      if ($('#activate_video').is(":checked")) {
        $('#image-wrapper').hide()
        $('#video-wrapper').show()
      } else {
        $('#image-wrapper').show()
        $('#video-wrapper').hide()
      }
      $('#activate_video').change(function() {
        if (this.checked) {
          $('#image-wrapper').hide()
          $('#video-wrapper').show()
        } else {
          $('#image-wrapper').show()
          $('#video-wrapper').hide()
        }
      });
    });
  </script>
@endpush
