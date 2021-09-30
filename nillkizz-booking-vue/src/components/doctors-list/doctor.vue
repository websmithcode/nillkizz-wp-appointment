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
    .calendar
      .active(v-if="true") Active
        .days days
        .slots
      .empty(v-else) Empty
    .full-calendar
</template>

<script>
export default {
  props: {
    doctor: Object,
    specs: Object,
  },
  methods: {
    rerender() {
      this.$forceUpdate();
    },
  },
  computed: {
    spec() {
      if (Object.keys(this.doctor.specialty).length)
        return this.doctor.specialty.map((spec) => spec.name).join(", ");
      else return "";
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
  @apply flex gap-4 bg-gray-100 mb-2 p-3 border border-gray-400
  .photo-wrap
    height: 150px
    width: 150px
    @apply p-1 border border-gray-200 rounded-full flex-shrink-0
    .photo
      @apply w-full h-full bg-center bg-cover rounded-full border border-gray-200
  .info
    @apply flex flex-col pt-2 w-full
    .name
      @apply text-2xl text-gray-500
    .details
      @apply  text-gray-900
</style>
