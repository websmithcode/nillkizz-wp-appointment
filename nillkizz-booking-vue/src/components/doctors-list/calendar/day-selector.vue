<template lang="pug">
.days
  .days-container
    .days-wrapper
      .selector(:style="selectorStyle")
      .day(
        :class="{ active: isActive(day), today: day.isToday }",
        :disabled="day.disabled",
        @click="!day.disabled && setActive(day, $event.target)",
        v-for="day in days"
      )
        .content
          .dow {{ day.dt.toFormat('ccc').toUpperCase() }}
          .dom {{ day.dt.day }}

  .control(@click="scrollDays") 
    chevron-right-icon.icon(:class="{ back: daysIsScrolled }")
</template>

<script>
import { ChevronRightIcon } from "@heroicons/vue/solid";
export default {
  components: { ChevronRightIcon },
  props: {
    modelValue: Object,
    days: Object,
  },
  emits: ["update:modelValue"],
  data() {
    return {
      active: undefined,
      selectorStyle: { display: "none" },
      daysIsScrolled: false,
    };
  },
  mounted() {
    this.setActive(this.days.filter((day) => !day.disabled)[0]);
  },
  methods: {
    isActive(day) {
      return day.dt.startOf("day").ts == this.active?.dt.ts;
    },
    setActive(day) {
      this.active = day;
      this.$nextTick(() => {
        const left = this.$el.querySelector(".days .active").offsetLeft + "px";
        this.selectorStyle = { left };
      });
      this.$emit("update:modelValue", day);
    },
    scrollDays() {
      const scrollable = this.$el.querySelector(".days .days-wrapper");
      if (this.daysIsScrolled) scrollable.scrollTo(0, 0);
      else scrollable.scrollTo(scrollable.scrollWidth, 0);
      this.daysIsScrolled = !this.daysIsScrolled;
    },
  },
};
</script>

<style lang="sass" scoped>
$dayWidth: 45px
$dayHeight: 60px
.days
  margin-bottom: -1px
  @apply flex sm:ml-3 justify-center
  .days-container
    width: 315px
    height: $dayHeight
    @apply overflow-hidden
    .days-wrapper
      scroll-behavior: smooth
      @apply flex mr-auto z-10 relative overflow-x-scroll
      .selector
        width: $dayWidth
        @apply border border-b-0 border-gray-400 bg-gray-100 absolute h-full z-0 duration-300
      .day
        min-width: $dayWidth
        height: $dayHeight
        @apply text-center select-none cursor-pointer duration-500 z-10 py-1 relative
        &.active
          @apply pointer-events-none
        &[disabled='true']
          @apply text-gray-400 cursor-not-allowed
        .content
          @apply hover:bg-white duration-500
        *
          @apply pointer-events-none
        &.today:after
          content: ''
          $size: 6px
          height: $size
          width: $size
          left: calc(50% - 3px)
          @apply absolute bottom-1 bg-blue-500 rounded-full

  .control
    width: 30px
    @apply hidden
    @apply sm:flex justify-center items-center select-none cursor-pointer mx-3
    .icon
      @apply w-8 text-white duration-300 transform p-1 bg-gray-400 rounded-full
      &.back
        @apply rotate-180
</style>
