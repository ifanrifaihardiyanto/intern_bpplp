import { defineStore } from "pinia";
import { serialize } from "../../helpers/urls";
import { trendRequests } from "./requests";
import http from "../../helpers/http";

export const useTrendStore = defineStore({
  id: "trend",
  state: () => ({
    financial_loaded: false,
    financial_loading: false,
    financials: [],
    opera_cat_loaded: false,
    opera_cat_loading: false,
    opera_categories: null,
    opera_loaded: false,
    opera_loading: {
      consumer: false,
      bges: false,
      rws: false,
    },
    operationals: {
      consumer: [],
      bges: [],
      rws: [],
    },
  }),
  getters: {
    getSeries: (state) => state.charts,
    getCategories: (state) => state.opera_categories,
  },
  actions: {
    async fetchOperationalCategory() {
      this.opera_cat_loading = true;
      try {
        const response = await http.get(
          trendRequests.getOperationalTrendFilter
        );

        this.opera_categories = response.data.data;
        this.opera_cat_loaded = true;
      } catch (error) {
        console.error(error);
        this.opera_cat_loaded = false;
      }

      this.opera_cat_loading = false;
    },
    async fetchOperationalTrend(filter) {
      this.opera_loading[filter.category] = true;
      const queryString = serialize(filter);

      try {
        const requestUrl = `${trendRequests.getOperationalTrend}?${queryString}`;
        const response = await http.get(requestUrl);

        this.operationals[filter.category] = response.data.data;

        this.opera_loaded = true;
      } catch (error) {
        console.error(error);
        this.opera_loaded = false;
      }

      this.opera_loading[filter.category] = false;
    },
    async fetchFinancialTrend(filter) {
      this.financials = [...Array(4).keys()];
      this.financial_loading = true;
      const queryString = serialize(filter);

      try {
        const requestUrl = `${trendRequests.getFinancialTrend}?${queryString}`;
        const response = await http.get(requestUrl);

        this.financials = response.data.data;
        this.financial_loaded = true;
      } catch (error) {
        console.error(error);
        this.financial_loaded = false;
      }

      this.financial_loading = false;
    },
  },
});
