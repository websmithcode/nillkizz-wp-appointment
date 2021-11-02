<template lang="pug">
.calendar 
  .active(v-if="calendar.isActive")
    .days
      .days-container
        .days-wrapper
          .selector(:style="selectorStyle")
          .day(
            :class="{ selected: selectedDayISO == day.ISO, today: day.isToday, 'cursor-not-allowed': day.disabled, 'text-gray-400': day.disabled }",
            @click="!day.disabled && selectDay(day.ISO)",
            v-for="day in days"
          )
            .content
              .dow {{ day.dt.toFormat('ccc').toUpperCase() }}
              .dom {{ day.dt.day }}
      q-btn(
        @click="scrollDays",
        :class="{ rotated: daysIsScrolled }",
        round,
        unelevated,
        color="primary",
        icon="arrow_back_ios_new",
        size="sm",
        padding="sm"
      ) 
    .slots(v-if="calendar.has(selectedDayISO)", color="white")
      .slot(
        v-for="slot in slots.values()",
        :class="{ selected: slot.time == modelValue?.slotTime && selectedDayISO == modelValue?.dayISO }",
        @click="selectSlot(slot)"
      ) {{ slot.time }}
  .empty(v-else) 
    .content Записи нет
</template>

<script>
import { DateTime } from "luxon";

export default {
  props: {
    calendar: Map,
    modelValue: Object,
  },
  emits: ["update:modelValue"],
  data() {
    const now = DateTime.now().startOf("day");
    return {
      now,
      days: Array.from(this.calendar.values()),
      daysIsScrolled: false,
      selectorStyle: { display: "none" },
      selectedDayISO: this.modelValue?.dayISO,
    };
  },
  mounted() {
    if (!this.calendar.isActive) return;
    this.selectDay(
      this.modelValue?.dayISO ??
        this.days.filter((day) => !day.disabled)[0]?.ISO
    );
    this.$nextTick(() => {
      const daysWrapper = this.$el.querySelector(".days .days-wrapper"),
        currentScroll = daysWrapper.scrollLeft,
        selectedOffsetLeft =
          daysWrapper.querySelector(".days .selected").offsetLeft,
        daysWrapperWidth = daysWrapper.offsetWidth;
      if (currentScroll + daysWrapperWidth - 1 < selectedOffsetLeft)
        this.scrollDays();
    });
  },
  methods: {
    selectDay(dayISO) {
      this.selectedDayISO = dayISO;

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
    selectSlot(slot) {
      this.$emit("update:modelValue", {
        dayISO: this.selectedDayISO,
        slotTime: slot.time,
      });
    },
  },
  computed: {
    slots() {
      return this.calendar.get(this.selectedDayISO);
    },
  },
};
</script>

<style lang="sass" scoped>
.calendar
  width: 381px
  .active
    @apply flex flex-col
    $dayWidth: 45px
    $dayHeight: 60px
    .days
      margin-bottom: -1px
      @apply flex sm:ml-3 justify-center items-center
      .days-container
        width: 315px
        height: $dayHeight
        @apply overflow-hidden
        .days-wrapper
          scroll-behavior: smooth
          @apply flex mr-auto z-10 relative overflow-x-scroll overflow-y-hidden
          .selector
            width: $dayWidth
            @apply border border-b-0 border-gray-400 bg-white absolute h-full z-0 duration-300
          .day
            min-width: $dayWidth
            height: $dayHeight
            @apply text-center select-none cursor-pointer duration-500 z-10 py-1 relative
            &.selected
              @apply pointer-events-none
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
    .slots
      @apply border border-gray-400 p-3 bg-white
      @apply grid grid-cols-5 gap-2
      .slot
        @apply bg-gray-500 hover:bg-gray-600 text-white px-2 py-1 text-center cursor-pointer select-none ring-blue-500 ring-0 duration-200
        &.selected
          @apply ring-2
    .q-btn
      @apply duration-200 transform
      &.rotated
        @apply rotate-180
  .empty
    @apply text-center text-xl
</style>
