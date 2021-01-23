<template>
    <footer>
        <router-link to="/" class="point">
            <font-awesome-icon icon="home" size="2x"/>
        </router-link>
        <router-link to="/history" class="point">
            <font-awesome-icon icon="history" size="2x"/>
        </router-link>
        <router-link to="/categories" class="point">
            <font-awesome-icon icon="server" size="2x" />
        </router-link>
        <router-link to="/scan" class="point">
            <font-awesome-icon icon="qrcode" size="2x" />
        </router-link>
    </footer>
</template>
<script>
    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
    import { library } from '@fortawesome/fontawesome-svg-core';
    import {faHome, faHistory, faCog, faQrcode, faServer} from '@fortawesome/free-solid-svg-icons';

    library.add(faHome, faHistory, faCog, faQrcode, faServer);
    export default {
        components: {
            FontAwesomeIcon,
        },
    }
</script>
<style scoped>
    footer {
        position: fixed;
        right: 0;
        left: 0;
        bottom: 0;
        width: 100%;
        max-width: 550px;
        margin: 0 auto;
        padding: 10px 15px;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        color: var(--color2);
        background: #fcf5f5;
    }

    footer .router-link-exact-active {
        color: var(--color3);
        cursor: pointer;
    }

    .point {
        text-align: center;
        color: inherit;
    }
</style>
