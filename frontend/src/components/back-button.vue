<template lang="pug">
q-btn(
  color="primary",
  unelevated,
  @click="$router.go(-1)",
  icon="arrow_back_ios_new"
)
  q-tooltip(anchor="center right", self="center left") Назад
</template>
<style lang="sass" scoped>
.q-btn
  @apply rounded-none absolute top-0 left-0
</style>