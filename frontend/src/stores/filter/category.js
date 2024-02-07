import { ref, computed } from "vue";
import { defineStore } from "pinia";
import http from "../../helpers/http";
import { heroRequests } from "../bright/requests";
import { serialize } from "../../helpers/urls";

export const useCategoryStore = defineStore({
  id: "filter-category",
  state: () => ({
    loaded: false,
    loading: false,
    selectedDivre: null,
    selectedWitel: null,
    selectedHero: null,
    divre: [],
    witels: [],
    heroes: [],
  }),
  actions: {
    async fetchFilter(filters = null) {
      this.loading = true;
      let response = null;

      try {
        const queryString =
          filters != null
            ? serialize(filters)
            : serialize({ witel: "DENPASAR" });
        const requestUrl = `${heroRequests.getHeroList}?${queryString}`;
        response = await http.get(requestUrl);
        const result = response.data.data;

        if (filters != null && filters.select == "hero") {
          this.selectedHero = result.hero.data[0];
          this.heroes = result.hero.data;
        } else if (filters != null && filters.select == "divre") {
          this.selectedDivre = result.divre.divre;
          this.divre = result.divre.data;
        } else if (filters != null && filters.select == "witel") {
          this.selectedWitel = result.witel.data[1];
          this.witels = result.witel.data;
        } else {
          this.selectedDivre = result.divre.divre;
          this.selectedWitel = result.witel.data[1];
          this.selectedHero = result.hero.data[0];

          this.divre = result.divre.data;
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
