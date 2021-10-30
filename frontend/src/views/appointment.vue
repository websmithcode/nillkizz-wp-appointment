<template lang="pug">
h1.title Запись на прием к врачу
.container(v-if="doctor")
  .doctor 
    .info
      .photo(:style="{ backgroundImage: `url(${doctor.photo.url})` }") 
      .text 
        span Вы записываетесь на прием к:
        .name {{ doctor.name }}
    .specialty
      .title Специальность
      .choices
        label(v-for="(spec, index) in doctor?.spec")
          input(
            v-model="specialty",
            type="radio",
            :value="spec.id",
            name="specialty"
          )
          |
          | {{ spec.name }}
    calendar(:calendar="doctor.calendar", v-model="selectedSlot")
  form.form
    .fields
      n-input(v-model="firstName", name="Имя")
      n-input(v-model="lastName", name="Фамилия")
      n-input(v-model="birthday", name="Дата рождения")
      n-input(v-model="phoneNumber", name="Номер телефона")
    button.submit {{ phoneIsConfirmed ? 'Записаться' : 'Проверить номер' }}
</template>

<script>
import { mapGetters } from "vuex";
import { nInput } from "@/components/ui";

import calendar from "@/components/doctors-list/calendar.vue";

export default {
  components: { calendar, nInput },

  data() {
    return {
      selectedSlot: {
        dayISO: this.$route.params.dayISO,
        slotTime: this.$route.params.slotTime,
      },
      specialty: "",
      firstName: "",
      lastName: "",
      birthday: "",
      phoneNumber: "",
      phoneIsConfirmed: false,
    };
  },
  mounted() {
    if (this.doctor) this.specialty = this.doctor.specialty[0].id;
  },
  methods: {},
  computed: {
    ...mapGetters(["mapDoctors"]),
    doctor() {
      const docId = parseInt(this.$route.params.doctorId);
      if (!this.mapDoctors.has(docId)) return;
      return this.mapDoctors.get(docId);
    },
    formData() {
      if (!this.phoneIsConfirmed) return;
      return new FormData();
    },
  },
  watch: {
    doctor(newVal) {
      this.specialty = newVal?.specialty[0].id;
    },
  },
};
</script>

<style lang="sass" scoped>
h1.title
  @apply text-2xl font-semibold mb-8
.container
  @apply border p-3 bg-gray-50 flex gap-5
  .doctor
    @apply flex flex-col gap-8
    .info
      @apply flex gap-4
      .photo
        @apply w-16 h-16 bg-center bg-cover
      .text
        @apply flex flex-col justify-around
        .name
          @apply text-2xl text-blue-500
    .specialty
      .title
        @apply mb-2
      .choices
        @apply flex gap-3

  .form
    @apply flex flex-col gap-3
    .fields
      @apply flex flex-wrap gap-3
    .submit
      @apply bg-gray-500 text-white px-4 py-2
</style>
