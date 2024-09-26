<template>
    <div class="chart-container">
        <LineChartGenerator
            :chart-options="chartOptions"
            :chart-data="chartData"
            :chart-id="chartId"
            :dataset-id-key="datasetIdKey"
            :plugins="plugins"
            :css-classes="cssClasses"
            :styles="styles"
            :width="width"
            :height="height"
        />
    </div>
</template>

<script>
import { Line as LineChartGenerator } from "vue-chartjs/legacy";

import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    LineElement,
    LinearScale,
    CategoryScale,
  PointElement,
} from "chart.js";

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    LineElement,
    LinearScale,
    CategoryScale,
    PointElement
);

export default {
    name: "LineChart",
    components: {
        LineChartGenerator,
    },
    props: {
        chartId: {
            type: String,
            default: "line-chart",
        },
        datasetIdKey: {
            type: String,
            default: "label",
        },
        width: {
            type: Number,
            default: 400,
        },
        height: {
            type: Number,
            default: 400,
        },
        cssClasses: {
            default: "",
            type: String,
        },
        styles: {
            type: Object,
            default: () => {},
        },
        plugins: {
            type: Array,
            default: () => [],
        },
    },

    data() {
        return {
            chartData: {
                labels: [],
                datasets: [
                    {
                        label: "Sales Report",
                        backgroundColor: "#f87979",
                        data: [],
                    },
                ],
            },
            chartOptions: {
                responsive: true,
                maintainAspectRatio: false,
            },
        };
    },

    methods: {

        loadReport(){
            axios.get('/load-report').then(res=>{

                const labels = res.data.map(label => label.month_name);
                const priceValues = res.data.map(priceValue => priceValue.total_price);
                console.log(priceValues);
                
                this.chartData.labels = labels;
                this.chartData.datasets[0].data = priceValues;

            
            }).catch(err=>{
            
            })
        }
    },

    mounted() {
        this.loadReport()
    },
};

</script>

<style scoped>
    .chart-container {
        width: 800px;
        margin: 35px auto;
    }
</style>
