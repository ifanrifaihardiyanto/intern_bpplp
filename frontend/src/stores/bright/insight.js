import { defineStore } from "pinia";
import { serialize } from "./../../helpers/urls";
import { heroRequests } from "./requests";
import http from "../../helpers/http";

export const useInsightStore = defineStore({
  id: "bright-hero-insight",
  state: () => ({
    loaded: false,
    loading: false,
    charts: [],
  }),
  getters: {
    getSeries: (state) => state.charts,
  },
  actions: {
    async fetchInsight(filter) {
      this.loading = true;
      this.charts = [...Array(4).keys()];
      const queryString = serialize({
        category: "ffg",
        hero: filter.hero,
        year: filter.year,
        type: filter.type,
      });

      try {
        const requestUrl = `${heroRequests.getHeroInsight}?${queryString}`;
        const response = await http.get(requestUrl);

        this.charts = response.data.data;
        this.loaded = true;
      } catch (error) {
        console.error(error);
        this.loaded = false;
      }

      this.loading = false;
    },
    async fetchMultipleInsight(filter) {
      this.charts = [...Array(4).keys()];
      this.loading = true;
      const initFilter = {
        category: null,
        type: "ly_vs_y",
        hero: filter.hero,
        year: filter.year,
      };

      try {
        const responses = await Promise.all([
          http.get(
            this.requestBuilder({
              category: "ffg",
              hero: filter.hero,
              year: filter.year,
              type: filter.type,
            })
          ),
          http.get(
            this.requestBuilder({
              category: "qggn",
              hero: filter.hero,
              year: filter.year,
              type: filter.type,
            })
          ),
          http.get(
            this.requestBuilder({
              category: "revenue",
              hero: filter.hero,
              year: filter.year,
              type: filter.type,
            })
          ),
          http.get(
            this.requestBuilder({
              category: "prodigi",
              hero: filter.hero,
              year: filter.year,
              type: filter.type,
            })
          ),
          http.get(
            this.requestBuilder({
              category: "sales",
              hero: filter.hero,
              year: filter.year,
              type: filter.type,
            })
          ),
          http.get(
            this.requestBuilder({
              category: "new_loss_to_sales",
              hero: filter.hero,
              year: filter.year,
              type: filter.type,
            })
          ),
        ]);

        this.charts = [];
        responses.forEach((response) => {
          this.charts.push(response.data.data);
        });

        this.loaded = true;
      } catch (error) {
        console.error(error);
        this.loaded = false;
      }

      this.loading = false;
    },
    requestBuilder(filter) {
      const queryString = serialize(filter);
      return `${heroRequests.getHeroInsight}?${queryString}`;
    },
  },
});
