<template>
    <header>
        <h1>{{ title }}</h1>
    </header>
</template>
<script>
export default {
    props: ['title']
}
</script>
<style scoped>
    header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        margin: 0 auto;
        padding: 15px 0 15px;
    }

    h1 {
        font-size: 6vw;
        text-align: center;
    }

    @media (orientation: landscape) {
        h1 {
            font-size: 6vh;
            text-align: center;
        }
    }
</style>
