<div class="about-section">
  <div class="container">
    <div class="about-section-content">
        @if(isset($content))
            {!! $content !!}
        @else
            @if ($velocityMetaData && $velocityMetaData->home_page_about)
                {!! $velocityMetaData->home_page_about !!}
            @endif
      @endif
    </div>
  </div>
</div>