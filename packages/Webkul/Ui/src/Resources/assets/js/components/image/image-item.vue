<template>
  <div class="image-item-wrapper">
    <label
      class="image-item"
      :for="_uid"
      v-bind:class="{ 'has-image': imageData.length > 0 }"
    >
      <input type="hidden" :name="finalInputName" />

      <input
        type="file"
        v-validate="'mimes:image/*'"
        accept="image/*"
        :name="finalInputName"
        ref="imageInput"
        :id="_uid"
        @change="addImageView($event)"
        :required="required ? true : false"
      />

      <img class="preview" :src="imageData" v-if="imageData.length > 0" />

      <label class="remove-image" @click="removeImage()">{{ removeButtonLabel }}</label>
      <!-- <button
        v-if="textarea"
        type="button"
        class="add-image-section"
        @click="addAdSection()"
      >
        {{ addToHomeButtonLabel }}
      </button> -->
    </label>
    <div v-if="textarea" class="textarea-wrapper">
      <textarea
        v-model="editorData"
        class="enable-wysiwyg"
        :name="finalTextareaName"
        rows=""
        cols=""
      ></textarea>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    inputName: {
      type: String,
      required: false,
      default: "attachments",
    },

    removeButtonLabel: {
      type: String,
    },
    addToHomeButtonLabel: {
      type: String,
    },

    image: {
      type: Object,
      required: false,
      default: null,
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
      imageData: "",
      editorData: "",
      editorConfig: {
        extraPlugins: "colorbutton,colordialog",

        // The configuration of the editor.
      },
    };
  },

  mounted() {
    if (this.image.id && this.image.url) {
      this.imageData = this.image.url;
    }
    if (this.textOld && this.textOld.text) {
      this.editorData = this.textOld.text;
    }
  },

  computed: {
    finalInputName() {
      return this.inputName + "[" + this.image.id + "]";
    },
    finalTextareaName() {
      return this.textareaInput + "[" + this.image.id + "]";
    },
  },

  methods: {
    addImageView() {
      var imageInput = this.$refs.imageInput;

      if (imageInput.files && imageInput.files[0]) {
        if (imageInput.files[0].type.includes("image/")) {
          var reader = new FileReader();

          reader.onload = (e) => {
            this.imageData = e.target.result;
          };

          reader.readAsDataURL(imageInput.files[0]);
        } else {
          imageInput.value = "";
          alert("Only images (.jpeg, .jpg, .png, ..) are allowed.");
        }
      }
    },

    removeImage() {
      this.$emit("onRemoveImage", this.image);
    },

    addAdSection() {
      let elem = document.getElementsByName("home_page_content")[0];
      let old = elem.value;
      let newVal = `@include('shop::home.advertisements.advertisement-general', ['value' => '${this.image.image_id}']) `;
      elem.value = old + newVal;
    },
  },
};
</script>
