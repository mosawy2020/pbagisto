<template>
  <transition name="slide">
    <nav class="row" id="top" v-if="opened">
      <button @click="closeOffer" class="close-btn">
        <i class="material-icons"> close </i>
      </button>

      <div v-html="textData" class="top-ad-text"></div>
    </nav>
  </transition>
</template>
<script>
export default {
  props: {
    textData: {
      type: String,
      required: false,
      default: "",
    },
  },
  data() {
    return {
      opened: true,
    };
  },
  methods: {
    closeOffer() {
      this.opened = false;
    },
  },
};
</script>
<style>
.slide-enter-active {
  -moz-transition-duration: 0.6s;
  -webkit-transition-duration: 0.6s;
  -o-transition-duration: 0.6s;
  transition-duration: 0.6s;
  -moz-transition-timing-function: ease-in-out;
  -webkit-transition-timing-function: ease-in-out;
  -o-transition-timing-function: ease-in-out;
  transition-timing-function: ease-in-out;
}

.slide-leave-active {
  -moz-transition-duration: 0.6s;
  -webkit-transition-duration: 0.6s;
  -o-transition-duration: 0.6s;
  transition-duration: 0.6s;
  -moz-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
  -webkit-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
  -o-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
  transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
}

.slide-enter-to,
.slide-leave {
  max-height: 100px;
  overflow: hidden;
}

.slide-enter,
.slide-leave-to {
  overflow: hidden;
  max-height: 0;
}
</style>
