import { defineStore } from "pinia";
import { serialize } from "../../helpers/urls";
import { analyticRequests } from "./requests";
import http from "../../helpers/http";

export const useAnalyticStore = defineStore({
  id: "dashboard-analytic",
  state: () => ({
    financial_loading: false,
    financials: [],
    operational_loading: false,
    operationals: [],
  }),
  actions: {
    async fetchFinancialAnalytic(filter) {
      this.financials = [...Array(4).keys()];
      this.financial_loading = true;
      const queryString = serialize(filter);

      try {
        const requestUrl = `${analyticRequests.getFinancialAnalytic}?${queryString}`;
        const response = await http.get(requestUrl);

        this.financials = response.data.data;
      } catch (error) {
        console.error(error);
      }

      this.financial_loading = false;
    },
    async fetchOperationalAnalytic(filter) {
      this.operationals = [...Array(10).keys()];
      this.operational_loading = true;
      const queryString = serialize(filter);

      try {
        const requestUrl = `${analyticRequests.getOperationalAnalytic}?${queryString}`;
        const response = await http.get(requestUrl);

        this.operationals = response.data.data;
      } catch (error) {
        console.error(error);
      }

      this.operational_loading = false;
    },
  },
});
