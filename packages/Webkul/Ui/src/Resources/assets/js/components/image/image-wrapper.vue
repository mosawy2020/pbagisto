<template>
  <div :class="[textarea ? 'with-textarea' : '']">
    <div class="image-wrapper">
      <image-item
        v-for="(image, key) in items"
        :key="image.id"
        :image="image"
        :input-name="inputName"
        :required="required"
        :remove-button-label="removeButtonLabel"
        :add-to-home-button-label="addToHomeButtonLabel"
        @onRemoveImage="removeImage($event)"
        :textarea="textarea"
        :textarea-input="textareaInput"
        :text-old="textOld[key]"
      ></image-item>
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
      default: "Add Image",
    },

    removeButtonLabel: {
      type: String,
      required: false,
      default: "Remove Image",
    },

    addToHomeButtonLabel: {
      type: String,
      required: false,
      default: "Add Section To Home",
    },

    inputName: {
      type: String,
      required: false,
      default: "attachments",
    },

    images: {
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
    textarea: {
      type: Boolean,
      required: false,
      default: false,
    },
    textareaInput: {
      type: String,
      required: false,
      default: "content",
    },
    textOld: {
      type: Array,
      required: false,
      default: () => [],
    },
  },

  data: function () {
    return {
      hideButton: false,
      imageCount: 0,
      items: [],
    };
  },

  created: function () {
    this.initImages();
  },

  methods: {
    initImages: function () {
      if (this.multiple) {
        this.initMultiple();
      } else {
        this.initSingle();
      }
    },

    initMultiple: function () {
      let self = this;

      if (this.images.length) {
        this.images.forEach(function (image) {
          self.items.push(image);

          self.imageCount++;
        });
      } else if (this.images.length == undefined && typeof this.images == "object") {
        let images = Object.keys(this.images).map((key) => {
          return this.images[key];
        });

        images.forEach(function (image) {
          self.items.push(image);

          self.imageCount++;
        });
      } else {
        this.createFileType();
      }
    },

    initSingle: function () {
      if (this.images && this.images != "") {
        this.items.push({
          id: "image_" + this.imageCount,
          image_id: this.imageCount,
          url: this.images,
        });

        this.imageCount++;
      } else {
        this.createFileType();
      }

      this.hideButton = true;
    },

    createFileType: function () {
      let self = this;

      if (!this.multiple) {
        this.items.forEach(function (image) {
          self.removeImage(image);
        });

        this.hideButton = true;
      }

      this.imageCount++;

      this.items.push({ id: "image_" + this.imageCount });
      Vue.nextTick(() => {
        // Prints 'Second', because Vue has updated the DOM
        setTimeout(() => {
          this.iniateTinyMCE();
        }, 100);
      });
    },

    removeImage: function (image) {
      let index = this.items.indexOf(image);

      if (!this.multiple) this.hideButton = false;

      Vue.delete(this.items, index);
      this.imageCount--;
    },
    iniateTinyMCE() {
      console.log("hiissi");
      tinyMCEHelper.initTinyMCE({
        selector:
          "textarea#home_page_content,textarea#footer_left_content,textarea#subscription_bar_content,textarea#footer_middle_content,textarea#product-policy,textarea#home_page_about,textarea#text_ad,textarea#home_page_apps , textarea.enable-wysiwyg",
        height: 400,
        width: "100%",
        image_advtab: true,
        valid_elements: "*[*]",
      });
    },
  },
};
</script>
