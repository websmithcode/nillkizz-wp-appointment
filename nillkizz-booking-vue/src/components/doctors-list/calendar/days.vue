<template lang="pug">
.days
  .day(
    :class="{ active: isActive(day) }",
    :disabled="isDisabled(day)",
    @click="active = day",
    v-for="day in days"
  )
    .content
      .dow {{ day.dt.toFormat('ccc').toUpperCase() }}
      .dom {{ day.dt.day }}
</template>

<script>
import { DateTime } from "luxon";
export default {
  props: {
    slots: Object,
  },
  data() {
    return {
      active: undefined,
      now: DateTime.now().startOf("day"),
    };
  },
  mounted() {
    this.active = this.days.filter((day) => day.dt.ts == this.now.ts)[0];
  },
  methods: {
    isActive(day) {
      return day.dt.startOf("day").ts == this.active?.dt.ts;
    },
    isDisabled(day) {
      const isGoneDay = day.dt.ts < this.now;
      return isGoneDay;
    },
  },
  computed: {
    days() {
      const slots = Object.entries(this.slots);
      if (slots.length > 0)
        return slots.map((slot) => {
          slot[1].dt = DateTime.fromISO(slot[0]).setLocale("ru");
          return slot[1];
        });
      else return [];
    },
  },
};
</script>

<style lang="sass" scoped>
.days
  margin-bottom: -1px
  @apply flex mr-auto z-10
  .day
    @apply p-1 text-center select-none cursor-pointer duration-500
    &.active
      @apply border border-gray-400 pointer-events-none
    &.active
      border-bottom-color: #F3F4F6
    &[disabled='true']
      @apply pointer-events-none text-gray-400
    .content
      @apply px-3 py-2 hover:bg-white duration-500
</style>
