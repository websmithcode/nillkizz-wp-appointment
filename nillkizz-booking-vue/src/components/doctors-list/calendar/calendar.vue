<template lang="pug">
.calendar
  .active(v-if="calendar.isActive")
    day-selector(:calendar="calendar", v-model="selectedDayISO")
    slot-selector(
      v-if="calendar.has(selectedDayISO)",
      :selectedDay="selectedDay",
      v-model="selectedSlot"
    )
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
    calendar: Map,
    initialDayISO: String,
    initialSlotTime: String,
  },
  emits: ["slotSelected"],
  data() {
    const now = DateTime.now().startOf("day");
    return {
      now,
      selectedDayISO: this.initialDayISO ?? undefined,
      selectedSlot: this.initialSlotTime ?? undefined,
    };
  },
  computed: {
    selectedDay() {
      return this.calendar.get(this.selectedDayISO);
    },
  },
  watch: {
    selectedSlot(slotTime) {
      this.$emit("slotSelected", { dayISO: this.selectedDayISO, slotTime });
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
