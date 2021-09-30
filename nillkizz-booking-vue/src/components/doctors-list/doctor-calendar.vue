<template lang="pug">
.calendar
  .active(v-if="true") Active
    .days days
    .slots
  .empty(v-else) Empty
.full-calendar
</template>

<script>
export default {
  props: {
    doctor: Object,
    timeslots: Array,
  },
  methods: {},
  computed: {},
};
</script>

<style lang="sass" scoped>
</style>
