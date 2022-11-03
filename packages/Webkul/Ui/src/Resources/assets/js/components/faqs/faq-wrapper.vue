<template>
  <div>
    <div class="faqs-wrapper">
      <faq-item
        v-for="(item, key) in items"
        :key="item.id"
        :link="item"
        :item-id="key + 1"
        :input-name="inputName"
        :required="required"
        :remove-button-label="removeButtonLabel"
        @onRemoveLink="removeLink($event)"
      ></faq-item>
    </div>

    <label
      class="btn btn-lg btn-primary"
      style="display: inline-block; width: auto"
      @click="createFileType"
      v-if="!hideButton"
      >{{ buttonLabel }}</label
    >
  </div>
</template>

<script>
export default {
  props: {
    buttonLabel: {
      type: String,
      required: false,
      default: "Add Link",
    },

    removeButtonLabel: {
      type: String,
      required: false,
      default: "Remove Link",
    },

    inputName: {
      type: String,
      required: false,
      default: "links",
    },

    faqItems: {
      type: Array | String,
      required: false,
      default: () => [],
    },

    multiple: {
      type: Boolean,
      required: false,
      default: true,
    },

    required: {
      type: Boolean,
      required: false,
      default: false,
    },
  },

  data: function () {
    return {
      hideButton: false,
      linkCount: 0,
      items: [],
    };
  },

  created: function () {
    this.initLinks();
  },

  methods: {
    initLinks: function () {
      if (this.multiple) {
        this.initMultiple();
      } else {
        this.initSingle();
      }
    },

    initMultiple: function () {
      let self = this;

      if (this.faqItems.length) {
        this.faqItems.forEach(function (link) {
          self.items.push(link);

          self.linkCount++;
        });
      } else if (this.faqItems.length == undefined && typeof this.faqItems == "object") {
        let faqItems = Object.keys(this.faqItems).map((key) => {
          return this.faqItems[key];
        });

        faqItems.forEach(function (link) {
          self.items.push(link);

          self.linkCount++;
        });
      } else {
        this.createFileType();
      }
    },

    initSingle: function () {
      if (this.faqItems && this.faqItems != "") {
        this.items.push({
          id: this.linkCount,
          faqItems: this.faqItems,
        });

        this.linkCount++;
      } else {
        this.createFileType();
      }

      this.hideButton = true;
    },

    createFileType: function () {
      let self = this;

      if (!this.multiple) {
        this.items.forEach(function (link) {
          self.removeLink(link);
        });

        this.hideButton = true;
      }

      this.linkCount++;

      this.items.push({ id: this.linkCount });
    },

    removeLink: function (link) {
      let index = this.items.indexOf(link);

      if (!this.multiple) this.hideButton = false;

      Vue.delete(this.items, index);
      this.linkCount--;
    },
  },
};
</script>

<style lang="scss" scoped>
.faqs-wrapper {
  margin: 20px 0px;
  display: flex;
  flex-wrap: wrap;
}
</style>
