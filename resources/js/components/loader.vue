<template>
    <div>
        <loading
            :active.sync="isLoading"
            :can-cancel="true"
            :is-full-page="true"
            :backgroundColor="'none'"
            :color="'#fff'">
        </loading>
    </div>
</template>
<script>
    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';
    export default {
        components: {
            Loading,
        },
        props: ['isLoading'],
    }
</script>
