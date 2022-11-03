<template>
  <div>
    <modal
      class="custome-modal-close"
      :id="elementData.id"
      :is-open="$root.modalIds[`${elementData.id}`]"
    >
      <h3 v-if="elementData" slot="header">
        {{ translation.edit_content ? translation.edit_content: 'Edit' }} ({{ elementData.label }})
        <i class="icon remove-icon" @click="closeModal"></i>
      </h3>

      <!-- _uid -->
      <div slot="body" v-if="IsOpen">
        <!-- <pre>{{ elementData }}</pre> -->
        <div v-if="elementData" class="">
          <div
            v-if="hasKey('title')"
            class="control-group"
            :class="[errors.has('title') ? 'has-error' : '']"
          >
            <label for="title" class="required">{{ translation.title ? translation.title: 'Title' }}</label>
            <input
              type="text"
              v-model="elementData.title"
              v-validate="'required'"
              class="control"
              name="title"
            />
            <span class="control-error" v-if="errors.has('title')">
              {{ errors.first("title") }}
            </span>
          </div>
          <div
            v-if="hasKey('subTitle')"
            class="control-group"
            :class="[errors.has('subTitle') ? 'has-error' : '']"
          >
            <label for="position" class="required">{{ translation.sub_title ? translation.sub_title: 'Sub Title' }}</label>
            <input
              type="subTitle"
              v-model="elementData.subTitle"
              v-validate="'required'"
              class="control"
              name="subTitle"
            />
            <span class="control-error" v-if="errors.has('subTitle')">
              {{ errors.first("subTitle") }}
            </span>
          </div>
          <div v-if="hasKey('content')" class="control-group">
            <label for="position" >{{ translation.content ? translation.content: 'Content' }}</label>
            <textarea
              class="control enable-wysiwyg"
              name="content"
              v-model="elementData.content"
              :id="`content_${elementData.id}`"
              :ref="`content_${elementData.id}`"
            ></textarea>
          </div>
          <div v-if="hasKey('select')" class="control-group">
            <label for="position" class="required">{{ translation.ads ? translation.ads: 'Ads' }}</label>
            <ul class="control select_ad">
              <li
                v-for="(item, index) in adsJsonData"
                :id="item.id"
                :key="item.id"
                class="ad_img"
                :class="[elementData.select == index ? 'selected' : null]"
              >
                <img
                  @click="ChooseAds(index)"
                  class="lazyload"
                  :src="`${base_url}${item}`"
                  :alt="item.id"
                />
              </li>
            </ul>
          </div>
          <div v-if="hasKey('link')" class="control-group" :class="[errors.has('link') ? 'has-error' : '']">
            <label for="link" class="required">{{ translation.link ? translation.link: 'Link' }}</label>
            <input
              type="text"
              v-model="elementData.link"
              class="control"
              name="link"
              v-validate="{url: {require_protocol: true }}"
            />
            <span class="control-error" v-if="errors.has('link')">
                {{ errors.first("link") }}
            </span>
          </div>
          <!-- <div v-if="hasKey('image')" class="control-group">
            <label for="image" class="required">image</label>
            <input
              type="file"
              @change="onFileChange"
              class="control"
              name="image"
            />
          </div> -->
        </div>
        <button type="button" class="btn btn-lg btn-primary" @click="Save()">
            {{ translation.save ? translation.save: 'Save' }}
        </button>
      </div>
    </modal>
  </div>
</template>
<script>
export default {
  props: {
    selectedElement: {
      required: true,
    },
    base_url: {
      type: String,
      required: true,
    },
    translation: {
      type: Object,
      required: true,
    },
    adsJson: {
      type: Object,
      required: true,
    },


  },
  inject: ["$validator"],
  data() {
    return {
      elementData: Object.assign({}, this.selectedElement),
      adsJsonData:  Object.assign({}, this.adsJson),
      modalID: null,
      selected: [],
    };
  },
  computed: {
    IsOpen: function () {
      return this.$root.$data.modalIds[`${this.selectedElement.id}`];
    },
  },

  watch: {
    IsOpen(newValue) {
      if (newValue == true) {
        tinyMCE.execCommand(
          "mceRemoveEditor",
          false,
          `${this.selectedElement.id}`
        );
        console.log(newValue);
        setTimeout(() => {
          tinyMCEHelper.initTinyMCE({
            selector: "textarea.enable-wysiwyg",
            height: 400,
            width: "100%",
            image_advtab: true,
            valid_elements: "*[*]",
            init_instance_callback: function (editor) {
              editor.on("input", function (e) {
                console.log("The " + e.command + " command was fired.");
              });
            },
          });
        }, 300);
      }
    },
  },
  created() {
    // this.elementData = this.selectedElement;
  },
  methods: {
    hasKey(key) {
      return this.elementData.hasOwnProperty(key);
    },
    onFileChange(e) {
      var files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.createImage(files[0]);
    },
    createImage(file) {
      var image = new Image();
      var reader = new FileReader();
      var vm = this;

      reader.onload = (e) => {
        vm.elementData.image = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    ChooseAds(id) {
      console.log(Number(id));
      this.elementData.select = Number(id);
    },
    Save() {
      if (this.containsKey(this.elementData, "content")) {
        this.elementData.content = tinyMCE.activeEditor.getContent();
        tinyMCE.execCommand(
          "mceRemoveControl",
          true,
          `content_${this.elementData.id}`
        );
        tinymce.get(`content_${this.elementData.id}`).remove();
      }

      this.$emit("SaveElement", this.elementData);

      this.$root.$data.modalIds[`${this.selectedElement.id}`] = false;
    },
    containsKey(obj, key) {
      return Object.keys(obj).includes(key);
    },
    closeModal() {
      if (this.containsKey(this.elementData, "content")) {
        tinyMCE.execCommand(
          "mceRemoveControl",
          true,
          `content_${this.elementData.id}`
        );
        tinyMCE.get(`content_${this.elementData.id}`).remove();
      }
      this.$root.$data.modalIds[`${this.selectedElement.id}`] = false;
    },
  },
};
</script>
<style lang="scss" scoped>
.select_ad {
  position: relative;
  height: fit-content;
  display: flex;
  padding: 0.3rem;
  cursor: auto;
  li {
    height: 6rem;
    width: 8rem;
    padding: 0.3rem;
    border-radius: 0.4rem;
    border: 1px solid transparent;
    cursor: pointer;
    &.selected {
      border-color: #0041ff;
    }

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }
}
</style>
