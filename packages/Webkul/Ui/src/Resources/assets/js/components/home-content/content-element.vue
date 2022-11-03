<template>
  <div>
    <div class="dragable-item-item">
      <span>{{ element.label }}</span>
      <div>
        <button v-if="element.edit == 'true'" class="" type="button" @click="OpenEditModal(element)">
          <span class="icon pencil-lg-icon"></span>
        </button>
        <button class="" type="button" @click="RemoveItem(element)">
          <span class="icon trash-icon"></span>
        </button>
      </div>
    </div>
    <contentModal
      :base_url="base_url"
      :selectedElement="element"
      @SaveElement ="SaveElement"
      :translation="translation"
      :adsJson="adsJson"
    ></contentModal>
  </div>
</template>
<script>
import contentModal from "./content-modal";
export default {
  props: {
    element: {
      required: true,
      type: Object,
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
  data() {
    return {
      elementData: null,
    };
  },
  components: {
    contentModal,
  },
  mounted() {
    this.elementData = this.element;
    // this.elementData.id = `${this.elementData.type}${this.TimeStamp()}`;
  },
  methods: {
    OpenEditModal(element) {
      // console.log(element.id);
      this.selectedElement = element;
      this.$root.showModal(`${element.id}`);
    },
    RemoveItem(element) {
      this.$emit("RemoveItem", element);
    },
    SaveElement(value){
        this.elementData = value
        this.$emit("SaveElement", value);
    }
  },
};
</script>
<style lang="scss">
    .custome-modal-close{
        .modal-header{
            >i.icon.remove-icon{
                display: none;
            }
            h3{
                display: block;
            }
        }
    }
</style>
