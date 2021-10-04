<template lang="pug">
.days
  .selector(:style="selectorStyle")
  .day(
    :class="{ active: isActive(day) }",
    :disabled="isDisabled(day)",
    @click="setActive(day, $event)",
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
      selectorStyle: { display: "none" },
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
    setActive(day, ev) {
      this.active = day;

      const left = ev.target.offsetLeft + "px";
      this.selectorStyle = { left };
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
$dayWidth: 45px
.days
  @apply flex mr-auto z-10 relative
  .selector
    width: $dayWidth
    bottom: -1px
    @apply border border-b-0 border-gray-400 bg-gray-100 absolute h-full z-0 duration-300
  .day
    width: $dayWidth
    @apply text-center select-none cursor-pointer duration-500 z-10 py-1
    &.active
      @apply pointer-events-none
    &[disabled='true']
      @apply pointer-events-none text-gray-400
    .content
      @apply hover:bg-white duration-500
    *
      @apply pointer-events-none
</style>
