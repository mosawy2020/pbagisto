{!! view_render_event('bagisto.admin.content.create_form_accordian.content.page.before') !!}
 @if ($status == 'create')
  <div class="control-group" :class="[errors.has('pages') ? 'has-error' : '']">
    <label for="page">{{ __('velocity::app.admin.contents.content.page') }}</label>

    <select class="control" id="page" name="page"
      data-vv-as="&quot;{{ __('velocity::app.admin.contents.content.page') }}&quot;" >

      @foreach (app('Webkul\CMS\Repositories\CmsRepository')->getAll() as $page)
        {
        <option value="{{ $page->url_key }}">{{ $page->page_title }}</option>
        }
      @endforeach
    </select>


    <span class="control-error" v-if="errors.has('content_type')" v-text="errors.first('content_type')"></span>
  </div>
@else
  <div class="control-group" :class="[errors.has('page') ? 'has-error' : '']">
    <label for="page">{{ __('velocity::app.admin.contents.content.page') }}</label>

    <select class="control" id="page" name="page"
      data-vv-as="&quot;{{ __('velocity::app.admin.contents.content.page') }}&quot;" >
      @foreach (app('Webkul\CMS\Repositories\CmsRepository')->getAll() as $page)
        {
        <option @if ($content->page == $page->url_key) selected @endif value="{{ $page->url_key }}">{{ $page->page_title }}
        </option>
        }
      @endforeach

    </select>
    <span class="control-error" v-if="errors.has('page')" v-text="errors.first('page')"></span>
  </div>

@endif
{!! view_render_event('bagisto.admin.content.create_form_accordian.content.page.after') !!}
