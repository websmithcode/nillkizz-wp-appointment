<template lang="pug">
.view-wrapper(v-cloak, :class="{ loaded: !IS_LOADING }")
  router-view(
    v-model:doctorToAppointment="doctorToAppointment",
    v-slot="{ Component }"
  )
    transition(name="fade", mode="out-in")
      component(:is="Component")
  q-resize-observer(@resize="onResize")
//- debug-area
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
  methods: {
    onResize(size) {
      this.$nextTick(() => {
        parent.postMessage(
          JSON.stringify({
            action: "resize",
            height: size.height,
          }),
          "*"
        );
      });
    },
  },
  computed: {
    ...mapGetters(["IS_LOADING"]),
  },
};
</script>
<style lang="sass">
.fade-enter-active, .fade-leave-active
  transition: opacity .3s ease
.fade-enter-from, .fade-leave-to
  opacity: 0

html, body
  scroll-behavior: smooth
  @apply text-gray-800
  .view-wrapper
    @apply opacity-0 pointer-events-none max-w-5xl m-auto
    &.loaded
      @apply opacity-100 duration-500 pointer-events-auto
  [v-cloack]
    height: 300px
    @apply hidden
</style>
