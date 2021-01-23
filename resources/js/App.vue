<template>
    <div id="app">
        <Header class="header" v-bind:title="title" />
        <div class="wrapper">
            <router-view v-on:loadTitle="getTitle" />
        </div>
        <Footer class="footer" />
    </div>
</template>

<script>
import Header from "./components/header";
import Footer from "./components/footer";
export default {
    name: 'App',
    components: {
        Header,
        Footer,
    },
    data() {
        return {
            title: 'title',
        }
    },
    methods: {
        getTitle(title) {
            this.title = title;
        }
    },
    mounted() {
        function wrapper() {
            let wrap = document.querySelector('.wrapper');
            let headerHeight = document.querySelector('.header').offsetHeight;
            let footerHeight = document.querySelector('.footer').offsetHeight;
            wrap.style.height = (window.innerHeight - footerHeight - headerHeight) + 'px';
            wrap.style.marginTop = headerHeight + 'px';
        }
        wrapper();
        window.onresize = () => {
            wrapper();
        }
    }
}
</script>
<style>
    :root {
        --color1: #14325a;
        --color2: #8d8d8d;
        --color3: #dc4433;
        --listColor: #8e8ec1;
    }
    * {
        margin: 0;
        padding: 0;
        outline: none;
        text-decoration: none;
        list-style-type: none;
        box-sizing: border-box;
    }

    body {
        font-family: 'Commissioner', sans-serif;
        color: #fff;
        background: var(--color1);
    }

    #app {
        position: relative;
        width: 100%;
        max-width: 550px;
        margin: 0 auto;
    }

    .wrapper {
        padding: 0 0 15px;
        overflow: scroll;
        -ms-overflow-style: none;
    }
    .wrapper::-webkit-scrollbar { width: 0; }

    .container {
        position: relative;
        padding: 0 15px;
        overflow: hidden;
    }

    a {
        color: inherit;
    }
</style>
