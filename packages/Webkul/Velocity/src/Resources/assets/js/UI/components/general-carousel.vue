<template>
  <div class="container-fluid">
    <template>
      <div
        class="carousel-general"
        :class="
          showRecentlyViewed === 'true'
            ? 'with-recent-viewed col-lg-9'
            : 'without-recent-viewed col-lg-12'
        "
      >
        <carousel-component
          :slides-per-page="slidesPerPage"
          pagination-enabled="hide"
          :locale-direction="localeDirection"
          :slides-count="productCollections.length"
          v-if="count != 0"
        >
          <slot></slot>
        </carousel-component>
      </div>
    </template>
  </div>
</template>

<script>
export default {
  props: {
    count: {
      type: String,
      default: "10",
    },
    productId: {
      type: String,
      default: "",
    },
    showDesc: {
      type: Boolean,
      default: false,
    },
    productTitle: String,
    productRoute: String,
    localeDirection: String,
    showRecentlyViewed: {
      type: String,
      default: "false",
    },
    productCollections: {
      type: Array,
      default: () => [],
    },
    recentlyViewedTitle: String,
    noDataText: String,
    productClasses: String,
    productSubTitle: String,
    productButtonLink: String,
    productButtonText: String,
    slidesPerPageXlg: Number,
    slidesPerPageLg: Number,
    slidesPerPageMd: Number,
    slidesPerPageSm: Number,
    slidesPerPageXs: Number,
  },

  data: function () {
    return {
      list: false,
      isLoading: true,
      isCategory: false,
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
    this.isLoading = false;
  },

  watch: {
    /* checking the window width */
    windowWidth(newWidth, oldWidth) {
      this.setSlidesPerPage(newWidth);
    },
  },

  methods: {
    /* fetch product collections */
    // getProducts: function () {
    //   this.$http
    //     .get(this.productRoute)
    //     .then((response) => {
    //       let count = this.count;

    //       if (response.data.status && count != 0) {
    //         if (response.data.categoryProducts !== undefined) {
    //           this.isCategory = true;
    //           this.categoryDetails = response.data.categoryDetails;
    //           this.productCollections = response.data.categoryProducts;
    //         } else {
    //           this.productCollections = response.data.products;
    //         }
    //       } else {
    //         this.productCollections = 0;
    //       }

    //       this.isLoading = false;
    //     })
    //     .catch((error) => {
    //       this.isLoading = false;
    //       console.log(this.__("error.something_went_wrong"));
    //     });
    // },

    /* waiting for element */
    waitForElement: function (selector, callback) {
      if (jQuery(selector).length) {
        callback();
      } else {
        setTimeout(() => {
          this.waitForElement(selector, callback);
        }, 100);
      }
    },

    /* setting window width */
    setWindowWidth: function () {
      let windowClass = this.getWindowClass();

      this.waitForElement(windowClass, () => {
        this.windowWidth = $(windowClass).width();
      });
    },

    /* get window class */
    getWindowClass: function () {
      return this.showRecentlyViewed === "true"
        ? ".with-recent-viewed"
        : ".without-recent-viewed";
    },

    /* on resize set window width */
    onResize: function () {
      this.windowWidth = $(this.getWindowClass()).width();
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

  /* removing event */
  beforeDestroy: function () {
    window.removeEventListener("resize", this.onResize);
  },
};
</script>
