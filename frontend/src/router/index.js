import { createRouter, createWebHistory } from "vue-router";
import { BASE_URL } from "../config";
import DashboardView from "../views/DashboardView.vue";
import FinancialView from "../views/trend/FinancialView.vue";
import OperationalView from "../views/trend/OperationalView.vue";
import InsightView from "../views/bright/hero/InsightView.vue";
import AnalyticView from "../views/bright/hero/AnalyticView.vue";
import HeroView from "../views/HeroView.vue";

const router = createRouter({
  history: createWebHistory(BASE_URL),
  routes: [
    {
      path: "/frontend/dashboard/index",
      name: "dashboard",
      component: DashboardView,
    },
    {
      path: "/frontend/dashboard/trend",
      children: [
        {
          path: "financial",
          name: "trend-financial",
          component: FinancialView,
        },
        {
          path: "operational",
          name: "trend-operational",
          component: OperationalView,
        },
      ],
    },
    {
      path: "/frontend/dashboard/analytic",
      name: "analytic",
      component: AnalyticView,
    },
    {
      path: "/frontend/hero",
      children: [
        { path: "insight", name: "hero-insight", component: InsightView },
        {
          path: "report",
          name: "hero-report",
          component: HeroView,
        },
      ],
    },
  ],
});

export default router;
