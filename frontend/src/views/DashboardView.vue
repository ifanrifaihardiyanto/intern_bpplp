<script setup>
import { ref } from "@vue/reactivity";
import { onMounted, watch } from "@vue/runtime-core";
import { storeToRefs } from "pinia";
import { useCategoryStore } from "../stores/filter/category";
import { useAnalyticStore } from "../stores/analytic/analytic";
import { Chart, DatePicker, Select } from "../components/index";
import AnalyticCard from "../components/AnalyticCard.vue";
import AnalyticCardSimp from "../components/AnalyticCardSimp.vue";
import moment from "moment";
import LayeredCard from "../components/LayeredCard.vue";

const categoryStore = useCategoryStore();
const categoryRef = storeToRefs(categoryStore);
const { fetchFilter } = categoryStore;

const analyticStore = useAnalyticStore();
const analyticRef = storeToRefs(analyticStore);
const { fetchFinancialAnalytic, fetchOperationalAnalytic } = analyticStore;

const selectedDivre = ref(null);
const selectedWitel = ref(null);
const selectedPeriode = ref(new Date());

onMounted(async () => {
  if (categoryRef.witels.value.length < 1) {
    await fetchFilter();
    if (!categoryRef.loading.value) {
      selectedWitel.value = categoryRef.selectedWitel.value;
      selectedDivre.value = categoryRef.selectedDivre.value;

      await renderAnalytic();
    }
  }

  selectedWitel.value = categoryRef.selectedWitel.value;
  selectedDivre.value = categoryRef.selectedDivre.value;
  if (
    analyticRef.financials.value.length < 1 ||
    analyticRef.operationals.value.length < 1
  ) {
    await renderAnalytic();
  }
});

watch(selectedDivre, async (value, before) => {
  if (before != null) {
    await fetchFilter({
      divre: value,
    });
    selectedWitel.value = "ALL";

    disabledField.value = categoryRef.loading.value;
  }
});

const renderAnalytic = async () => {
  await fetchFinancialAnalytic({
    unit: selectedWitel.value,
    divre: selectedDivre.value,
    periode: moment(selectedPeriode.value).format("yyyyMM"),
  });

  await fetchOperationalAnalytic({
    unit: selectedWitel.value,
    divre: selectedDivre.value,
    periode: moment(selectedPeriode.value).format("yyyyMM"),
  });
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
              <DatePicker view="month" v-model="selectedPeriode" />
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
                v-model="selectedWitel"
              />
            </div>
            <div class="form-group">
              <button
                class="btn btn-primary"
                type="button"
                style="height: 35px"
                :disabled="categoryRef.loading.value"
                @click="renderAnalytic()"
              >
                FILTER
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div
      class="col-sm-12 col-md-3"
      v-for="(data, index) in analyticRef.financials.value"
      :key="index"
    >
      <LayeredCard :loading="analyticRef.financial_loading.value" height="290">
        <div v-if="!analyticRef.financial_loading.value">
          <AnalyticCard :data="data" />
        </div>
      </LayeredCard>
    </div>
    <div class="col mt-3">
      <table width="100%">
        <tbody>
          <tr>
            <td
              v-for="(data, index) in analyticRef.operationals.value.slice(
                0,
                5
              )"
              :key="index"
            >
              <LayeredCard
                :loading="analyticRef.operational_loading.value"
                height="190"
              >
                <div v-if="!analyticRef.operational_loading.value">
                  <AnalyticCardSimp :data="data" />
                </div>
              </LayeredCard>
            </td>
          </tr>
          <tr>
            <td
              v-for="(data, index) in analyticRef.operationals.value.slice(
                5,
                10
              )"
              :key="index"
            >
              <LayeredCard
                :loading="analyticRef.operational_loading.value"
                height="190"
              >
                <div v-if="!analyticRef.operational_loading.value">
                  <AnalyticCardSimp :data="data" />
                </div>
              </LayeredCard>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
