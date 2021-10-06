<template lang="pug">
calendar(
  v-if="calendar",
  :calendar="calendar",
  :initialDayISO="$route.params.dayISO",
  :initialSlotTime="$route.params.slotTime"
)
</template>

<script>
import { mapGetters } from "vuex";
import calendar from "@/components/doctors-list/calendar/calendar.vue";

export default {
  components: { calendar },
  computed: {
    ...mapGetters(["mapDoctors"]),
    calendar() {
      const docId = parseInt(this.$route.params.doctorId);
      if (!this.mapDoctors.has(docId)) return;
      return this.mapDoctors.get(docId).calendar;
    },
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
