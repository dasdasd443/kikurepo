<template>
    <basic-modal-layout>
        <template #header>
            <h1>Add Product</h1>
            <button @click='$emit("closePopup")'>&times;</button>
        </template>
        <template #content>
            <form method='post'>
                <div class="form-group">
                    <label for="product-name">Product Name</label>
                    <input type="text" id='product-name'>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category" id="category">
                        <option value="Category">Category</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" id='price'>
                </div>
                <div class="form-group">
                    <label for="sku">SKU</label>
                    <input type="text" id='sku'>
                </div>
                <div class="form-group">
                    <label for="length">Length</label>
                    <input type="number" id='length'>
                </div>
                <div class="form-group">
                    <label for="width">Width</label>
                    <input type="number" id='width'>
                </div>
                <div class="form-group">
                    <label for="height">Height</label>
                    <input type="number" id='height'>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" cols="30" rows="10"></textarea>
                </div>
                <div class="form-group">
                    <label for="Details">Details</label>
                    <textarea name="Details" id="Details" cols="30" rows="10"></textarea>
                </div>
                <div class="form-group submit">
                    <button type='submit' @click.prevent='addProduct'>Add Product</button>
                </div>
            </form>
        </template>
    </basic-modal-layout>
</template>

<script>
import BasicModalLayout from './layouts/BasicModalLayout.vue'
export default {
    components: {
        BasicModalLayout
    },
    methods: {
        addProduct() {
            fetch(route('add_product').url(),{ 
                headers:{
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                },
                method: 'POST'
            }).then( response =>{
                console.log(response.json());
            });
        }
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