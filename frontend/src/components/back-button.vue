<template lang="pug">
q-btn(color="primary", unelevated, @click="$router.go(-1)")
  q-icon(name="arrow_back_ios_new", color="white")
  q-tooltip(anchor="center right", self="center left") Назад
</template>
<style lang="sass" scoped>
.q-btn
  @apply rounded-none absolute top-0 left-0
</style>