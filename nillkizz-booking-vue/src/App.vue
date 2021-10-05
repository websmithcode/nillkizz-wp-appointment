<template lang="pug">
router-view
debug-area
</template>

<script>
import debugArea from "@/components/debug-area";
export default {
  components: {
    debugArea,
  },
};
</script>
<style lang="sass">
body
  @apply text-gray-800
</style>
