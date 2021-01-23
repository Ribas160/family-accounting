<template>
    <div class="container">
        404 Not Found
    </div>
</template>
<script>
    export default {
        mounted() {
            this.$emit('loadTitle', '');
        }
    }
</script>
