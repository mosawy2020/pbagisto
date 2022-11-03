<template>
  <div class="link-item-wrapper">
    <label
      class="links-item"
      :for="_uid"
      v-bind:class="{ 'has-image': linkData.length > 0 }"
    >
      <div class="control-group">
        <label>Title</label>
        <input
          class="control"
          :name="finalLinkTitleName"
          v-model="linkData.title"
          :id="_uid"
          :required="required ? true : false"
        />
      </div>

      <div class="control-group">
        <label>link Type</label>
        <select
          class="control"
          v-model="linkData.type"
          :name="finalLinkTypeName"
          :id="_uid"
          :required="required ? true : false"
        >
          <option value="link">Link</option>
          <option value="page">Page</option>
        </select>
      </div>
      <div v-if="linkData.type == 'link'" class="control-group">
        <label>Link </label>
        <input
          class="control"
          type="url"
          :name="finalLinkUrlName"
          :id="_uid"
          v-model="linkData.link"
          :required="required ? true : false"
        />
      </div>
      <div v-else-if="linkData.type == 'page'" class="control-group">
        <label>Choose Link</label>

        <select
          class="control"
          :name="finalLinkUrlName"
          :id="_uid"
          v-model="linkData.link"
          :required="required ? true : false"
        >
          <option v-for="page in pages" :value="page.url_key">
            {{ page.page_title }}
          </option>
        </select>
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
      required: true,
      default: 1,
    },
    required: {
      type: Boolean,
      required: false,
      default: false,
    },
    pages: {
      type: Array | String,
      required: false,
      default: () => [],
    },
  },

  data: function () {
    return {
      linkData: {
        type: "link",
        title: "",
        type: "",
      },
    };
  },

  mounted() {
    if (this.link) {
      this.linkData = this.link;
    }
  },

  computed: {
    finalLinkTitleName() {
      return this.inputName + "[" + this.itemId + "][title]";
    },
    finalLinkTypeName() {
      return this.inputName + "[" + this.itemId + "][type]";
    },
    finalLinkUrlName() {
      return this.inputName + "[" + this.itemId + "][link]";
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
.link-item-wrapper {
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
.dark-mode .link-item-wrapper {
  border-color: #24384c;
}
</style>
