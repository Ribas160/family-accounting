<script>
    import { Doughnut, mixins } from 'vue-chartjs';
    export default {
        extends: Doughnut,
        mixins: [mixins.reactiveProp],
        components: {
            Doughnut,
        },
        props: ['chartData', 'options'],
        mounted () {
            this.renderChart(this.chartData, this.options);
        }
    }
</script>
