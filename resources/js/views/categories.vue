<template>
    <div class="container">
        <Loader v-bind:is-loading="isLoading" />
        <ul>
            <li v-for="category in categories" :key="category.name">
                <router-link v-bind:to="{name: 'products', params: {category: category.name}}">
                    <span class="color" v-bind:style="{background: category.color}"></span>
                    <span class="name">{{ category.name }}</span>
                </router-link>
                <font-awesome-icon icon="times" class="del" v-on:click="deleteCategory(category.id, category.name)" />
            </li>
            <li class="add" v-on:click="showForm">Добавить категорию</li>
        </ul>
        <div class="addBlock">
            <font-awesome-icon icon="times" class="closeForm" v-on:click="hideForm" />
            <Form v-on:formSubmit="createCategory" v-bind:fields="this.fields" />
        </div>
    </div>
</template>
<script>
import Form from '../components/form';
import Loader from '../components/loader';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import {faTimes} from '@fortawesome/free-solid-svg-icons';
import axios from 'axios';

library.add(faTimes);
export default {
    components: {
        Form,
        Loader,
        FontAwesomeIcon,
    },
    data() {
        return {
            categories: [],
            fields: {
                name: {
                    name: 'Название',
                    type: 'text',
                    error: false,
                    message: '',
                    required: true,
                },
                color: {
                    name: 'Цвет',
                    type: 'color',
                    error: false,
                    message: '',
                    required: true,
                }
            },
            isLoading: false,
        }
    },
    created() {
        this.isLoading = true;
        axios
            .post('https://5c3bf1fc202e.ngrok.io/projects/tmp/family-accounting/public/api/categories/get')
            .then((res) => {
                this.isLoading = false;
                this.categories = res.data;
            });
    },
    mounted() {
        this.$emit('loadTitle', 'Категории');
    },
    methods: {
        createCategory(field) {
            axios
                .post('https://5c3bf1fc202e.ngrok.io/projects/tmp/family-accounting/public/api/categories/create', {
                    name: field.name,
                    color: field.color,
                })
                .then((res) => {
                    let message = res.data.message;
                    if (typeof message !== 'undefined') {
                        if (typeof message.name !== 'undefined') {
                            this.fields.name.error = true;
                            this.fields.name.message = message.name;
                        } else {
                            this.fields.name.error = false;
                        }
                        if (typeof message.color !== 'undefined') {
                            this.fields.color.error = true;
                            this.fields.color.message = message.color;
                        } else {
                            this.fields.color.error = false;
                        }
                    } else {
                        this.fields.name.error = false;
                        this.fields.color.error = false;
                        this.categories = res.data;
                        this.hideForm();
                    }
                });
        },
        deleteCategory(id, name) {
            axios
                .post('https://5c3bf1fc202e.ngrok.io/projects/tmp/family-accounting/public/api/categories/delete', {
                    id: id,
                    name: name,
                })
                .then(res => (this.categories = res.data));
        },
        showForm() {
            let form = document.querySelector('.addBlock');
            form.style.display = 'block';
        },
        hideForm() {
            let form = document.querySelector('.addBlock');
            form.style.display = 'none';
        },
    }
}
</script>
<style scoped>
li {
    width: 100%;
    margin: 15px auto 0;
    padding: 0 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--listColor);
    border-radius: 10px;
}
li:first-of-type {
    margin-top: 0;
}
li:last-of-type {
    padding: 15px 10px;
}

ul a {
    width: 100%;
    padding: 15px 0;
    display: flex;
    align-items: center;
}

.color {
    width: 15px;
    min-width: 15px;
    height: 15px;
    min-height: 15px;
    margin-top: 2px;
    margin-right: 10px;
    border-radius: 50%;
}

.del:hover {
    cursor: pointer;
}

.add {
    justify-content: center;
    background: green;
}
.add:hover {
    cursor: pointer;
}

.addBlock {
    position: fixed;
    top: 50%;
    transform: translateY(-50%);
    left: 0;
    right: 0;
    width: calc(100% - 30px);
    margin: 0 auto;
    padding: 30px 10px 15px;
    display: none;
    background: rgba(0, 0, 0, 1);
    border-radius: 20px;
}

.closeForm {
    position: absolute;
    top: 5px;
    right: 15px;
    font-size: 20px;
    color: #fff;
}
</style>
