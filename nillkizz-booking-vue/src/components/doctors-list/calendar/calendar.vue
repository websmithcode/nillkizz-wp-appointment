<template lang="pug">
.calendar
  .active(
    v-if="!!doctor.timeslots.length && !doctor.timeslots[0].slots.length"
  )
    days(v-model="selectedDay", :slots="doctor.timeslots[0].slots")
    .slots {{ selectedDay }}
  .empty(v-else) 
    .content Записи нет
.full-calendar
</template>

<script>
import days from "./days";
export default {
  components: { days },
  props: {
    doctor: Object,
    selectedDay: {},
  },
  methods: {},
  computed: {},
};
</script>

<style lang="sass" scoped>
.calendar
  width: 380px
  .active
    @apply flex flex-col
    .slots
      @apply border border-gray-400
  .empty
    @apply text-center text-xl
</style>
