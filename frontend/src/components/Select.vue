<script setup>
import { computed } from "@vue/runtime-core";
import vSelect from "vue-select";

const props = defineProps([
  "modelValue",
  "label",
  "key",
  "reduce",
  "options",
  "width",
  "disabled",
]);
const emit = defineEmits(["update:modelValue"]);

const value = computed({
  get() {
    return props.modelValue;
  },
  set(value) {
    emit("update:modelValue", value);
  },
});
</script>

<template>
  <div :style="{ width: `${props.width}px` }">
    <vSelect
      :reduce="props.reduce"
      :options="props.options"
      :clearable="false"
      :disabled="props.disabled ?? false"
      v-model="value"
    />
  </div>
</template>
