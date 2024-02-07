import { defineStore } from "pinia";
import { serialize } from "../../helpers/urls";
import { heroRequests } from "./requests";
import http from "../../helpers/http";

export const useHeroAnalyticStore = defineStore({
  id: "bright-hero-analytic",
  state: () => ({
    bulk_loading: false,

    loading_rec: false,
    recommendations: [],

    loading_ach: false,
    achievements: [],
  }),
  getters: {},
  actions: {
    async fetchAnalytic(filter) {
      this.bulk_loading = true;

      try {
        this.fetchAchievement(filter);
        this.fetchRecommendation(filter);
      } catch (error) {
        console.error(error);
      }

      this.bulk_loading = false;
    },
    async fetchRecommendation(filter) {
      this.recommendations = [1];

      this.loading_rec = true;
      const queryString = serialize(filter);

      try {
        const requestUrl = `${heroRequests.getHeroRecommendation}?${queryString}`;
        const response = await http.get(requestUrl);
        console.log(response);

        this.recommendations = response.data.data;
      } catch (error) {
        console.error(error);
      }

      this.loading_rec = false;
    },
    async fetchAchievement(filter) {
      this.achievements = [...Array(5).keys()];
      this.loading_ach = true;
      const queryString = serialize(filter);

      try {
        const requestUrl = `${heroRequests.getHeroAchievement}?${queryString}`;
        const response = await http.get(requestUrl);

        this.achievements = response.data.data;
      } catch (error) {
        console.error(error);
      }

      this.loading_ach = false;
    },
  },
});
