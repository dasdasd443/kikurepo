<template>
    <basic-modal-layout>
        <template #header>
            <h1>Add Product</h1>
            <button @click='$emit("closePopup")'>&times;</button>
        </template>
        <template #content>
            <form method='post' id='add-product-form' @submit.prevent='addProduct'>
                <div class="form-group">
                    <label for="product-preview-image">Image</label>
                    <input type="file" id='product-image' name='product-image'>
                </div>
                <div class="form-group">
                    <label for="product-name">Product Name</label>
                    <input type="text" id='product-name' name='product-name'>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category" id="category">
                        <option value="">Select the category</option>
                        <option v-for='category in categories' :key='category.category_id' :value='category.category_id'>
                            {{category.category_name}}
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" id='price' name='price'>
                </div>
                <div class="form-group">
                    <label for="sku">SKU</label>
                    <input type="text" id='sku' name='sku'>
                </div>
                <div class="form-group">
                    <label for="length">Length</label>
                    <input type="number" id='length' name='length'>
                </div>
                <div class="form-group">
                    <label for="width">Width</label>
                    <input type="number" id='width' name='width'>
                </div>
                <div class="form-group">
                    <label for="height">Height</label>
                    <input type="number" id='height' name='height'>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" cols="30" rows="10"></textarea>
                </div>
                <div class="form-group">
                    <label for="Details">Details</label>
                    <textarea name="details" id="Details" cols="30" rows="10"></textarea>
                </div>
                <div class="form-group submit">
                    <button type='submit' >Add Product</button>
                </div>
            </form>
        </template>
    </basic-modal-layout>
</template>

<script>
import BasicModalLayout from './layouts/BasicModalLayout.vue'
export default {
    data() {
        return {
            categories: ''
        }
    },
    components: {
        BasicModalLayout
    },
    methods: {
        async addProduct() {
            const elem = document.querySelector('#add-product-form');
            const form = new FormData(elem)
            const result = await fetch(route('add_product').url(),{ 
                headers:{
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                },
                method: 'POST',
                body: JSON.stringify({
                    'product-name': form.get('product-name'),
                    'category': form.get('category'),
                    'price': form.get('price'),
                    'sku': form.get('sku'),
                    'height': form.get('height'),
                    'length': form.get('length'),
                    'width': form.get('width'),
                    'description': form.get('description'),
                    'details': form.get('details'),
                })
            }).then(response => {
                return response.json()
            });

            console.log(result)
        },
        async getCategories() {
            this.categories = await fetch('api/categories').then( response => {
                return response.json();
            });
        }
    },
    mounted() {
        this.getCategories()
    }
}
</script>

<style lang="scss" scoped>
form{
    display:grid;
    gap:1rem;
    .form-group{
        display:grid;
        input,textarea,select{
            padding:5px;
            outline:1px solid black;
            font-size:15px;
            width:100%;
        }
    }
    .submit{
        display: flex;
        justify-content: flex-end;
        align-items: center;
        button{
            width:50%;
            padding:5px;
            transition:all .45s;
            border-radius: 5px 5px 5px 5px;
        }
        button:hover{
            background: grey;
            color:white;
        }
    }
}
</style>