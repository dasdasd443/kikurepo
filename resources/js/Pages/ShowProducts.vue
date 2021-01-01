<template>
    <app-layout>
        <template #content>
            <div class="show-products-container">
                <div class='product-filters'></div>
                <div class='products-container' v-if='products.length > 0'>
                    <div class='product-card' v-for='n in products' :key='n.product_id'>
                        <a :href='"/product_details/" + n.product_id'>
                            <img src="/storage/product_photos/no-image.png" alt="product_image">
                        </a>
                        <div class='product-card-content'>
                            <a :href='"/product_details/" + n.product_id'>
                                <div class='product-details'>
                                    <h1>{{n.product_name}}</h1>
                                    <hr>
                                    <h1>Sold by: {{n.seller_name}}</h1>
                                    <h1>{{n.product_price}}</h1>
                                </div>
                            </a>
                            <div class='add-buttons'>
                                <button class='add-cart-button' @click='addToCart(n.product_id)'>Add to Cart</button>
                                <button class='add-wishlist-button' @click='addToWishlist(n.product_id)'>Add to Wishlist</button>
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
        ...mapActions(['displayProductsData']),
        addToCart(product_id) {
            console.log(product_id);
        },

        addToWishlist(product_id) {
            console.log(product_id);
        }
    },
    computed:{
        ...mapGetters(['productsData'])
    },
    props:['products'],
    created(){
        this.displayProductsData();
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
    grid-template-columns: repeat(1,minmax(240px,1fr));
    grid-template-columns: repeat(auto-fit,minmax(240px,1fr));
    .product-details{
        flex:1;
        padding:10px;
    }
    .add-buttons{
        flex: 1;
        display:flex;
        justify-content: space-between;
        align-items: center;
    }
    .add-cart-button,.add-wishlist-button{
        padding:10px;
        border:1px solid black;
        box-shadow: 5px black;
    }
}
.show-products-container{
    display:flex;
    margin: 10vh 0 0 0;
    .product-filters{
        flex:1;
    }
    .products-container{
        flex:4;
        display:grid;
        grid-template-columns: repeat(4,minmax(300px,1fr));
        
        @media screen and (max-width:1400px){
            grid-template-columns: repeat(4,minmax(200px,1fr));
            grid-template-columns: repeat(auto-fit,minmax(200px,1fr));
        }
        margin:auto;
        gap:4rem;
        .product-card{
            border:1px solid black;
            padding:20px;
        }
    }

    .sidebar{
        flex:1;
    }
}
</style>