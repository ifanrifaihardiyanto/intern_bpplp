<script setup>
import { defineProps, watch } from "vue";
import Loading from "./Loading.vue";

const props = defineProps({
  loading: {
    default: true,
  },
  height: {
    type: Number,
    default: 100,
  },
});
</script>

<template>
  <div
    class="layered-card"
    :style="{ height: loading ? `${height}px` : '100%' }"
  >
    <Transition name="slide-fade">
      <div v-if="loading" class="layered-card__content">
        <Loading />
      </div>
      <div v-else>
        <slot></slot>
      </div>
    </Transition>
  </div>
</template>
