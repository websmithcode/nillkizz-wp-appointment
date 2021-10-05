<template lang="pug">
</template>

<script>
import { mapState, mapGetters } from "vuex";
// import api from "@/api";

export default {
  async mounted() {},
  data() {
    return {
      loading: true,
    };
  },
  computed: {
    ...mapState(["config"]),
    ...mapGetters(["IS_LOADING"]),
  },
};
</script>

<style lang="sass">
html, body
  scroll-behavior: smooth
.app_wrapper > .doctors-list
  @apply opacity-100 duration-500
[v-cloack], .app_wrapper.loading
  max-height: 300px
  height: 300px
</style>
