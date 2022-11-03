<template>
  <div class="shimmer-card-container">
    <carousel-component
      id="shimmer-carousel"
      navigation-enabled="hide"
      pagination-enabled="hide"
      :slides-count="shimmerCountInt + 1"
      :slides-per-page="shimmerCountInt"
      :slides-per-page-xlg="slidesPerPageXlg"
      :slides-per-page-lg="slidesPerPageLg"
      :slides-per-page-md="slidesPerPageMd"
      :slides-per-page-sm="slidesPerPageSm"
      :slides-per-page-xs="slidesPerPageXs"
    >
      <slide :key="count" :slot="`slide-${count}`" v-for="count in shimmerCountInt">
        <div class="shimmer-card">
          <div class="shimmer-wrapper">
            <div class="shimmer-product-image animate"></div>
            <div class="comment animate"></div>
            <div class="comment animate"></div>
            <div class="comment animate"></div>
          </div>
        </div>
      </slide>
    </carousel-component>
  </div>
</template>

<script>
export default {
  props: {
    shimmerCount: {
      default: 6,
    },
    slidesPerPageXlg: {},
    slidesPerPageLg: {},
    slidesPerPageMd: {},
    slidesPerPageSm: {},
    slidesPerPageXs: {},
  },

  data: function () {
    return {
      shimmerCountInt: parseInt(this.shimmerCount),
      windowWidth: window.innerWidth,
    };
  },
  mounted() {
    this.slidesPerPage = this.slidesPerPageXlg;
    this.setSlidesPerPage(this.windowWidth);
  },
  methods: {
    setSlidesPerPage: function (width) {
      if (width >= 1200) {
        this.shimmerCountInt = this.slidesPerPageXlg ? this.slidesPerPageXlg : 6;
      } else if (width < 1200 && width >= 992) {
        this.shimmerCountInt = this.slidesPerPageLg ? this.slidesPerPageLg : 5;
      } else if (width < 992 && width >= 822) {
        this.shimmerCountInt = this.slidesPerPageMd ? this.slidesPerPageMd : 4;
      } else if (width < 822 && width >= 626) {
        this.shimmerCountInt = this.slidesPerPageSm ? this.slidesPerPageSm : 3;
      } else {
        this.shimmerCountInt = this.slidesPerPageXs ? this.slidesPerPageXs : 2;
      }
    },
  },
};
</script>

<style>
.shimmer-card-container {
  width: 100%;
}

.shimmer-card {
  margin: 0px 10px 50px 10px;
  padding: 30px 40px;
  border: 2px solid #fff;
  box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
}

.shimmer-product-image {
  width: 100%;
  height: 180px;
}

.comment {
  height: 10px;
  background: #777;
  margin-top: 20px;
}

.shimmer-wrapper {
  width: 0px;
  animation: fullView 0.5s forwards linear;
}

@keyframes fullView {
  100% {
    width: 100%;
  }
}

.animate {
  animation: shimmer 2s infinite;
  background: linear-gradient(to right, #eff1f3 4%, #e2e2e2 25%, #eff1f3 36%);
  background-size: 1000px 100%;
}

@keyframes shimmer {
  0% {
    background-position: -1000px 0;
  }
  100% {
    background-position: 1000px 0;
  }
}
</style>
