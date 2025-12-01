<template>
    <div class="apex-chart-wrapper">
        <apexchart
            :type="type"
            :options="chartOptions"
            :series="series"
            :height="height"
            :width="width"
        />
    </div>
</template>

<script setup>
import VueApexCharts from 'vue3-apexcharts';

const apexchart = VueApexCharts;

const props = defineProps({
    type: {
        type: String,
        default: 'line',
        validator: (value) => {
            return ['line', 'area', 'bar', 'pie', 'donut', 'radialBar', 'scatter', 'bubble', 'heatmap', 'candlestick', 'boxPlot', 'radar', 'polarArea', 'rangeBar', 'treemap'].includes(value);
        }
    },
    chartOptions: {
        type: Object,
        required: true
    },
    series: {
        type: Array,
        required: true
    },
    height: {
        type: [Number, String],
        default: 350
    },
    width: {
        type: [Number, String],
        default: '100%'
    }
});
</script>

<style scoped>
.apex-chart-wrapper {
    width: 100%;
}
</style>
