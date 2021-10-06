<template lang="pug">
.doctor
  figure.photo-wrap
    .photo(:style="{ backgroundImage: `url(${doctor.photo.url})` }") 
  .info
    h3.name {{ doctor.name }}
    hr.my-2
    .details
      .speciality(v-if="spec") Специальность: {{ spec }}
      .experience(v-if="doctor.experience") Стаж {{ doctor.experience }} Лет
      .education(v-if="education") Образование: {{ education }}
  .appointment
    calendar(:calendar="doctor.calendar")
</template>

<script>
import { mapGetters } from "vuex";
import calendar from "./calendar/calendar.vue";
export default {
  components: { calendar },
  props: {
    doctor: Object,
  },
  computed: {
    ...mapGetters(["specs"]),
    spec() {
      if (this.doctor.spec)
        return this.doctor.spec.map((spec) => spec.name).join(", ");
      return "";
    },
    education() {
      if (this.doctor.education.length) return this.doctor.education.join(", ");
      else return "";
    },
  },
};
</script>

<style lang="sass" scoped>
.doctor
  @apply flex flex-col items-center gap-1 max-w-md w-full
  @apply lg:flex-row lg:max-w-full lg:gap-4
  @apply bg-gray-100 p-3 border border-gray-400
  .photo-wrap
    height: 150px
    width: 150px
    @apply p-1 border border-gray-200 rounded-full flex-shrink-0
    .photo
      @apply w-full h-full bg-center bg-cover rounded-full border border-gray-200
  .info
    @apply flex flex-col w-full
    .name
      @apply text-2xl text-gray-500
</style>
