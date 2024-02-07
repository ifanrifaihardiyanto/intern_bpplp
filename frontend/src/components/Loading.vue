<script setup>
import { defineProps } from "vue";

defineProps({
  type: {
    type: String,
    default: "facebook",
  },
});
</script>

<template>
  <div>
    <div class="lds-facebook" v-if="type == 'facebook'">
      <div></div>
      <div></div>
      <div></div>
    </div>
    <div class="lds-ellipsis" v-if="type == 'ellipsis'">
      <div></div>
      <div></div>
      <div></div>
      <div></div>
    </div>
  </div>
</template>

<style scoped>
.lds-facebook {
  display: inline-block;
  position: relative;
  width: 80px;
  height: 80px;
}
.lds-facebook div {
  display: inline-block;
  position: absolute;
  left: 8px;
  width: 16px;
  background: -moz-linear-gradient(
    90deg,
    rgba(118, 29, 253, 1) 46%,
    rgba(69, 141, 252, 1) 100%
  );
  background: -webkit-linear-gradient(
    90deg,
    rgba(118, 29, 253, 1) 46%,
    rgba(69, 141, 252, 1) 100%
  );
  background: linear-gradient(
    90deg,
    rgba(118, 29, 253, 1) 46%,
    rgba(69, 141, 252, 1) 100%
  );
  animation: lds-facebook 1.2s cubic-bezier(0, 0.5, 0.5, 1) infinite;
}
.lds-facebook div:nth-child(1) {
  left: 8px;
  animation-delay: -0.24s;
}
.lds-facebook div:nth-child(2) {
  left: 32px;
  animation-delay: -0.12s;
}
.lds-facebook div:nth-child(3) {
  left: 56px;
  animation-delay: 0;
}
@keyframes lds-facebook {
  0% {
    top: 8px;
    height: 64px;
  }
  50%,
  100% {
    top: 24px;
    height: 32px;
  }
}

/* Ellipsis Loading Style */
.lds-ellipsis {
  display: inline-block;
  position: relative;
  width: 80px;
  height: 80px;
}
.lds-ellipsis div {
  position: absolute;
  top: 33px;
  width: 13px;
  height: 13px;
  border-radius: 50%;
  background: -moz-linear-gradient(
    90deg,
    rgba(118, 29, 253, 1) 46%,
    rgba(69, 141, 252, 1) 100%
  );
  background: -webkit-linear-gradient(
    90deg,
    rgba(118, 29, 253, 1) 46%,
    rgba(69, 141, 252, 1) 100%
  );
  background: linear-gradient(
    90deg,
    rgba(118, 29, 253, 1) 46%,
    rgba(69, 141, 252, 1) 100%
  );
  animation-timing-function: cubic-bezier(0, 1, 1, 0);
}
.lds-ellipsis div:nth-child(1) {
  left: 8px;
  animation: lds-ellipsis1 0.6s infinite;
}
.lds-ellipsis div:nth-child(2) {
  left: 8px;
  animation: lds-ellipsis2 0.6s infinite;
}
.lds-ellipsis div:nth-child(3) {
  left: 32px;
  animation: lds-ellipsis2 0.6s infinite;
}
.lds-ellipsis div:nth-child(4) {
  left: 56px;
  animation: lds-ellipsis3 0.6s infinite;
}
@keyframes lds-ellipsis1 {
  0% {
    transform: scale(0);
  }
  100% {
    transform: scale(1);
  }
}
@keyframes lds-ellipsis3 {
  0% {
    transform: scale(1);
  }
  100% {
    transform: scale(0);
  }
}
@keyframes lds-ellipsis2 {
  0% {
    transform: translate(0, 0);
  }
  100% {
    transform: translate(24px, 0);
  }
}
</style>
