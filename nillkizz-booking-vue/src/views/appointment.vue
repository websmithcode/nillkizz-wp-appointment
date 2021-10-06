<template lang="pug">
div {{ $route.params }}
</template>

<script>
import { mapGetters } from "vuex";

export default {
  async mounted() {},
  data() {
    return {
      loading: true,
    };
  },
  computed: {
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
