<template lang="pug">
.calendar
  .active(
    v-if="!!doctor.timeslots.length && !doctor.timeslots[0].slots.length"
  )
    days(:slots="doctor.timeslots[0].slots")
    .slots 123
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
  },
  methods: {},
  computed: {},
};
</script>

<style lang="sass" scoped>
.calendar
  .active
    @apply flex flex-col
    .slots
      @apply border border-gray-400
  .empty
    min-width: 200px
    @apply text-center text-xl
</style>
