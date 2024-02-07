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
      <div class="mt-2 mb-2 w-75">
        <div class="analytic-header">
          <div class="analytic-icon">
            <img :src="data.icon" alt="Analytic Icon" />
          </div>
          <div>
            <h5>{{ data.title }}</h5>
            <h2>{{ formatter.format(data.total) }}</h2>
          </div>
        </div>
        <hr />
        <div>
          <div class="mb-3">
            <table width="100%">
              <tbody>
                <tr>
                  <td
                    v-for="(item, index) in data.body"
                    :key="index"
                    :class="
                      index != data.body.length - 1
                        ? 'text-left pr-3'
                        : 'text-left'
                    "
                  >
                    <b>{{ item.total }}</b>
                  </td>
                </tr>
                <tr>
                  <td
                    class="text-left"
                    v-for="(item, index) in data.body"
                    :key="index"
                    :class="
                      index != data.body.length - 1
                        ? 'text-left pr-2'
                        : 'text-left'
                    "
                  >
                    {{ item.title }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <hr />
          <div>
            <table width="100%">
              <tbody>
                <tr>
                  <td
                    v-for="(item, index) in data.tile"
                    :key="index"
                    :class="
                      index != data.tile.length - 1
                        ? 'text-left pr-3'
                        : 'text-left'
                    "
                  >
                    <b>{{ formatter.format(item.total) }}</b>
                  </td>
                </tr>
                <tr>
                  <td
                    class="text-left"
                    v-for="(item, index) in data.tile"
                    :key="index"
                    :class="
                      index != data.tile.length - 1
                        ? 'text-left pr-2'
                        : 'text-left'
                    "
                  >
                    {{ item.title }}
                  </td>
                </tr>
              </tbody>
            </table>
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
  justify-content: space-around;
}

.analytic-icon,
.analytic-icon img {
  width: 60px;
}

.analytic-card {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
</style>
