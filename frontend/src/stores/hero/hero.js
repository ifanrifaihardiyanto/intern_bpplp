import { defineStore } from "pinia";
import { serialize } from "../../helpers/urls";
import { heroRequests } from "./requests";
import http from "../../helpers/http";

export const useHeroStore = defineStore({
  id: "hero",
  state: () => ({
    selectedCategory: null,
    selectedIndicator: null,
    filter_loading: false,
    filter_categories: [],
    filter_indicators: [],
    data_loading: false,
    hero_data_labels: [],
    hero_data: [],
  }),
  actions: {
    async fetchHeroFilter() {
      this.filters = [1, 2];
      this.filter_loading = true;

      try {
        const response = await http.get(heroRequests.getHeroFilter);
        const data = response.data.data;

        this.filter_categories = data.category;
        this.filter_indicators = data.indicator;

        this.selectedCategory = this.filter_categories[0].key;
        this.selectedIndicator = this.filter_indicators[0].key;
      } catch (error) {
        console.error(error);
      }

      this.filter_loading = false;
    },
    async fetchHeroData(filter) {
      this.data_loading = true;
      const queryString = serialize(filter);

      try {
        const requestUrl = `${heroRequests.getHeroData}?${queryString}`;
        const response = await http.get(requestUrl);
        const data = response.data.data;

        this.hero_data_labels = data.labels;
        this.hero_data = data.data;
      } catch (error) {
        console.error(error);
      }

      this.data_loading = false;
    },
  },
});
