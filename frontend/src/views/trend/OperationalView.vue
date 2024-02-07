<script setup>
import { ref } from "@vue/reactivity";
import { onBeforeMount, onMounted, watch } from "@vue/runtime-core";
import { storeToRefs } from "pinia";
import { useTrendStore } from "../../stores/trend/index";
import { useCategoryStore } from "../../stores/filter/category";
import { Chart, DatePicker, Select } from "../../components/index";
import { TypeOption } from "../../components/chart/options";
import moment from "moment";
import LayeredCard from "../../components/LayeredCard.vue";
import { isEmpty } from "../../helpers/function";

const categoryStore = useCategoryStore();
const categoryRef = storeToRefs(categoryStore);
const { fetchFilter } = categoryStore;

const trendStore = useTrendStore();
const trendRef = storeToRefs(trendStore);
const { fetchOperationalCategory, fetchOperationalTrend } = trendStore;

const firstLoading = ref(false);

const selectedConsumerType = ref("");
const selectedBgesType = ref("");
const selectedRwsType = ref("");
const selectedDivre = ref(null);
const selectedUnit = ref(null);
const selectedPeriode = ref(new Date());

onMounted(async () => {
  if (trendRef.opera_categories.value == null) {
    await fetchOperationalCategory();
    if (!trendRef.opera_cat_loading.value) {
      selectedConsumerType.value = trendRef.opera_categories.value.consumer[0];
      selectedBgesType.value = trendRef.opera_categories.value.bges[0];
      selectedRwsType.value = trendRef.opera_categories.value.rws[0];
    }
  }

  selectedConsumerType.value = trendRef.opera_categories.value.consumer[0];
  selectedBgesType.value = trendRef.opera_categories.value.bges[0];
  selectedRwsType.value = trendRef.opera_categories.value.rws[0];

  if (trendRef.operationals.value.consumer.length < 3) {
    if (categoryRef.witels.value.length < 1) {
      await fetchFilter();
    }

    if (!categoryRef.loading.value && trendRef.opera_categories != null) {
      selectedUnit.value = categoryRef.selectedWitel.value;
      selectedDivre.value = categoryRef.selectedDivre.value;

      firstRenderChart();
    }
  }

  selectedUnit.value = categoryRef.selectedWitel.value;
  selectedDivre.value = categoryRef.selectedDivre.value;
});

watch(selectedDivre, async (value, before) => {
  if (before != null) {
    await fetchFilter({
      divre: value,
    });
    selectedUnit.value = "ALL";

    disabledField.value = categoryRef.loading.value;
  }
});

watch(selectedConsumerType, async (newValue, oldValue) => {
  if (oldValue != "") {
    await fetchOperationalTrend({
      category: "consumer",
      type: selectedConsumerType.value,
      unit: selectedUnit.value,
      divre: selectedDivre.value,
      periode: selectedPeriode.value.getFullYear(),
    });
  }
});

watch(selectedBgesType, async (newValue, oldValue) => {
  if (oldValue != "") {
    await fetchOperationalTrend({
      category: "bges",
      type: selectedBgesType.value,
      unit: selectedUnit.value,
      divre: selectedDivre.value,
      periode: selectedPeriode.value.getFullYear(),
    });
  }
});

watch(selectedRwsType, async (newValue, oldValue) => {
  if (oldValue != "") {
    await fetchOperationalTrend({
      category: "rws",
      type: selectedRwsType.value,
      unit: selectedUnit.value,
      divre: selectedDivre.value,
      periode: selectedPeriode.value.getFullYear(),
    });
  }
});

async function firstRenderChart() {
  firstLoading.value = true;
  categoryRef.selectedWitel.value = selectedUnit.value;

  await fetchOperationalTrend({
    category: "consumer",
    type: selectedConsumerType.value,
    unit: selectedUnit.value,
    divre: selectedDivre.value,
    periode: selectedPeriode.value.getFullYear(),
  });
  await fetchOperationalTrend({
    category: "bges",
    type: selectedBgesType.value,
    unit: selectedUnit.value,
    divre: selectedDivre.value,
    periode: selectedPeriode.value.getFullYear(),
  });
  await fetchOperationalTrend({
    category: "rws",
    type: selectedRwsType.value,
    unit: selectedUnit.value,
    divre: selectedDivre.value,
    periode: selectedPeriode.value.getFullYear(),
  });

  setTimeout(() => (firstLoading.value = false), 1500);
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
              <label>Divre</label>
              <Select
                width="190"
                :disabled="categoryRef.loading.value"
                :options="categoryRef.divre.value"
                v-model="selectedDivre"
              />
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
                :disabled="firstLoading.value || categoryRef.loading.value"
                @click="firstRenderChart"
              >
                FILTER
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-md-12 mb-3">
      <LayeredCard
        :loading="
          trendRef.opera_loading.value.consumer ||
          trendRef.operationals.value.consumer.chart_type == undefined
        "
        :height="490"
      >
        <div class="card">
          <div class="card-body">
            <div
              class="form-group mr-3"
              v-if="
                !trendRef.opera_loading.value.consumer &&
                trendRef.operationals.value.consumer.chart_type != undefined
              "
            >
              <Select
                class="mb-3"
                width="190"
                :disabled="trendRef.opera_loading.value.consumer"
                :options="trendRef.opera_categories.value.consumer"
                v-model="selectedConsumerType"
              />
              <Chart
                class="bordered"
                :loading="!trendRef.opera_loading.value.consumer"
                :type="
                  TypeOption[trendRef.operationals.value.consumer.chart_type]
                "
                :title="trendRef.operationals.value.consumer.title"
                :labels="trendRef.operationals.value.consumer.labels"
                :series="trendRef.operationals.value.consumer.series"
              />
            </div>
          </div>
        </div>
      </LayeredCard>
    </div>
    <div class="col-sm-12 col-md-12 mb-3">
      <LayeredCard
        :loading="
          trendRef.opera_loading.value.bges ||
          trendRef.operationals.value.bges.chart_type == undefined
        "
        :height="490"
      >
        <div class="card">
          <div class="card-body">
            <div
              class="form-group mr-3"
              v-if="
                !trendRef.opera_loading.value.bges &&
                trendRef.operationals.value.bges.chart_type != undefined
              "
            >
              <Select
                width="190"
                :disabled="trendRef.opera_loading.value.bges"
                :options="trendRef.opera_categories.value.bges"
                v-model="selectedBgesType"
              />
            </div>
            <Chart
              class="bordered"
              :loading="!trendRef.opera_loading.value.bges"
              :type="TypeOption[trendRef.operationals.value.bges.chart_type]"
              :title="trendRef.operationals.value.bges.title"
              :labels="trendRef.operationals.value.bges.labels"
              :series="trendRef.operationals.value.bges.series"
            />
          </div>
        </div>
      </LayeredCard>
    </div>
    <div class="col-sm-12 col-md-12 mb-3">
      <LayeredCard
        :loading="
          trendRef.opera_loading.value.rws ||
          trendRef.operationals.value.rws.chart_type == undefined
        "
        :height="490"
      >
        <div class="card">
          <div class="card-body">
            <div
              class="form-group mr-3"
              v-if="
                !trendRef.opera_loading.value.rws &&
                trendRef.operationals.value.rws.chart_type != undefined
              "
            >
              <Select
                width="190"
                :disabled="trendRef.opera_loading.value.rws"
                :options="trendRef.opera_categories.value.rws"
                v-model="selectedRwsType"
              />
            </div>
            <Chart
              class="bordered"
              :loading="!trendRef.opera_loading.value.rws"
              :type="TypeOption[trendRef.operationals.value.rws.chart_type]"
              :title="trendRef.operationals.value.rws.title"
              :labels="trendRef.operationals.value.rws.labels"
              :series="trendRef.operationals.value.rws.series"
            />
          </div>
        </div>
      </LayeredCard>
    </div>
  </div>
</template>

<style scoped>
.bordered {
  border: 2px solid #e8ebf1 !important;
  border-radius: 8px;
  padding-top: 20px;
  padding-left: 16px;
  padding-right: 16px;
}
</style>
