<script setup>
import { ref } from "@vue/reactivity";
import { onMounted, watch } from "@vue/runtime-core";
import { storeToRefs } from "pinia";
import moment from "moment";
import { useCategoryStore } from "../stores/filter/category";
import { useHeroStore } from "../stores/hero/hero";
import { DatePicker, Select } from "../components/index";
import LayeredCard from "../components/LayeredCard.vue";

const categoryStore = useCategoryStore();
const categoryRef = storeToRefs(categoryStore);
const { fetchFilter } = categoryStore;

const heroStore = useHeroStore();
const heroRef = storeToRefs(heroStore);
const { fetchHeroFilter, fetchHeroData } = heroStore;

const selectedPeriode = ref(new Date());
const selectedCategory = ref(null);
const selectedIndicator = ref(null);
const selectedWitel = ref(null);

onMounted(async () => {
  if (
    categoryRef.witels.value.length < 1 ||
    heroRef.filter_categories.value.length < 1 ||
    heroRef.filter_indicators.value.length < 1
  ) {
    await fetchFilter();
    await fetchHeroFilter();
    if (!categoryRef.loading.value && !heroRef.filter_loading.value) {
      selectedWitel.value = categoryRef.selectedWitel.value;
      selectedCategory.value = heroRef.selectedCategory.value;
      selectedIndicator.value = heroRef.selectedIndicator.value;

      await renderTable();
    }
  }

  selectedWitel.value = categoryRef.selectedWitel.value;
  selectedCategory.value = heroRef.selectedCategory.value;
  selectedIndicator.value = heroRef.selectedIndicator.value;

  if (heroRef.hero_data.value.length < 1) {
    await renderTable();
  }
});

const renderTable = async () => {
  await fetchHeroData({
    periode: moment(selectedPeriode.value).format("yyyyMM"),
    category: selectedCategory.value,
    indicator: selectedIndicator.value,
    witel: selectedWitel.value,
  });
};

let rowSpan = 1;
const rowSpanChanger = (before, after) => {
  if (before == after) {
    ++rowSpan;
  } else {
    rowSpan = 1;
  }

  console.log(rowSpan);

  return rowSpan;
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
              <label>Witel</label>
              <Select
                width="190"
                :disabled="categoryRef.loading.value"
                :options="categoryRef.witels.value"
                v-model="selectedWitel"
              />
            </div>
            <div class="form-group mr-3">
              <label>Category</label>
              <Select
                width="150"
                :disabled="heroRef.filter_loading.value"
                :reduce="(option) => option.key"
                :options="heroRef.filter_categories.value"
                v-model="selectedCategory"
              />
            </div>
            <div class="form-group mr-3">
              <label>Indicator</label>
              <Select
                width="210"
                :disabled="heroRef.filter_loading.value"
                :reduce="(option) => option.key"
                :options="heroRef.filter_indicators.value"
                v-model="selectedIndicator"
              />
            </div>
            <div class="form-group">
              <button
                class="btn btn-primary"
                type="button"
                style="height: 35px"
                :disabled="
                  categoryRef.loading.value ||
                  heroRef.filter_loading.value ||
                  heroRef.data_loading.value
                "
                @click="renderTable()"
              >
                FILTER
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-md-12">
      <LayeredCard :loading="heroRef.data_loading.value" height="290">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table
                class="table table-bordered table-hover"
                width="100%"
                v-if="!heroRef.data_loading.value"
              >
                <thead>
                  <tr>
                    <th rowspan="2">HERO</th>
                    <th rowspan="2">STO</th>
                    <th
                      class="text-center"
                      :colspan="heroRef.hero_data_labels.value.length"
                    >
                      BULAN
                    </th>
                  </tr>
                  <tr>
                    <th
                      v-for="(month, index) in heroRef.hero_data_labels.value"
                      :key="index"
                    >
                      {{ moment(`${month}01`).format("MMM") }}
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(item, index) in heroRef.hero_data.value"
                    :key="index"
                  >
                    <td>
                      {{ item.hero }}
                    </td>
                    <td>
                      {{ item.sto_desc }}
                    </td>
                    <td v-for="(value, index) in item.values" :key="index">
                      {{ value }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </LayeredCard>
    </div>
  </div>
</template>
