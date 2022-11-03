<template>
  <ul type="none" class="no-margin relative main-menu-list">
    <li
      :class="[content['content_type'] == 'categorytree' ? 'megamenuu-wrapper' : '']"
      v-for="(content, index) in headerContent"
      :key="index"
    >
      <a
        v-text="content.title"
        :href="`${$root.baseUrl}/${content['page_link']}`"
        v-if="content['content_type'] == 'link' || content['content_type'] == 'category'"
        :target="content['link_target'] ? '_blank' : '_self'"
      >
      </a>
      <a
        v-text="content.title"
        :href="`${$root.baseUrl}/${content.category.slug}`"
        v-else-if="content['content_type'] == 'categorytree'"
        :target="content['link_target'] ? '_blank' : '_self'"
      >
      </a>

      <a
        v-text="content.title"
        :href="`${$root.baseUrl}/page/${content['page_key']}`"
        v-else-if="content['content_type'] == 'page'"
        :target="content['link_target'] ? '_blank' : '_self'"
      >
      </a>

      <a
        v-text="content.title"
        :href="`${content['url']}`"
        v-else-if="content['content_type'] == 'Url'"
        :target="content['link_target'] ? '_blank' : '_self'"
      >
      </a>

      <div
        class="megamenu"
        v-if="content['content_type'] == 'categorytree'"
        type="none"
        style="margin-bottom: 0"
      >
        <div class="container">
          <ul class="mega-menu-list row">
            <li
              :key="`category-${category.id}-${categoryIndex}`"
              :id="`category-${category.id}`"
              v-if="content.category.subcategories.length > 0"
              v-for="(category, categoryIndex) in content.category.subcategories"
              class="parent-category col-md-fifth"
              :style="{ 'transition-delay': (categoryIndex + 1) * 250 + 'ms' }"
            >
              <a :href="`${$root.baseUrl}/${category.url_path}`">{{ category.name }}</a>
              <ul class="sub-category" v-if="category.subcategories.length > 0">
                <!-- <div v-html="category.subcategories"></div> -->
                <li
                  v-for="(subcategory, subcategoryIndex) in category.subcategories"
                  :key="`sub-category-${category.id}-${subcategoryIndex}`"
                  :id="`sub-category-${category.id}`"
                >
                  <a :href="`${$root.baseUrl}/${subcategory.url_path}`">{{
                    subcategory.name
                  }}</a>
                </li>
              </ul>
            </li>
            <li
              class="parent-category col-md-fifth show-all"
              :style="{
                'transition-delay':
                  (content.category.subcategories
                    ? content.category.subcategories.length + 1
                    : 1) *
                    250 +
                  'ms',
              }"
            >
              <a :href="`${$root.baseUrl}/${content.category.slug}`">{{ showAllText }}</a>
            </li>
          </ul>
        </div>
      </div>
    </li>
  </ul>
</template>

<script>
import { sidebarHeader } from "./sidebar";
export default {
  props: ["headerContent", "showAllText"],
  // mounted() {
  //   console.log(this.headerContent);
  // },
};
</script>
