<template>
    <form class="categoryForm" v-on:submit="formSubmit">
        <div class="form--field" v-for="(field, key) in fields" :key="key" >
            <label v-bind:for="key">
                {{ field.name }}
                <span v-if="field.required">*</span>
            </label>
            <input v-bind:type="field.type" list v-model="models[key]" v-bind:id="key" v-bind:class="{fieldError: field.error}">
            <div v-if="field.error" class="message">{{ field.message }}</div>
        </div>
        <input type="submit" value="Добавить">
    </form>
</template>
<script>
    export default {
        props: ['fields'],
        data() {
            return {
                models: {},
            }
        },
        methods: {
            formSubmit() {
                this.$emit('formSubmit', this.models);
            }
        }
    }
</script>
<style scoped>
    form {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .form--field {
        width: 100%;
        margin-top: 10px;
    }

    .form--field:first-of-type {
        margin-top: 0;
    }

    label {
        margin-left: 5px;
    }

    input {
        display: block;
        margin: 5px auto 0;
        text-align: center;
    }

    input[type=text] {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 10px;
    }

    input[type=submit] {
        width: 80%;
        padding: 10px;
        border: none;
        border-radius: 10px;
        font-size: 20px;
        color: #fff;
        background: blue;
    }

    .fieldError {
        border: 2px solid red !important;
    }

    .message {
        color: red;
    }
</style>
