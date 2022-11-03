<template>
  <div>
    <textarea :name="inputName" v-model="ckeditorData" style="display: none"></textarea>
    <ckeditor v-model="ckeditorData" :config="ckeditorConfig"></ckeditor>
  </div>
</template>

<script>
export default {
  data() {
    return {
      ckeditorData: "",
      ckeditorConfig: {
        extraPlugins: "colorbutton,colordialog",
      },
    };
  },
  props: {
    oldValue: {
      type: String,
      required: false,
      default: "",
    },
    inputName: {
      type: String,
      required: false,
      default: "textarea",
    },
  },
  mounted() {
    this.ckeditorData = this.oldValue;
  },
};
</script>
