<template lang="pug">
.days
  .days-container
    .days-wrapper
      .selector(:style="selectorStyle")
      .day(
        :class="{ selected: value == day.ISO, today: day.isToday }",
        :disabled="day.disabled",
        @click="!day.disabled && selectDay(day.ISO)",
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
    modelValue: String,
    calendar: Object,
  },
  emits: ["update:modelValue"],
  data() {
    return {
      days: Array.from(this.calendar.values()),
      value: undefined,
      daysIsScrolled: false,
      selectorStyle: { display: "none" },
    };
  },
  mounted() {
    this.selectDay(this.days.filter((day) => !day.disabled)[0].ISO);
  },
  methods: {
    selectDay(dayISO) {
      this.value = dayISO;

      this.$nextTick(() => {
        const left =
          this.$el.querySelector(".days .selected").offsetLeft + "px";
        this.selectorStyle = { left };
      });
    },
    scrollDays() {
      const scrollable = this.$el.querySelector(".days .days-wrapper");
      if (this.daysIsScrolled) scrollable.scrollTo(0, 0);
      else scrollable.scrollTo(scrollable.scrollWidth, 0);
      this.daysIsScrolled = !this.daysIsScrolled;
    },
  },
  watch: {
    value() {
      this.$emit("update:modelValue", this.value);
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
        &.selected
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
