<script setup>
import { defineProps } from "vue";
import { formatter } from "../helpers/function";

defineProps({
  data: {
    type: Object,
    required: true,
  },
});
</script>
<template>
  <div class="card">
    <div class="card-body analytic-card">
      <div class="mt-2 mb-2 w-100">
        <div class="analytic-header">
          <div class="analytic-icon ml-2 mr-4">
            <img :src="data.icon" alt="Analytic Icon" />
          </div>
          <div>
            <div>
              <h6 class="text-muted">{{ data.title }}</h6>
              <h4>{{ data.total }}</h4>
            </div>
            <hr />
            <div>
              <table width="100%">
                <tbody>
                  <tr>
                    <td class="text-left pr-3">
                      <b>{{ data.ach }}</b>
                    </td>
                    <td class="text-left">
                      <b>{{ data.yoy }}</b>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left pr-3">Ach</td>
                    <td class="text-left">YoY</td>
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
.analytic-header {
  display: flex;
  align-items: center;
}

.analytic-icon,
.analytic-icon img {
  width: 50px;
}

.analytic-card {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
</style>
