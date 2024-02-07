<script setup>
import { ref } from "@vue/reactivity";
import { computed, onMounted, watch } from "@vue/runtime-core";
import { storeToRefs } from "pinia";
import { useInsightStore } from "../../../stores/bright/index";
import { useCategoryStore } from "../../../stores/filter/category";
import { Chart, DatePicker, Select } from "../../../components/index";
import { TypeOption } from "../../../components/chart/options";
import LayeredCard from "../../../components/LayeredCard.vue";
import moment from "moment";

const categoryStore = useCategoryStore();
const categoryRef = storeToRefs(categoryStore);
const { fetchFilter } = categoryStore;

const insightStore = useInsightStore();
const insightRef = storeToRefs(insightStore);
const { fetchInsight, fetchMultipleInsight } = insightStore;

const disabledField = ref(false);
const selectedWitel = ref(null);
const selectedHero = ref(null);
const selectedYear = ref(new Date());
const selectedType = ref(null);

const defType = {
  label: "Last Year vs Year",
  key: "ly_vs_y",
};

const types = [
  {
    label: "Last Year vs Year",
    key: "ly_vs_y",
  },
  {
    label: "Target vs Real",
    key: "tgt_vs_real",
  },
];

onMounted(async () => {
  if (insightRef.charts.value.length < 1) {
    await fetchFilter();
    if (!categoryRef.loading.value) {
      selectedWitel.value = categoryRef.selectedWitel.value;
      selectedHero.value = categoryRef.selectedHero.value;
      selectedType.value = defType;

      renderChart();
    }
  }

  selectedWitel.value = categoryRef.selectedWitel.value;
  selectedHero.value = categoryRef.selectedHero.value;
  selectedType.value = defType;
});

watch(selectedWitel, async (value, before) => {
  if (before != null) {
    await fetchFilter({
      witel: value,
    });
    selectedHero.value = null;

    disabledField.value = categoryRef.loading.value;
  }
});

async function renderChart() {
  categoryRef.selectedWitel.value = selectedWitel.value;
  categoryRef.selectedHero.value = selectedHero.value;

  if (selectedType.value.key == "ly_vs_y") {
    await fetchMultipleInsight({
      hero: selectedHero.value,
      year: selectedYear.value.getFullYear(),
      type: selectedType.value.key,
    });
  } else {
    await fetchInsight({
      hero: selectedHero.value,
      year: selectedYear.value.getFullYear(),
      type: selectedType.value.key,
    });
  }
}

const yAxisOptions = {
  labels: {
    style: {
      colors: "#8e8da4",
    },
    offsetX: 0,
  },
};

const revenueYaxisOpt = {
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
              <label>Year</label>
              <DatePicker view="year" v-model="selectedYear" />
            </div>
            <div class="form-group mr-3">
              <label>Witel</label>
              <Select
                width="190"
                :disabled="categoryRef.loading.value"
                :options="categoryRef.witels.value"
                v-model="selectedWitel"
              />
            </div>
            <div class="form-group mr-3">
              <label>Hero</label>
              <Select
                width="240"
                :disabled="categoryRef.loading.value"
                :options="categoryRef.heroes.value"
                v-model="selectedHero"
              />
            </div>
            <div class="form-group mr-3">
              <label>Type</label>
              <Select
                width="190"
                :disabled="categoryRef.loading.value"
                :options="types"
                v-model="selectedType"
              />
            </div>
            <div class="form-group">
              <button
                class="btn btn-primary"
                type="button"
                style="height: 35px"
                :disabled="
                  insightRef.loading.value || categoryRef.loading.value
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
      v-for="chart in insightRef.charts.value"
      :key="chart.type"
    >
      <LayeredCard :loading="insightRef.loading.value" :height="300">
        <div class="card" v-if="!insightRef.loading.value">
          <div class="card-body">
            <Chart
              :type="TypeOption[chart.chart_type]"
              :title="chart.title"
              :labels="chart.labels"
              :series="chart.series"
              :yaxis="chart.type === 'revenue' ? revenueYaxisOpt : yAxisOptions"
              :xaxisFormat="xaxisFormat"
            />
          </div>
        </div>
      </LayeredCard>
    </div>
  </div>
</template>
