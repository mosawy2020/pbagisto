<template>
  <div class="usage-item-wrapper">
    <label
      class="usage-item"
      :for="_uid"
      v-bind:class="{ 'has-image': linkData.length > 0 }"
    >
      <div class="control-group">
        <label>Title</label>
        <input
          :id="_uid"
          :name="finalFaqTitle"
          v-model="linkData.title"
          :required="required ? true : false"
          class="control"
          rows=""
          cols=""
        ></input>
      </div>

      <div class="control-group">
        <label>Description</label>
        <textarea
          :id="_uid"
          :name="finalFaqDesc"
          v-model="linkData.desc"
          :required="required ? true : false"
          class="control"
          rows=""
          cols=""
        ></textarea>
      </div>

      <div class="control-group">
        <label>image</label>
        <image-single
          v-if="loaded"
          :id="_uid"
          :input-name="finalFaqImage"
          :image="{ id: '1', url: linkData.image ? `${baseUrl}${linkData.image}` : '' }"
          :required="required ? true : false"
          :multiple="false"
        ></image-single>
      </div>

      <label class="remove-Link" @click="removeLink()">{{ removeButtonLabel }}</label>
    </label>
  </div>
</template>

<script>
export default {
  props: {
    inputName: {
      type: String,
      required: false,
      default: "usage",
    },

    removeButtonLabel: {
      type: String,
    },
    addToHomeButtonLabel: {
      type: String,
    },
    link: {
      type: Object,
      required: false,
      default: null,
    },
    itemId: {
      required: true,
      default: 1,
    },
    required: {
      type: Boolean,
      required: false,
      default: false,
    },
    baseUrl: {
      type: String,
      required: true,
      default: "/",
    },
  },

  data: function () {
    return {
      linkData: {
        title: "",
        desc: "",
        image: "",
      },
      loaded: false,
    };
  },

  mounted() {
    if (this.link) {
      this.linkData = this.link;
    }
    this.isLoaded();
  },

  computed: {
    finalFaqTitle() {
      return this.inputName + "[" + this.itemId + "][title]";
    },
    finalFaqDesc() {
      return this.inputName + "[" + this.itemId + "][desc]";
    },
    finalFaqImage() {
      return this.inputName + "[" + this.itemId + "][image]";
    },
  },

  methods: {
    removeLink() {
      this.$emit("onRemoveLink", this.link);
    },
    isLoaded() {
      Vue.nextTick(() => {
        this.loaded = true;
      });
    },
  },
};
</script>
<style lang="scss" scoped>
.usage-item-wrapper {
  padding: 15px;
  border: 1px solid #c7c7c7;
  position: relative;
  border-radius: 4px;
  width: 100%;
  margin-bottom: 10px;
  .remove-Link {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #d20303;
    border-radius: 4px;
    padding: 10px;
    text-align: center;
    color: #ffffff;
    text-shadow: 0 1px 2px rgb(0 0 0 / 24%);
    cursor: pointer;
    font-weight: bold;
  }
}
.dark-mode .usage-item-wrapper {
  border-color: #24384c;
}

@media (min-width: 991px) {
  .usage-item-wrapper {
    width: 49%;
    margin-right: calc(0.5%);
    margin-left: calc(0.5%);
  }
}
</style>
