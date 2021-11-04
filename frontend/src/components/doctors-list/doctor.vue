<template lang="pug">
.doctor
  .info
    figure.photo-wrap
      .photo(:style="{ backgroundImage: `url(${doctor.photo.url})` }") 
    .text
      h2.text-secondary.text-h5 {{ doctor.name }}
      hr.my-2
      .details
        .speciality(v-if="specialtyFormatted") Специальность: {{ specialtyFormatted }}
        .education(v-if="education") Образование: {{ education }}
  .appointment
    calendar(:calendar="doctor.calendar", v-model="selectedSlot")
</template>

<script>
import { mapGetters } from "vuex";
import calendar from "./calendar.vue";

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
      this.$router.push({
        name: "appointment",
        params: {
          doctorId: this.doctor.id,
          dayISO: args.dayISO,
          slotTime: args.slotTime,
        },
      });
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
  @apply flex flex-col justify-between items-center gap-4 sm:max-w-xl w-full
  @apply md:flex-row md:max-w-full
  @apply bg-gray-50 p-3 border
  .info
    @apply flex gap-4 flex-col items-center sm:items-start sm:flex-row
    .photo-wrap
      height: 150px
      width: 150px
      @screen md
        height: 100px
        width: 100px
      @screen lg
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
