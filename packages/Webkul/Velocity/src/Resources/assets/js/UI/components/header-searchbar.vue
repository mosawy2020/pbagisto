<template>
  <div class="btn-group full-width force-center">
    <div class="selectdiv">
      <select
        class="form-control fs13 styled-select"
        name="category"
        aria-label="Category"
        @change="focusInput($event)"
      >
        <option value="" v-text="__('header.all-categories')"></option>

        <template v-for="(category, index) in $root.sharedRootCategories">
          <option
            :key="index"
            selected="selected"
            :value="category.id"
            v-if="category.id == searchedQuery.category"
            v-text="category.name"
          ></option>

          <option
            :key="index"
            :value="category.id"
            v-text="category.name"
            v-else
          ></option>
        </template>
      </select>

      <div class="select-icon-container d-inline-block float-right">
        <span class="select-icon rango-arrow-down"></span>
      </div>
    </div>

    <input
      required
      name="term"
      type="search"
      class="form-control"
      :placeholder="__('header.search-text')"
      aria-label="Search"
      @keyup="search()"
      v-model:value="inputVal"
    />
    <div
      v-if="liveSearch && liveSearchResult != null && inputVal != ''"
      class="live-search-result"
    >
      <ul v-if="inputVal != ''">
        <li v-for="item in liveSearchResult">
          <a :href="`${$root.baseUrl}/${item.url_key}`">
            <img class="lazyload" :src="item.images.small_image_url" alt="" />
            <div class="item-info">
              <h5 class="name">{{ item.name }}</h5>
              <div class="price" v-html="item.final_price"></div>
            </div>
          </a>
        </li>
      </ul>
    </div>

    <slot name="image-search"></slot>

    <button
      class="btn"
      type="button"
      id="header-search-icon"
      aria-label="Search"
      @click="submitForm"
    >
      <i class="fs16 fw6 rango-search"></i>
    </button>
  </div>
</template>

<script type="text/javascript">
export default {
  props: ["liveSearch"],
  data: function () {
    return {
      inputVal: "",
      searchedQuery: [],
      liveSearchResult: null,
    };
  },

  created: function () {
    let searchedItem = window.location.search.replace("?", "");
    searchedItem = searchedItem.split("&");

    let updatedSearchedCollection = {};

    searchedItem.forEach((item) => {
      let splitedItem = item.split("=");
      updatedSearchedCollection[splitedItem[0]] = decodeURI(splitedItem[1]);
    });

    if (updatedSearchedCollection["image-search"] == 1) {
      updatedSearchedCollection.term = "";
    }

    this.searchedQuery = updatedSearchedCollection;

    if (this.searchedQuery.term) {
      this.inputVal = decodeURIComponent(this.searchedQuery.term.split("+").join(" "));
    }
  },

  methods: {
    focusInput: function (event) {
      $(event.target.parentElement.parentElement).find("input").focus();
    },

    submitForm: function () {
      if (this.inputVal !== "") {
        $("input[name=term]").val(this.inputVal);
        $("#search-form").submit();
      }
    },
    search() {
      if (this.liveSearch && this.inputVal != "" && this.inputVal != null) {
        this.$http
          .get(`${this.liveSearch}?category=&term=${this.inputVal}`)
          .then((response) => {
            console.log(response);
            this.liveSearchResult = response.data[0].data;
            response.data[1].map((item, index) => {
              this.liveSearchResult[index]["final_price"] = item;
            });
            response.data[2].map((item, index) => {
              this.liveSearchResult[index]["images"] = item[0] ? item[0] : item;
            });
            console.log(this.liveSearchResult);
          })
          .catch((error) => {});
      } else {
        this.liveSearchResult = null;
      }
    },
  },
};
</script>
