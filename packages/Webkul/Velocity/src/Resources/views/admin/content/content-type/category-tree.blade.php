{!! view_render_event('bagisto.admin.content.create_form_accordian.content.category-tree.before') !!}

@if ($status == 'create')

  <div class="control-group" :class="[errors.has('categories') ? 'has-error' : '']">
    <label for="categories">{{ __('velocity::app.admin.contents.content.categories') }}</label>

    <select class="control" id="categories" name="categories"
      data-vv-as="&quot;{{ __('velocity::app.admin.contents.content.content-type') }}&quot;">


      @foreach (app('Webkul\Category\Repositories\CategoryRepository')->getVisibleCategoryTree(core()->getCurrentChannel()->root_category_id) as $category)
        {
        <option value="{{ $category->id }}">{{ $category->name }}</option>
        }
      @endforeach

    </select>


    <span class="control-error" v-if="errors.has('content_type')" v-text="errors.first('content_type')"></span>
  </div>
@else
  <div class="control-group" :class="[errors.has('categories') ? 'has-error' : '']">
    <label for="categories">{{ __('velocity::app.admin.contents.content.categories') }}</label>

    <select v-validate="'required'"  class="control" id="categories" name="categories"
      data-vv-as="&quot;{{ __('velocity::app.admin.contents.content.content-type.category-tree') }}&quot;"
      >


      @foreach (app('Webkul\Category\Repositories\CategoryRepository')->getVisibleCategoryTree(core()->getCurrentChannel()->root_category_id) as $category)
        {
        <option @if (isset($content->categories)) @if ($category->id==$content->categories)  selected @endif @endif value="{{ $category->id }}">{{ $category->name }}</option>
        }
      @endforeach

    </select>
    <span class="control-error" v-if="errors.has('categories')" v-text="errors.first('categories')"></span>
  </div>

@endif
{!! view_render_event('bagisto.admin.content.create_form_accordian.content.category-tree.after') !!}
