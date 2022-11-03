<template>
  <div class="faq-item-wrapper">
    <label
      class="faq-item"
      :for="_uid"
      v-bind:class="{ 'has-image': linkData.length > 0 }"
    >
      <div class="control-group">
        <label>Title</label>
        <input
          class="control"
          :name="finalFaqTitle"
          v-model="linkData.title"
          :id="_uid"
          :required="required ? true : false"
        />
      </div>

      <div class="control-group">
        <label>Content</label>
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
      default: "links",
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
      type: String,
      required: true,
      default: 1,
    },
    required: {
      type: Boolean,
      required: false,
      default: false,
    },
  },

  data: function () {
    return {
      linkData: {
        title: "",
        desc: "",
      },
    };
  },

  mounted() {
    if (this.link) {
      this.linkData = this.link;
    }
    console.log("link", this.link);
  },

  computed: {
    finalFaqTitle() {
      return this.inputName + "[" + this.itemId + "][title]";
    },
    finalFaqDesc() {
      return this.inputName + "[" + this.itemId + "][desc]";
    },
  },

  methods: {
    removeLink() {
      this.$emit("onRemoveLink", this.link);
    },
  },
};
</script>
<style lang="scss" scoped>
.faq-item-wrapper {
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
.dark-mode .faq-item-wrapper {
  border-color: #24384c;
}

@media (min-width: 991px) {
  .faq-item-wrapper {
    width: 49%;
    margin-right: calc(0.5%);
    margin-left: calc(0.5%);
  }
}
</style>
