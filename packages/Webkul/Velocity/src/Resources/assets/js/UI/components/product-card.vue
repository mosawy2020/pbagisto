<template>
  <div
    class="col-12 lg-card-container list-card product-card row"
    :class="productClasses"
    v-if="list"
  >
    <div class="product-image">
      <a
        :title="product.name"
        :href="`${baseUrl}/${product.slug}`"
        @dragover.prevent="stopLink($event)"
        @drop.prevent="stopLink($event)"
        @dragstart.prevent="stopLink($event)"
        @dragenter.prevent="stopLink($event)"
        @dragleave.prevent="stopLink($event)"
        @dragend.prevent="stopLink($event)"
      >
        <img
          :src="product.image || product.product_image"
          :onerror="`this.src='${this.$root.baseUrl}/themes/pura_theme/assets/images/placeholder2.svg'`"
        />

        <product-quick-view-btn
          :quick-view-details="product"
          v-if="!isMobile()"
        ></product-quick-view-btn>
      </a>
    </div>

    <div class="product-information">
      <div>
        <div class="product-name">
          <a :href="`${baseUrl}/${product.slug}`" :title="product.name" class="unset">
            <span class="fs16">{{ product.name }}</span>
          </a>
        </div>

        <div class="sticker new" v-if="product.new">
          {{ product.new }}
        </div>

        <div class="product-price" v-html="product.priceHTML"></div>

        <div
          class="product-rating"
          v-if="product.totalReviews && product.totalReviews > 0"
        >
          <star-ratings :ratings="product.avgRating"></star-ratings>
          <span>{{
            __("products.reviews-count", { totalReviews: product.totalReviews })
          }}</span>
        </div>

        <div class="product-rating" v-else>
          <span class="fs14" v-text="product.firstReviewText"></span>
        </div>

        <vnode-injector :nodes="getDynamicHTML(product.addToCartHtml)"></vnode-injector>
        <product-share
          :url="`${baseUrl}/${product.slug}`"
          :title="product.name"
        ></product-share>
      </div>
    </div>
  </div>

  <div class="card grid-card product-card-new" :class="productClasses" v-else>
    <a
      :href="`${baseUrl}/${product.slug}`"
      :title="product.name"
      class="product-image-container"
      @pointerdown="handleDown"
      @pointerup="handleUp"
      @pointercancel="handleUp"
      @click="handleClick"
      ref="draggableRoot"
    >
      <img
        loading="lazy"
        :alt="product.name"
        :src="`${baseUrl}/themes/pura_theme/assets/images/placeholder2.svg`"
        :data-src="product.image || product.product_image"
        class="card-img-top lzy_img lazyload"
        :onerror="`this.src='${this.$root.baseUrl}/themes/pura_theme/assets/images/placeholder2.svg'`"
      />
      <!-- :src="`${$root.baseUrl}/vendor/webkul/ui/assets/images/product/meduim-product-placeholder.png`" /> -->

      <product-quick-view-btn :quick-view-details="product"></product-quick-view-btn>
    </a>
    <div class="sticker new" v-if="product.new">
      {{ product.new }}
    </div>
    <div class="card-body">
      <div
        class="card-overlay"
        :style="{
          background: `linear-gradient(0deg, ${color} 0%, rgba(255,255,255,0) 100%)`,
        }"
      ></div>
      <div class="product-name col-12 no-padding">
        <a class="unset" :title="product.name" :href="`${baseUrl}/${product.slug}`">
          <span class="fs16">{{ product.name }}</span>
        </a>
      </div>

      <div class="product-desc" v-if="showDesc">
        {{ product.shortDescription }}
      </div>

      <div v-html="product.priceHTML"></div>

      <div
        class="product-rating col-12 no-padding"
        v-if="product.totalReviews && product.totalReviews > 0"
      >
        <star-ratings :ratings="product.avgRating"></star-ratings>
        <a
          class="fs14 align-top unset active-hover"
          :href="`${$root.baseUrl}/reviews/${product.slug}`"
        >
          {{ __("products.reviews-count", { totalReviews: product.totalReviews }) }}
        </a>
      </div>

      <div class="product-rating col-12 no-padding" v-else>
        <span class="fs14" v-text="product.firstReviewText"></span>
      </div>
      <div class="product-actions">
        <vnode-injector :nodes="getDynamicHTML(product.addToCartHtml)"></vnode-injector>
        <product-share
          :url="`${baseUrl}/${product.slug}`"
          :title="product.name"
        ></product-share>
      </div>
    </div>
  </div>
</template>

<script type="text/javascript">
import { FastAverageColor } from "fast-average-color";
export default {
  props: ["list", "product", "showDesc", "slider", "productClasses"],

  data: function () {
    return {
      addToCart: 0,
      addToCartHtml: "",
      color: null,
      x: 100,
      y: 100,
      left: 0,
      top: 0,
      drag: false,
      click: false,
    };
  },
  created() {
    this.overlayColor();
  },
  methods: {
    isMobile: function () {
      if (
        /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
          navigator.userAgent
        )
      ) {
        return true;
      } else {
        return false;
      }
    },
    overlayColor() {
      let fac = new FastAverageColor();

      fac
        .getColorAsync(this.product.image || this.product.product_image)
        .then((color) => {
          //   container.style.backgroundColor = color.rgba;
          //   container.style.color = color.isDark ? "#fff" : "#000";
          this.color = color.hex;
          // console.log("Average color", color);
        })
        .catch((e) => {
          console.log(e);
        });
    },
    handleMove({ pageX, pageY, clientX, clientY }) {
      if (this.$refs.draggableRoot) {
        this.x = pageX + this.left;
        this.y = pageY + this.top;
        this.drag = true;
      }
    },
    handleDown(event) {
      const { pageX, pageY } = event;
      const { left, top } = this.$refs.draggableRoot.getBoundingClientRect();
      this.left = left - pageX;
      this.top = top - pageY;
      document.addEventListener("pointermove", this.handleMove);
    },
    handleUp() {
      document.removeEventListener("pointermove", this.handleMove);
      setTimeout(() => (this.drag = false));
    },
    handleClick() {
      if (!this.drag) {
        this.click = !this.click;
      }
    },
    stopLink(event) {
      event.preventDefault();
      console.log("hii");
    },
  },
};
</script>
