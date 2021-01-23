<template>
    <div class="container">
        <Loader v-bind:is-loading="isLoading" />
        <input type="month" v-model="date" v-on:change="updateData" />
        <Doughnut class="doughnut" v-bind:chart-data="chartData" />
    </div>
</template>
<script>
    import Doughnut from "../components/index/doughnut";
    import Loader from "../components/loader";
    import axios from "axios";

    export default {
        name: 'index',
        components: {
            Doughnut,
            Loader,
        },
        data() {
            return {
                date: '',
                chartData: {},
                isLoading: false,
            }
        },
        mounted() {
            this.$emit('loadTitle', 'Статистика');
            let date = new Date();
            let month = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
            this.date = date.getFullYear() + '-' + month[date.getMonth()];
            this.updateData();
        },
        methods: {
            updateData() {
                this.isLoading = true;
                axios
                    .post('https://5c3bf1fc202e.ngrok.io/projects/tmp/family-accounting/public/api/doughnut', {
                        date: this.date,
                    })
                    .then((res) => {
                        this.isLoading = false;
                        this.chartData = {
                            labels: res.data.labels,
                            datasets: [
                                {
                                    backgroundColor: res.data.backgroundColor,
                                    data: res.data.data,
                                }
                            ],
                        }
                    });
            }
        }
    }
</script>
<style scoped>
    .container {
        height: 100%;
    }
    input {
        width: auto;
        margin: 0 auto;
        display: block;
        border-radius: 5px;
    }
    .doughnut {
        position: absolute;
        top: 50%;
        transform: translateY(-45%);
        left: 0;
        right: 0;
        margin: 0 auto;
        width: 90%;
    }
</style>
