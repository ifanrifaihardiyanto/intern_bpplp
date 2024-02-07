import { ref, computed } from "vue";
import { defineStore } from "pinia";
import http from "../../helpers/http";
import { heroRequests } from "./requests";
import { serialize } from "../../helpers/urls";

export const useCategoryStore = defineStore({
  id: "bright-hero-category",
  state: () => ({
    loaded: false,
    loading: false,
    selectedWitel: null,
    selectedHero: null,
    witels: [],
    heroes: [],
  }),
  actions: {
    async fetchCategory(filters = null) {
      this.loading = true;
      let response = null;

      try {
        const queryString = filters != null ? serialize(filters) : null;
        const requestUrl = `${heroRequests.getHeroList}?${queryString}`;
        response = await http.get(requestUrl);
        const result = response.data.data;

        if (filters != null && filters.select == "hero") {
          this.selectedHero = result.hero.data[0];
          this.heroes = result.hero.data;
        } else if (filters != null && filters.select == "witel") {
          this.selectedWitel = result.witel.data[0];
          this.witels = result.witel.data;
        } else {
          this.selectedWitel = result.witel.data[0];
          this.selectedHero = result.hero.data[0];

          this.witels = result.witel.data;
          this.heroes = result.hero.data;
        }

        this.loaded = true;
      } catch (error) {
        console.log(error);
        this.loaded = false;
        return response;
      }

      this.loading = false;

      return response;
    },
  },
});
