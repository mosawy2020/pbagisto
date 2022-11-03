<template>
  <div>
    <div class="usage-wrapper">
      <usage-item
        v-for="(item, key) in items"
        :key="item.id"
        :link="item"
        :item-id="key + 1"
        :base-url="baseUrl"
        :input-name="inputName"
        :required="required"
        :remove-button-label="removeButtonLabel"
        @onRemoveLink="removeLink($event)"
      ></usage-item>
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
      default: "Add Usage",
    },

    removeButtonLabel: {
      type: String,
      required: false,
      default: "Remove Usage",
    },

    inputName: {
      type: String,
      required: false,
      default: "usage",
    },

    usageItems: {
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
    baseUrl: {
      type: String,
      required: true,
      default: "/",
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

      if (this.usageItems.length) {
        this.usageItems.forEach(function (link) {
          self.items.push(link);

          self.linkCount++;
        });
      } else if (
        this.usageItems.length == undefined &&
        typeof this.usageItems == "object"
      ) {
        let usageItems = Object.keys(this.usageItems).map((key) => {
          return this.usageItems[key];
        });

        usageItems.forEach(function (link) {
          self.items.push(link);

          self.linkCount++;
        });
      } else {
        this.createFileType();
      }
    },

    initSingle: function () {
      if (this.usageItems && this.usageItems != "") {
        this.items.push({
          id: this.linkCount,
          usageItems: this.usageItems,
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
.usage-wrapper {
  margin: 20px 0px;
  display: flex;
  flex-wrap: wrap;
}
</style>
