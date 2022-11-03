<template>
  <div>
    <div class="control-group">
      <label>Choose Block</label>
      <select v-model="SelectedBlock" name="" class="control">
        <option value="about_section">about section</option>
        <option value="advertisements">advertisements</option>
        <option value="new_products">new products</option>
        <option value="featured_products">featured products</option>
        <option value="apps_section">apps section</option>
      </select>
      <button @click="AddItem()" class="btn btn-lg btn-primary" type="button">
        Add
      </button>
    </div>
    <div class="dragaable-area">
      <draggable v-model="ContentArr" draggable=".item">
        <div
          v-for="(element, index) in ContentArr"
          :key="element.id"
          class="item"
        >
          <contentElement
            @RemoveItem="RemoveItem(index)"
            :base_url="base_url"
            :element="element"
            @SaveElement="SaveElement"
            :translation="translationData"
            :adsJson ="adsJson"
          ></contentElement>
        </div>
        <!-- <button slot="footer" @click="addPeople">Add</button> -->
      </draggable>
    </div>
    <textarea
      name="home_page_content"
      v-show="false"
      v-model="finalOutput"
    ></textarea>
    <textarea
      name="home_page_content_json"
      v-show="false"
      v-model="ContentArrJSon"
    ></textarea>
  </div>
</template>
<script>
import draggable from "vuedraggable";

import contentElement from "./content-element";
export default {
  props: {
    base_url: {
      default: "",
      type:String,
      required:true
    },
    bladeContent: {
      default: "",
      type:String,
      required:true
    },
    jsonContent: {
      default: "[]",
      type:String,
      required:true
    },
    translation:{
        default: "{}",
        type:String,
        required:true
    },
    adsJson:{
        default: {},
        type:Object,
        required:true
    }
  },
  data: function () {
    return {
      SelectedBlock: null,
      selectedElement: null,
      ContentArr: Object.assign([], JSON.parse(this.jsonContent)),
      finalInclude: null,
      translationData : Object.assign({}, JSON.parse(this.translation)),

    };
  },
  components: {
    draggable,
    contentElement,
  },
  computed: {
    finalOutput: function () {
      let template = "";
      this.ContentArr.map((item) => {
        if (item.type == "about") {
          template += `@include('shop::home.about_section',  ['content' => '${item.content}'])`;
        } else if (item.type == "advertisement") {
          template += `@include('shop::home.advertisements.advertisement-general', ['value' => '${item.select}']) `;
        } else if (item.type == "new_products") {
          template += `@include('shop::home.new-products', ['title'=>'${item.title}' , 'subTitle'=> '${item.subTitle}', 'link'=>'${item.link}'])`;
        } else if (item.type == "featured_products") {
          template += `@include('shop::home.featured-products')`;
        } else if (item.type == "apps_section") {
          template += `@include('shop::home.apps-section' , ['content' => '${item.content}'])`;
        }
      });
      return template;
    },
    ContentArrJSon: function(){
        return JSON.stringify(this.ContentArr)
    }
  },
  methods: {
    AddItem(id) {
      let types = JSON.parse(
        document.getElementById("fixedContentBlocks").value
      );
      if (this.SelectedBlock) {
        let SelectedBlockWithId = types[`${this.SelectedBlock}`];
        SelectedBlockWithId.id = `${
          types[`${this.SelectedBlock}`].type
        }_${this.TimeStamp()}`;

        this.ContentArr.push(SelectedBlockWithId);
      }
    },
    RemoveItem(id) {
      this.ContentArr.splice(id, 1);
      console.log(id);
    },
    TimeStamp() {
      let dateTime = Math.round(+new Date() / 1000);
      return dateTime;
    },
    SaveElement(value) {
      console.log("hhiii", value);
      let arr = [...this.ContentArr];
      arr.map((item, index) => {
        if (item.id == value.id) {
          console.log(item.id, value.id);
          arr[index] = value;
        }
      });
      this.ContentArr = arr;
    },
  },
};
</script>
<style lang="scss">
.dragaable-area {
  border: 1px solid #ddd;
  padding: 15px 10px;
  max-width: 500px;
  min-height: 300px;
  .item {
    padding: 10px 15px;
    background: rgb(240 240 240);
    margin-bottom: 15px;
    border-radius: 4px;
    border: 1px solid;
    color: #9497b8;
    font-weight: bold;
    .dragable-item-item {
      cursor: all-scroll;
      display: flex;
      justify-content: space-between;
      align-content: center;
      > span {
        align-self: center;
      }
    }
    button {
      border: 0;
    }
  }
}
</style>
