<template lang="pug">
.slots 
  .slot(v-for="(slot, index) in slots", :key="index") {{ slot.time }}
</template>

<script>
export default {
  props: {
    slots: Object,
  },
  data() {
    return {};
  },
};
</script>

<style lang="sass" scoped>
.slots
  @apply border border-gray-400 p-3 grid grid-cols-5 gap-2
  .slot
    @apply bg-gray-500 text-white px-2 py-1 text-center cursor-pointer select-none
</style>
