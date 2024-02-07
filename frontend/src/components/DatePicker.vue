<script setup>
import { computed } from "@vue/reactivity";
import Datepicker from "vue3-datepicker";

const props = defineProps(["modelValue", "view"]);
const emit = defineEmits(["update:modelValue"]);

let inputFormat = "yyyy-MM-dd";
if (props.view === "month") {
  inputFormat = "yyyy-MM";
} else if (props.view === "year") {
  inputFormat = "yyyy";
}

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
  <datepicker
    class="form-control"
    :inputFormat="inputFormat"
    :startingView="props.view"
    :minimumView="props.view"
    v-model="value"
  />
</template>
