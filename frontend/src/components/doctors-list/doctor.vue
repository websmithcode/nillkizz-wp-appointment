<template lang="pug">
.doctor
  .info
    figure.photo-wrap
      .photo(:style="{ backgroundImage: `url(${doctor.photo.url})` }") 
    .text
      h3.name {{ doctor.name }}
      hr.my-2
      .details
        .speciality(v-if="doctor.specialty") Специальность: {{ specialtyFormatted }}
        .experience(v-if="doctor.experience") Стаж {{ experienceFormatted }}
        .education(v-if="education") Образование: {{ education }}
  .appointment
    calendar(:calendar="doctor.calendar", v-model="selectedSlot")
</template>

<script>
import { mapGetters } from "vuex";
import calendar from "./calendar.vue";
import { yearsToStr } from "@/inc/rusHelpers.js";

export default {
  components: { calendar },
  props: {
    doctor: Object,
  },
  data() {
    return { selectedSlot: {} };
  },
  methods: {
    goToAppointment(args) {
      this.$router.push(
        `/appointment/doctor_${this.doctor.id}/day_${args.dayISO}/slot_${args.slotTime}`
      );
    },
  },
  computed: {
    ...mapGetters(["specs"]),
    specialtyFormatted() {
      return this.doctor.specialty.map((spec) => spec.val).join(", ");
    },
    education() {
      return this.doctor.education.map((ed) => ed.val).join(", ");
    },
    experienceFormatted() {
      return yearsToStr(this.doctor.experience);
    },
  },
  watch: {
    selectedSlot(newVal) {
      this.goToAppointment(newVal);
    },
  },
};
</script>

<style lang="sass" scoped>
.doctor
  @apply flex flex-col justify-between items-center gap-4 md:max-w-xl w-full
  @apply lg:flex-row lg:max-w-full
  @apply bg-gray-50 p-3 border border-gray-400
  .info
    @apply flex gap-4 flex-col items-center sm:items-start sm:flex-row
    .photo-wrap
      height: 150px
      width: 150px
      @apply p-1 border border-gray-200 rounded-full flex-shrink-0
      .photo
        @apply w-full h-full bg-center bg-cover rounded-full border border-gray-200
    .text
      @apply flex flex-col w-full
      .name
        @apply text-2xl text-gray-500
</style>
