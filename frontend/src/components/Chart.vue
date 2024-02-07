<script setup>
import { ref } from "@vue/reactivity";
import VueApexCharts from "vue3-apexcharts";
import { getOption } from "./chart/options";
import { isEmpty } from "../helpers/function";
import Loading from "./Loading.vue";

const props = defineProps({
  loading: {
    default: false,
  },
  type: {
    required: false,
  },
  title: {
    type: String,
    required: false,
  },
  labels: {
    type: Array,
    required: false,
  },
  series: {
    type: Array,
    required: false,
  },
  xaxis: {
    type: Object,
    required: false,
  },
  xaxisFormat: {
    type: Object,
    required: false,
  },
  yaxis: {
    type: Object,
    required: false,
  },
  yaxisFormat: {
    type: Object,
    required: false,
  },
  height: {
    type: Number,
    default: "350",
  },
});

const chartOptions = getOption(props.type, props);
</script>

<template>
  <VueApexCharts
    :height="height"
    :type="type"
    :options="chartOptions"
    :series="series"
  />
</template>
