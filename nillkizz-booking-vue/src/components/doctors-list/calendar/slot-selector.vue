<template lang="pug">
.slots
  .slot(
    v-for="slot in selectedDay.values()",
    :class="{ selected: slot.time == this.value }",
    @click="selectSlot(slot)"
  ) {{ slot.time }}
</template>

<script>
export default {
  props: {
    selectedDay: Map,
    modelValue: String,
  },
  emits: ["update:modelValue"],
  data() {
    return {
      value: this.modelValue,
    };
  },
  methods: {
    selectSlot(slot) {
      this.value = slot.time;
      this.$emit("update:modelValue", this.value);
    },
  },
  computed: {
    slots() {
      return this.calendar.get(this.selectedDay);
    },
  },
};
</script>

<style lang="sass" scoped>
.slots
  @apply border border-gray-400 p-3
  @apply grid grid-cols-5 gap-2
  .slot
    @apply bg-gray-500 hover:bg-gray-600 text-white px-2 py-1 text-center cursor-pointer select-none ring-blue-500 ring-0 duration-200
    &.selected
      @apply ring-2
</style>
