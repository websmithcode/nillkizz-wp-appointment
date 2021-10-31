<template lang="pug">
.view-wrapper(v-cloak, :class="{ loaded: !IS_LOADING }")
  router-view(v-model:doctorToAppointment="doctorToAppointment")
debug-area
</template>

<script>
import { mapGetters } from "vuex";
import debugArea from "@/components/debug-area";
export default {
  components: {
    debugArea,
  },
  beforeCreate() {
    this.$store.dispatch("fetchDoctorsAndSpecs");
  },
  data() {
    return {
      doctorToAppointment: undefined,
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
  @apply text-gray-800 h-full
  .view-wrapper
    @apply opacity-0 pointer-events-none max-w-5xl m-auto
    &.loaded
      @apply opacity-100 duration-500 pointer-events-auto
  [v-cloack]
    height: 300px
    @apply hidden
</style>
