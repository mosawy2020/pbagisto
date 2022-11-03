<template>
  <div class="share-btn">
    <button @click="share">
      <i class="share-icon"></i>
    </button>
  </div>
</template>
<script>
export default {
  props: {
    url: {
      type: String,
      default: "",
    },
    title: {
      type: String,
      default: "",
    },
  },
  methods: {
    share() {
      if (navigator.share) {
        navigator
          .share({
            title: this.title,
            url: this.url,
          })
          .then(() => {
            // console.log("Thanks for sharing!");
          })
          .catch(console.error);
      } else {
        // fallback
      }
    },
  },
};
</script>
