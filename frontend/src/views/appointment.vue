<template lang="pug">
header 
  back-button
  h1.title Запись на прием к врачу
.container(v-if="doctor")
  .doctor 
    .info
      q-avatar(square, size="80px")
        img(:src="doctor.photo.sizes.thumbnail")
      .text 
        .name {{ doctor.name }}
    .specialty
      .title.q-my-auto Специальность:
      .choices
        label(v-for="(spec, index) in doctor?.specialty")
          q-radio(
            v-model="inputs.specialty.value",
            :val="spec",
            :label="spec.val",
            color="cyan"
          )
    calendar(:calendar="doctor.calendar", v-model="selectedSlot")
  q-form.form(@submit="onSubmit")
    .inputs
      q-input(
        ref="firstNameRef",
        square,
        outlined,
        dense,
        bg-color="white",
        v-model="inputs.firstName.value",
        :rules="[(val) => !!val]",
        label="Имя"
      )
      q-input(
        ref="lastNameRef",
        square,
        outlined,
        dense,
        bg-color="white",
        v-model="inputs.lastName.value",
        :rules="[(val) => !!val]",
        label="Фамилия"
      )
      q-input(
        ref="birthdayRef",
        square,
        outlined,
        dense,
        bg-color="white",
        mask="##.##.####",
        fill-mask,
        v-model="inputs.birthday.value",
        :rules="[birthdayValidate || 'Не правильно введена дата']",
        hint="Дата рождения дд.мм.гггг"
      )
      q-input(
        ref="phoneNumberRef",
        square,
        outlined,
        dense,
        mask="7 (###) ### ##-##",
        fill-mask,
        :rules="[phoneValidate]",
        bg-color="white",
        v-model="inputs.phoneNumber.value",
        hint="Номер телефона",
        :loading="inputs.phoneNumber.loading",
        :error="inputs.phoneNumber.error",
        :error-message="inputs.phoneNumber.errorMessage",
        :disable="inputs.phoneNumber.disable"
      )
      q-slide-transition 
        div(v-show="call.codeIsRequested")
          q-input(
            ref="codeRef",
            square,
            outlined,
            dense,
            :bg-color="inputs.code.bgColor",
            v-model="inputs.code.value",
            hint="Код подтверждения",
            :loading="inputs.code.loading",
            :error="inputs.code.error",
            :error-message="inputs.code.errorMessage",
            :disable="inputs.code.disable"
          )
            template(v-slot="after", v-if="call.lostTime > 0") 
              .q-my-auto {{ codeLostText }}
    button.submit {{ call.phoneIsConfirmed ? 'Записаться' : call.codeIsRequested ? 'Подтвердить номер' : 'Запросить код подтвержения' }}
q-dialog.thanks-banner(
  v-model="requestIsSent",
  maximized,
  transition-show="fade"
)
  q-card.text-center.flex.flex-col.justify-center.relative
    back-button
    .text-h5 Спасибо, ваша заявка принята.
    .text-h6 В ближайшее время мы с вами свяжемся!
</template>

<script>
import { mapGetters } from "vuex";

import api from "@/api";
import calendar from "@/components/doctors-list/calendar.vue";
import backButton from "@/components/back-button.vue";
import { DateTime } from "luxon";

export default {
  components: { calendar, backButton },

  data() {
    return {
      requestIsSent: false,
      selectedSlot: {
        dayISO: this.$route.params.dayISO,
        slotTime: this.$route.params.slotTime,
      },
      call: {
        id: null,
        codeIsRequested: false,
        phoneIsConfirmed: false,
        lostTime: 0,
        timerInterval: null,
      },
      inputs: {
        specialty: { value: null },
        firstName: { value: "" },
        lastName: { value: "" },
        birthday: { value: "" },
        phoneNumber: {
          value: "",
          loading: false,
          disable: false,
          error: false,
          errorMessage: "",
        },
        code: {
          value: "",
          loading: false,
          disable: false,
          error: false,
          errorMessage: "",
          bgColor: "white",
        },
      },
    };
  },
  mounted() {
    if (this.doctor) this.inputs.specialty.value = this.doctor.specialty[0];
  },
  methods: {
    phoneValidate(value) {
      return /^7 \(\d{3}\) \d{3} \d{2}-\d{2}$/.test(value);
    },
    birthdayValidate(value) {
      function getDateTime(strDate) {
        return DateTime.fromFormat(strDate ?? "", "dd.MM.yyyy", {
          locale: "ru",
        });
      }
      return getDateTime(value).isValid;
    },
    onSubmit() {
      if (!this.call.phoneIsConfirmed && !this.call.codeIsRequested) {
        this.inputs.phoneNumber.loading = true;
        this.inputs.phoneNumber.disable = true;
        this.inputs.phoneNumber.error = false;
        this.call.id = null;
        api
          .requestCall(this.computedValues.phoneNumber)
          .then((res) => {
            const data = res.data;
            if (data.status == "success") {
              this.$nextTick(() => (this.inputs.phoneNumber.loading = false));
              this.call.codeIsRequested = true;
              this.call.lostTime = data.code_validity_time;
              this.call.id = data["callId"];

              this.timerInterval = setInterval(() => {
                this.call.lostTime--;
                if (this.call.lostTime < 1) {
                  clearInterval(this.timerInterval);
                  this.call.codeIsRequested = false;
                  this.call.lostTime = 0;
                  this.inputs.phoneNumber.disable = false;
                  this.inputs.code.error = false;
                  this.inputs.code.value = "";
                }
              }, 1000);
            }
          })
          .catch(() => {
            this.inputs.phoneNumber.loading = false;
            this.inputs.phoneNumber.disable = false;
            this.inputs.phoneNumber.error = true;
            this.inputs.phoneNumber.errorMessage =
              "Проверьте правильность ввода";
          });
      } else if (!this.call.phoneIsConfirmed && this.call.codeIsRequested) {
        this.inputs.code.loading = true;
        this.inputs.code.disable = true;
        api
          .checkCode(this.inputs.code.value, this.call.id)
          .then(() => {
            this.$nextTick(() => {
              this.inputs.code.loading = false;
              this.inputs.code.bgColor = "green";
              this.requestIsSent = true;
              clearInterval(this.timerInterval);
              this.call.lostTime = 0;
            });
          })
          .catch(() => {
            this.inputs.code.loading = false;
            this.inputs.code.disable = false;
            this.inputs.code.error = true;
            this.inputs.code.errorMessage = "Проверьте правильность ввода";
          });
      }
    },
  },
  computed: {
    ...mapGetters(["mapDoctors"]),
    doctor() {
      const docId = parseInt(this.$route.params.doctorId);
      if (!this.mapDoctors.has(docId)) return;
      return this.mapDoctors.get(docId);
    },
    computedValues() {
      return {
        specialty: this.inputs.specialty.value?.val,
        firstName: this.inputs.firstName.value,
        lastName: this.inputs.lastName.value,
        birthday: this.inputs.birthday.value,
        phoneNumber: this.inputs.phoneNumber.value.replace(/\D+/g, ""),
      };
    },
    codeLostText() {
      const min = String(Math.floor(this.call.lostTime / 60)).padStart(2, 0);
      const sec = String(this.call.lostTime % 60).padStart(2, 0);
      return `${min}:${sec}`;
    },
  },
  watch: {
    doctor(newVal) {
      this.inputs.specialty.value = newVal?.specialty[0];
    },
  },
};
</script>

<style lang="sass" scoped>
header
  @apply relative mb-8
  h1.title
    @apply text-2xl font-semibold text-center pt-2
.container
  @apply border p-3 bg-gray-50 flex gap-5 mx-auto
  .doctor
    @apply flex flex-col gap-8
    .info
      @apply flex gap-4
      .text
        @apply flex flex-col justify-center
        .name
          @apply text-2xl text-blue-500
    .specialty
      @apply flex flex-wrap
      .title
        @apply mb-2 mr-4
      .choices
        @apply flex gap-3

  .form
    @apply w-full flex flex-col justify-between
    .inputs
      @apply mb-2
      .q-input
        @apply mb-1
    .submit
      @apply bg-gray-500 text-white px-4 py-2
</style>
