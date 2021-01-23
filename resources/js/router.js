import Vue from 'vue';
import Router from 'vue-router';

// Pages
import Index from './views/index';
import History from './views/history';
import Scan from './views/scan';
import Categories from './views/categories';
import Products from './views/categories/products';
import NotFound from './views/404';

Vue.use(Router);

export default new Router({
    routes: [
        {
            path: '/',
            name: 'index',
            component: Index
        },
        {
            path: '/history',
            name: 'history',
            component: History
        },
        {
            path: '/scan',
            name: 'scan',
            component: Scan
        },
        {
            path: '/categories',
            name: 'categories',
            component: Categories,
        },
        {
            path: '/categories/:category',
            name: 'products',
            component: Products,
        },
        {
            path: '*',
            name: '404',
            component: NotFound,
        },
    ]
})
