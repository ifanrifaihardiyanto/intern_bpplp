<script setup>
import { ref } from "@vue/reactivity";
import { onBeforeMount, onMounted, watch } from "@vue/runtime-core";
import { storeToRefs } from "pinia";
import { useHeroAnalyticStore } from "../../../stores/bright/index";
import { useCategoryStore } from "../../../stores/filter/category";
import { DatePicker, Select } from "../../../components/index";
import LayeredCard from "../../../components/LayeredCard.vue";
import Loading from "../../../components/Loading.vue";
import VueApexCharts from "vue3-apexcharts";
import Chart from "../../../components/Chart.vue";
import { TypeOption } from "../../../components/chart/options";
import moment from "moment";

const categoryStore = useCategoryStore();
const categoryRef = storeToRefs(categoryStore);
const { fetchFilter } = categoryStore;

const heroAnalyticStore = useHeroAnalyticStore();
const heroAnalyticRef = storeToRefs(heroAnalyticStore);
const { fetchAnalytic } = heroAnalyticStore;

const selectedDivre = ref(null);
const selectedWitel = ref(null);
const selectedPeriode = ref(new Date());

onBeforeMount(async () => {
  if (
    heroAnalyticRef.achievements.value.length < 1 ||
    heroAnalyticRef.recommendations.value.length < 1
  ) {
    await fetchFilter();
    if (!categoryRef.loading.value) {
      selectedDivre.value = categoryRef.selectedDivre.value;
      selectedWitel.value = categoryRef.selectedWitel.value;

      renderData();
    }
  }

  selectedDivre.value = categoryRef.selectedDivre.value;
  selectedWitel.value = categoryRef.selectedWitel.value;
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

async function renderData() {
  categoryRef.selectedDivre.value = selectedDivre.value;
  categoryRef.selectedWitel.value = selectedWitel.value;

  await fetchAnalytic({
    periode: moment(selectedPeriode.value).format("yyyyMM"),
    divre: selectedDivre.value,
    witel: selectedWitel.value,
    cache: true,
  });
}
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
                :disabled="
                  heroAnalyticRef.bulk_loading.value ||
                  categoryRef.loading.value
                "
                :options="categoryRef.divre.value"
                v-model="selectedDivre"
              />
            </div>
            <div class="form-group mr-3">
              <label>Witel</label>
              <Select
                width="190"
                :disabled="
                  heroAnalyticRef.bulk_loading.value ||
                  categoryRef.loading.value
                "
                :options="categoryRef.witels.value"
                v-model="selectedWitel"
              />
            </div>
            <div class="form-group">
              <button
                class="btn btn-primary"
                type="button"
                style="height: 35px"
                :disabled="
                  heroAnalyticRef.bulk_loading.value ||
                  categoryRef.loading.value
                "
                @click="renderData"
              >
                FILTER
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12">
      <div class="row">
        <div class="col-sm-12 mb-3">
          <div class="card mb-3">
            <div class="card-body">
              <h5>Achievement - Prescriptive</h5>
            </div>
          </div>
          <div class="row">
            <div
              v-for="(achievement, index) in heroAnalyticRef.achievements.value"
              class="col"
              :class="
                index == 0
                  ? 'pr-1'
                  : index != heroAnalyticRef.achievements.value.length - 1
                  ? 'pl-1 pr-1'
                  : 'pl-1'
              "
              :key="index"
            >
              <LayeredCard
                :loading="heroAnalyticRef.loading_ach.value"
                :height="300"
              >
                <div class="card" v-if="!heroAnalyticRef.loading_ach.value">
                  <div class="card-body">
                    <h5>{{ achievement.title }}</h5>
                    <Chart
                      height="250"
                      :type="TypeOption.RADIAL_BAR"
                      :series="[achievement.value]"
                    />
                  </div>
                </div>
              </LayeredCard>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-12 mb-3">
          <div class="card">
            <div class="card-body">
              <table class="table">
                <thead>
                  <tr>
                    <td>Indicator</td>
                    <td>Recommendation</td>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="recommendation in heroAnalyticRef.recommendations
                      .value"
                    :key="recommendation.name"
                  >
                    <td>
                      <div v-if="heroAnalyticRef.loading_rec.value">
                        <Loading />
                      </div>
                      <p v-else>
                        <b>{{ recommendation.name }}</b>
                      </p>
                    </td>
                    <td>
                      <div v-if="heroAnalyticRef.loading_rec.value">
                        <Loading />
                      </div>
                      <p v-else>
                        {{ recommendation.value }}
                      </p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.table thead td {
  font-size: 12px !important;
}

.table tbody td {
  font-size: 14px !important;
}
</style>
