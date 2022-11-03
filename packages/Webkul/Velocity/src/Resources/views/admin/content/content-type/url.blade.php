{!! view_render_event('bagisto.admin.content.create_form_accordian.content.url.before') !!}

@if ($status == 'create')
  <div class="control-group" :class="[errors.has('url') ? 'has-error' : '']">
    <label for="url">
      {{ __('velocity::app.admin.contents.content.page-link') }}</span>
    </label>
    <input type="text" class="control" id="url" name="url" value=""
      data-vv-as="&quot;{{ __('velocity::app.admin.contents.content.page-link') }}&quot;" />
    <span class="control-error" v-if="errors.has('url')" v-text="errors.first('url')"></span>
  </div>
@else
  <div class="control-group" :class="[errors.has('url') ? 'has-error' : '']">
    <label for="url">
      {{ __('velocity::app.admin.contents.content.page-link') }}</span>
    </label>
    <input type="text" class="control" id="url" name="url" value="{{ old('url') ?? $content->url }}"
      data-vv-as="&quot;{{ __('velocity::app.admin.contents.content.page-link') }}&quot;" />
    <span class="control-error" v-if="errors.has('url')" v-text="errors.first('url')"></span>
  </div>
@endif

{!! view_render_event('bagisto.admin.content.create_form_accordian.content.url.after') !!}
