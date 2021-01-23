<template>
    <div class="container">
        <Loader v-bind:is-loading="isLoading" />
        <ul>
            <li v-for="product in products">
                <div>
                    <span class="name">{{ product.name }}</span>
                </div>
                <div>
                    <font-awesome-icon icon="times" class="del" v-on:click="deleteProduct(product.id)" />
                </div>
            </li>
            <li class="add" v-on:click="showForm">Добавить позицию</li>
        </ul>
        <div class="addBlock">
            <font-awesome-icon icon="times" class="closeForm" v-on:click="hideForm" />
            <Form v-on:formSubmit="createProduct" v-bind:fields="this.fields"/>
        </div>
    </div>
</template>
<script>
    import Form from '../../components/form';
    import Loader from '../../components/loader';
    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
    import { library } from '@fortawesome/fontawesome-svg-core';
    import {faTimes} from '@fortawesome/free-solid-svg-icons';
    import axios from "axios";

    library.add(faTimes);
    export default {
        components: {
            Loader,
            Form,
            FontAwesomeIcon,
        },
        data() {
            return {
                category: '',
                products: [],
                fields: {
                    name: {
                        name: 'Название',
                        type: 'text',
                        error: false,
                        message: '',
                        required: true,
                    },
                },
                isLoading: false,
            }
        },
        created() {
            this.isLoading = true;
            this.category = this.$router.currentRoute.params.category;
            axios
                .post('https://5c3bf1fc202e.ngrok.io/projects/tmp/family-accounting/public/api/products/get', {
                    category: this.category,
                })
                .then((res) => {
                    this.isLoading = false;
                    this.products = res.data;
                });
        },
        mounted() {
            this.$emit('loadTitle', this.category);
        },
        methods: {
            createProduct(field) {
                axios
                    .post('https://5c3bf1fc202e.ngrok.io/projects/tmp/family-accounting/public/api/products/create', {
                        name: field.name,
                        category: this.category,
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
                        } else {
                            this.fields.name.error = false;
                            this.products = res.data;
                            this.hideForm();
                        }
                    });
            },
            deleteProduct(id) {
                axios
                    .post('https://5c3bf1fc202e.ngrok.io/projects/tmp/family-accounting/public/api/products/delete', {
                        id: id,
                        category: this.category,
                    })
                    .then(res => (this.products = res.data));
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
        padding: 15px 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: var(--listColor);
        border-radius: 10px;
    }
    li:first-of-type {
        margin-top: 0;
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

    .price {
        margin-right: 10px;
        font-size: 3vw;
    }

    .closeForm {
        position: absolute;
        top: 5px;
        right: 15px;
        font-size: 20px;
        color: #fff;
    }
</style>
