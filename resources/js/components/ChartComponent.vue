<template>
    <!-- resources/assets/js/components -->
    <div>
        <canvas id="canvas"></canvas>
    </div>
</template>

<script>
import {Chart} from './chart.js';
export default {
    props: {
        labels: String,
        dataProp: String
    },
    methods: {
        renderChart() {
            new Chart(document.getElementById('canvas').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: JSON.parse(this.labels),
                    datasets: [{
                        label: 'Score (%)',
                        data: JSON.parse(this.dataProp),
                        backgroundColor: [
                            '#2ecc71',
                            '#e74c3c',
                            '#8e44ad',
                            '#d35400',
                            '#16a085'
                        ]
                    }]
                },
                options: {
                    title: {
                        display: true,
                        fontSize: 22,
                        text: 'Big 5 Personality Dimensions',
                        responsive: true,
                        maintainAspectRatio: false
                    }
                }
            });
        }
    },
    mounted() {
        this.renderChart();
    }
}
</script>
