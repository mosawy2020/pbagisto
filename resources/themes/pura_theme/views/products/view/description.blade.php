{{-- {!! view_render_event('bagisto.shop.products.view.description.before', ['product' => $product]) !!} --}}

    {{-- <accordian :title="'{{ __('shop::app.products.description') }}'" :active="true">
        
        <div slot="header">
            <h3 class="no-margin display-inbl">
                {{ __('velocity::app.products.details') }}
            </h3>

            <i class="rango-arrow"></i>
        </div>

        <div slot="body">
            <div class="full-description">
                {!! $product->description !!}
            </div>
        </div>
    </accordian> --}}

    <animated-accordion-item>
        <!-- This slot will handle the title/header of the accordion and is the part you click on -->
        <template slot="accordion-trigger">
          <div class="accorion-trigger-header">
              <h3 class="no-margin display-inbl">
                {{ __('velocity::app.products.details') }}
              </h3>
              <i class="icon-bold-chevron-down"></i>
          </div>
        </template>
        <!-- This slot will handle all the content that is passed to the accordion -->
        <template slot="accordion-content">
          <div class="inner-desc" >
            <div class="full-description">
                {!! $product->description !!}
            </div>
          </div>
        </template>
    </animated-accordion-item>

{{-- {!! view_render_event('bagisto.shop.products.view.description.after', ['product' => $product]) !!} --}}