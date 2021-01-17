<template>
    <app-layout>
        <template #content>
            <div class="show-products-container">
                <div class="product-filter"></div>
                <div class='products-container' v-if='products.length > 0'>
                    <div class='product-card' v-for='n in products' :key='n.product_id'>
                        <a :href='"/product_details/" + n[0].product_id' v-if='n[2] == null'>
                            <img src="/storage/product_photos/no-image.png" alt="product_image">
                        </a>
                        <a :href='"/product_details/" + n[0].product_id' v-else>
                            <img :src='`/storage/product_photos/${n[0].photos_folder}/${n[2].photo_name}`' alt="product_image">
                        </a>
                        <div class='product-card-content'>
                            <a :href='"/product_details/" + n[0].product_id'>
                                <div class='product-details'>
                                    <h1>{{n[0].product_name}}</h1>
                                    <hr>
                                    <h1>Sold by: {{n[1].seller_name}}</h1>
                                    <h1>{{n[0].product_price}}</h1>
                                </div>
                            </a>
                            <div class='add-buttons'>
                                <button class='add-cart-button' @click='addToCart(n[0].product_id)'>Add to Cart</button>
                                <button class='add-wishlist-button' @click='addToWishlist(n[0].product_id)'>Add to Wishlist</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <h1>There are no products</h1>
                </div>
                <div class='sidebar'></div>
            </div>
        </template>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import {mapGetters,mapActions} from 'vuex'
export default {
    components:{
        AppLayout
    },
    methods:{
        async addToCart(product_id) {
            const response = fetch('/add_to_cart',{
                headers:{
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                },
                method:'POST',
                body: JSON.stringify({
                    product_id: product_id
                }),

            }).then(response=>{
                location.href= route('my_cart').url();
            })
        },

        addToWishlist(product_id) {
            console.log(product_id);
        }
    },
    computed:{
    },
    props:['products'],
    created(){
    },
    mounted() {
        
    }
}
</script>

<style lang='scss' scoped>
.product-card-content{
    display:grid;
    align-items: center;
    grid-template-columns: repeat(1,1fr);
    grid-template-columns: repeat(1,minmax(200px,1fr));
    grid-template-columns: repeat(auto-fit,minmax(200px,1fr));
    .product-details{
        flex:1;
        padding:10px;
    }
    .add-buttons{
        flex: 1;
        display:grid;
        align-items: center;
        gap:.5rem;
    }
    .add-cart-button,.add-wishlist-button{
        padding:5px;
        border:1px solid black;
        box-shadow: 5px black;
    }
}
.show-products-container{
    display:flex;
    padding:100px;
    @media screen and (max-width:1400px){
        padding:100px 0 0 0;
    }
    .product-filter{
        flex:2;
    }
    .products-container{
        display:grid;
        grid-template-columns: repeat(4,minmax(250px,1fr));
        flex:1;
        @media screen and (max-width:1400px){
            grid-template-columns: repeat(4,minmax(250px,1fr));
            grid-template-columns: repeat(auto-fit,minmax(250px,1fr));
        }
        margin:auto;
        gap:1rem;
        .product-card{
            border:1px solid black;
            padding:20px;
            display:flex;
            flex-direction: column;
            justify-content: space-between;
        }
    }

    .sidebar{
        flex:2;
    }
}
</style>