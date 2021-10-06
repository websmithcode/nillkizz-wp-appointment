<template lang="pug">
.calendar
  .active(v-if="calendar.isActive")
    day-selector(:days="calendar")
    slot-selector(:slots="selectedDay")
  .empty(v-else) 
    .content Записи нет
.full-calendar
</template>

<script>
import { DateTime } from "luxon";
import daySelector from "./day-selector";
import slotSelector from "./slot-selector";
export default {
  components: { daySelector, slotSelector },
  props: {
    calendar: Array,
  },
  data() {
    const now = DateTime.now().startOf("day");
    return {
      now,
    };
  },
  methods: {},
  computed: {
    selectedDay() {
      return this.calendar.filter((day) => day.selected)[0];
    },
  },
};
</script>

<style lang="sass" scoped>
.calendar
  width: 381px
  .active
    @apply flex flex-col
  .empty
    @apply text-center text-xl
</style>
