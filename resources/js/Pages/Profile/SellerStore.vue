<template>
    <app-layout>
        <template #content>
            {{store}}
            
            <h1>Products</h1>

            <div class="products-container">
                <div class="product-actions">
                    <button @click='addProduct'>Add Product</button>
                </div>
                <table class='products-table'>
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Name</td>
                            <td>Price</td>
                            <td>Stock</td>
                            <td>SKU</td>
                            <td>Details</td>
                            <td>Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for='product in products' :key='product.product_id'>
                            <td>{{product.product_id}}</td>
                            <td>{{product.product_name}}</td>
                            <td>{{product.product_price}}</td>
                            <td>{{product.product_stock}}</td>
                            <td>{{product.product_sku}}</td>
                            <td>Details</td>
                            <td class='action-buttons'><button>Update</button><button>Delete</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <AddProductModal @closePopup='closePopup' class='AddProduct popup'/>
        </template>
    </app-layout>
</template>


<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import AddProductModal from '@/Pages/Modals/AddProductModal.vue'

export default {
    components: { AppLayout, AddProductModal },
    props:['store','products'],
    methods: {
        addProduct() {
            document.querySelector('.AddProduct').style.display = 'block';
        },
        closePopup() {
            document.querySelectorAll('.popup').forEach(elem => {
                elem.style.display = 'none';
            });
        }
    }
}
</script>

<style lang='scss' scoped>
.popup{
    display:none;
    position: fixed;
    top: 0;
    left: 0;
    width:100vw;
    height:100vh;
    z-index: 1;
    background-color:rgba(0,0,0,0.5);
}
.products-container{
    width:100vw;
    display:grid;
    justify-content: center;
    align-content: center;
    .products-table{
        border:1px solid grey;
        td{ 
            border:1px solid grey;
            padding:10px 20px;
            align-content: center;
        }
        .action-buttons{
            align-content: center;
            gap:1rem;
            button{
                padding:0 5px;  
            }
        }
        .action-buttons button:focus{
            outline:none;
        }
    }
}
</style>