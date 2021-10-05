<template lang="pug">
.calendar
  .active(v-if="isActive")
    day-selector(v-model="selectedDay", :days="days")
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
    doctor: Object,
    selectedDay: {},
  },
  data() {
    return {
      now: DateTime.now().startOf("day"),
    };
  },
  methods: {},
  computed: {
    isActive() {
      const hasDates = !!this.doctor.timeslots.length;
      const hasTimeslots = this.doctor.timeslots[0]?.slots;
      return hasDates && hasTimeslots && this.days.isActive;
    },
    days() {
      const isDisabled = (day) => {
        return day.dt.ts < this.now || day.length < 1;
      };
      let days = [];
      const slots = Object.entries(this.doctor.timeslots[0].slots);
      if (slots.length > 0)
        days = slots.map((slot) => {
          slot[1].dt = DateTime.fromISO(slot[0]).setLocale("ru");
          slot[1].disabled = isDisabled(slot[1]);
          slot[1].isToday = slot[1].dt.ts == this.now.ts;
          return slot[1];
        });
      else days = [];
      days.isActive = days.some((day) => !day.disabled);
      return days;
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
