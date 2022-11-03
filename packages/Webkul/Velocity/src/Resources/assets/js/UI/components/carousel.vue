<template>
  <carousel
    :rtl="localeDirection == 'rtl'"
    :dir="localeDirection"
    :id="id"
    :navigationEnabled="true"
    navigationPrevLabel="<span class='rango-arrow-left'></span>"
    navigationNextLabel="<span class='rango-arrow-right'></span>"
    :paginationEnabled="true"
    :perPage="parseInt(slidesPerPage)"
    :loop="loop == 'true' ? true : false"
    :autoplay="autoplay == 'true' ? true : false"
    :autoplayTimeout="timeout ? parseInt(timeout) : 2000"
    :autoplayDirection="'forward'"
    :adjustableHeight="adjustableHeightEnabled"
    :class="[
      localeDirection,
      navigationEnabled == 'hide' ? 'navigation-hide' : '',
      paginationEnabled == 'hide' ? 'pagination-hide' : '',
      addClass,
    ]"
  >
    <slot v-for="index in parseInt(slidesCount)" :name="`slide-${parseInt(index) - 1}`">
    </slot>
  </carousel>
</template>

<script type="text/javascript">
export default {
  props: [
    "id",
    "loop",
    "timeout",
    "autoplay",
    "addClass",
    "direction",
    "slidesCount",
    "localeDirection",
    "navigationEnabled",
    "paginationEnabled",
    "adjustableHeightEnabled",
    "slidesPerPageXlg",
    "slidesPerPageLg",
    "slidesPerPageMd",
    "slidesPerPageSm",
    "slidesPerPageXs",
  ],

  data: function () {
    return {
      slidesPerPage: 6,
      windowWidth: window.innerWidth,
    };
  },
  mounted: function () {
    this.$nextTick(() => {
      window.addEventListener("resize", this.onResize);
    });
    this.slidesPerPage = this.slidesPerPageXlg;
    this.setWindowWidth();
    this.setSlidesPerPage(this.windowWidth);
  },

  methods: {
    /* get window class */
    getWindowClass: function () {
      return this.showRecentlyViewed === "true"
        ? ".with-recent-viewed"
        : ".without-recent-viewed";
    },
    waitForElement: function (selector, callback) {
      if (jQuery(selector).length) {
        callback();
      } else {
        setTimeout(() => {
          this.waitForElement(selector, callback);
        }, 100);
      }
    },
    setWindowWidth: function () {
      let windowClass = this.getWindowClass();

      this.waitForElement(windowClass, () => {
        this.windowWidth = $(windowClass).width();
      });
    },
    /* on resize set window width */
    onResize: function () {
      this.windowWidth = $(this.getWindowClass()).width();
    },
    slideClicked: function () {
      debugger;
    },
    /* setting slides on the basis of window width */
    setSlidesPerPage: function (width) {
      if (width >= 1200) {
        this.slidesPerPage = this.slidesPerPageXlg ? this.slidesPerPageXlg : 6;
      } else if (width < 1200 && width >= 992) {
        this.slidesPerPage = this.slidesPerPageLg ? this.slidesPerPageLg : 5;
      } else if (width < 992 && width >= 822) {
        this.slidesPerPage = this.slidesPerPageMd ? this.slidesPerPageMd : 4;
      } else if (width < 822 && width >= 626) {
        this.slidesPerPage = this.slidesPerPageSm ? this.slidesPerPageSm : 3;
      } else {
        this.slidesPerPage = this.slidesPerPageXs ? this.slidesPerPageXs : 2;
      }
    },
  },
};
</script>
