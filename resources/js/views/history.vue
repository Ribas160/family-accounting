<template>
    <div class="container">
        <Loader v-bind:is-loading="isLoading" />
        <ul>
            <li v-for="payment in payments">
                <div>{{ payment.date }}</div>
                <div>{{ payment.store }}</div>
                <div>{{ payment.product }}</div>
                <div>{{ payment.price }}₽</div>
            </li>
        </ul>
        <span v-if="payments == ''">Вы пока что еще ничего не купили))</span>
    </div>
</template>
<script>
    import Loader from '../components/loader';
    import axios from "axios";

    export default {
        components: {
            Loader,
        },
        data() {
            return {
                payments: {},
                isLoading: false,
            }
        },
        created() {
            this.isLoading = true;
            axios
                .post('https://5c3bf1fc202e.ngrok.io/projects/tmp/family-accounting/public/api/history/get')
                .then((res) => {
                    this.isLoading = false;
                    this.payments = res.data
                });
        },
        mounted() {
            this.$emit('loadTitle', 'История');
        }
    }
</script>
<style scoped>
    li {
        width: 100%;
        margin-top: 10px;
        padding: 10px 10px;
        font-size: 4vw;
        background: var(--color2);
        border-radius: 10px;
    }

    li:first-of-type {
        margin-top: 0;
    }
    li div {
        margin-top: 5px;
    }
    li div:first-of-type {
        margin-top: 0;
    }

    @media (orientation: landscape) {
        li {
            font-size: 4vh;
        }
    }
</style>
