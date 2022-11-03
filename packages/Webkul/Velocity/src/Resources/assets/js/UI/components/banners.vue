<template>
  <div :class="`slides-container ${direction}`">
    <carousel-component
      loop="true"
      timeout="5000"
      autoplay="true"
      slides-per-page="1"
      navigation-enabled="hide"
      paginationEnabled="hide"
      :adjustableHeightEnabled="true"
      :locale-direction="direction"
      :slides-per-page-xlg="1"
      :slides-per-page-lg="1"
      :slides-per-page-md="1"
      :slides-per-page-sm="1"
      :slides-per-page-xs="1"
      :slides-count="banners.length > 0 ? banners.length : 1"
    >
      <template v-if="banners.length > 0">
        <slide
          v-for="(banner, index) in banners"
          :key="index"
          :slot="`slide-${index}`"
          title=" "
        >
          <a
            :href="banner.slider_path != '' ? banner.slider_path : 'javascript:void(0);'"
          >
          </a>
          <div class="silder-image-wrapper" v-if="banner.image_url != ''">
            <img
              class="col-12 no-padding banner-icon"
              :src="banner.image_url != '' ? banner.image_url : defaultBanner"
            />
          </div>
          <div
            v-if="banner.video_url != '' || banner.video_url"
            class="slider-iframe-wrapper embed-responsive embed-responsive-16by9"
          >
            <iframe
              class="slider-iframe embed-responsive-item"
              width="560"
              height="315"
              :src="getId(banner.video_url)"
              title="YouTube video player"
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen
            ></iframe>
          </div>
          <div class="slider-content-wrapper">
            <div class="show-content-wrapper">
              <div class="show-content" v-html="banner.content.replace('\r\n', '')"></div>
              <a
                class="btn-more-text"
                v-if="banner.button_text !== null || banner.button_text !== ''"
                :href="
                  banner.slider_path != '' ? banner.slider_path : 'javascript:void(0);'
                "
                >{{ banner.button_text }}</a
              >
            </div>
          </div>
        </slide>
      </template>

      <template v-else>
        <slide slot="slide-0">
          <img
            loading="lazy"
            class="col-12 no-padding banner-icon"
            :src="defaultBanner"
            alt=""
          />
        </slide>
      </template>
    </carousel-component>
  </div>
</template>

<script>
export default {
  props: ["direction", "defaultBanner", "banners"],

  mounted: function () {
    let banners = this.$el.querySelectorAll("img");
    banners.forEach((banner) => {
      banner.style.display = "block";
    });
  },
  methods: {
    getId(url) {
      let regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
      let match = url.match(regExp);
      let videoId = match && match[2].length === 11 ? match[2] : null;
      let finalUrl = `https://www.youtube.com/embed/${videoId}?version=3&autoplay=1&mute=1&enablejsapi=1&controls=0&loop=1&showinfo=0&playlist=${videoId}`;
      return finalUrl;
    },
  },
};
</script>
