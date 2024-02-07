<script setup>
import { ref } from "@vue/reactivity";
import { onMounted } from "@vue/runtime-core";
import { storeToRefs } from "pinia";
import { useTrendStore } from "../../stores/trend/index";
import { useCategoryStore } from "../../stores/filter/category";
import { Chart, DatePicker, Select } from "../../components/index";
import { TypeOption } from "../../components/chart/options";
import moment from "moment";
import LayeredCard from "../../components/LayeredCard.vue";

const categoryStore = useCategoryStore();
const categoryRef = storeToRefs(categoryStore);
const { fetchFilter } = categoryStore;

const trendStore = useTrendStore();
const trendRef = storeToRefs(trendStore);
const { fetchFinancialTrend } = trendStore;

const selectedUnit = ref(null);
const selectedPeriode = ref(new Date());

onMounted(async () => {
  if (trendRef.financials.value.length < 1) {
    await fetchFilter();
    if (!categoryRef.loading.value) {
      selectedUnit.value = categoryRef.selectedWitel.value;

      renderChart();
    }
  }

  selectedUnit.value = categoryRef.selectedWitel.value;
});

async function renderChart() {
  categoryRef.selectedWitel.value = selectedUnit.value;

  await fetchFinancialTrend({
    unit: selectedUnit.value,
    periode: selectedPeriode.value.getFullYear(),
  });
}

const yAxisOptions = {
  labels: {
    style: {
      colors: "#8e8da4",
    },
    offsetX: 0,
    formatter: function (val) {
      let format = (val / 1000000000).toFixed(2);
      return `Rp ${format} M`;
    },
  },
};

const xaxisFormat = {
  formatter: (value) => {
    return moment(`${value}01`).format("MMM");
  },
};
</script>

<template>
  <div class="row">
    <div class="col-12 mb-3">
      <div class="card">
        <div class="card-body">
          <div class="form-row align-items-end">
            <div class="form-group mr-3">
              <label>Periode</label>
              <DatePicker view="year" v-model="selectedPeriode" />
            </div>
            <div class="form-group mr-3">
              <label>Witel</label>
              <Select
                width="190"
                :disabled="categoryRef.loading.value"
                :options="categoryRef.witels.value"
                v-model="selectedUnit"
              />
            </div>
            <div class="form-group">
              <button
                class="btn btn-primary"
                type="button"
                style="height: 35px"
                :disabled="
                  trendRef.financial_loading.value || categoryRef.loading.value
                "
                @click="renderChart"
              >
                FILTER
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div
      class="col-sm-12 col-md-6 mb-3"
      v-for="chart in trendRef.financials.value"
      :key="chart.type"
    >
      <LayeredCard :loading="trendRef.financial_loading.value" :height="415">
        <div class="card" v-if="!trendRef.financial_loading.value">
          <div class="card-body">
            <Chart
              :type="TypeOption[chart.chart_type]"
              :title="chart.title"
              :labels="chart.labels"
              :series="chart.series"
              :xaxisFormat="xaxisFormat"
              :yaxis="yAxisOptions"
            />
          </div>
        </div>
      </LayeredCard>
    </div>
  </div>
</template>
