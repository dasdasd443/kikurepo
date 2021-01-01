<template>
    <app-layout>
        <template #content>
            <div class='my-cart-container' v-if='cart_details != 0'>
                <div class='card' v-for='(product,index) in cart_details' :key='product[0].product_id'>
                    <div class='image'>
                        <img :src='"/storage/product_photos/"+product[0].photos_folder+"/" + product[2][0].photo_name' alt="" v-if='product[2].length!=0'>
                        <img v-else src="/storage/product_photos/no-image.png" alt="">
                    </div>
                    <div class='product-information'>
                        <h1>{{product[0].product_name}}</h1>
                        <h1 >Quantity:
                            <form>
                                <input @change='changeQuantity(index)' :id='`cart_no`+index' type="number" :value='product[1]'>
                            </form>
                        </h1>
                    </div>
                    <div class='product-price'>
                        <h1>Price = {{product[0].product_price * product[1]}}</h1>
                    </div>
                </div>
                <div class='total-price-container'>
                    <h1>{{getTotalPrice()}}</h1>
                </div>
            </div>
            <div class='my-cart-container' v-else>
                <h1>You have no orders</h1>
            </div>
        </template>
    </app-layout>    
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'

export default {
    data() {
        return {
            cart_products: '',
            product_quantity: 0
        }
    },
    components: { AppLayout },
    props:['cart_details','cart_cookie'],
    mounted() {
        this.cart_products = this.cart_details
    },
    methods: {
        getTotalPrice:function() {
            let total = this.cart_details.reduce((total_val,current) => {
                return total_val + (current[0].product_price * current[1])
            },0)

            return total;
        },
        changeQuantity(index) {
            const quantity_value = document.querySelector(`#cart_no`+index).value;
            const date = new Date();

            this.cart_cookie[index].quantity = quantity_value;

            this.cart_products[index][1] = quantity_value;

            document.cookie = `cart_orders=${JSON.stringify(this.cart_cookie)};expires=`+ date.setTime(date.getTime() + 7 * 24 * 60 * 60 * 1000) + `;path=/`
        },
        
    },
        
}
</script>

<style lang='scss' scoped>
    .my-cart-container{
        width:70vw;
        display:grid;
        margin:250px auto;
        gap:2rem;
        .card{
            border:1px solid grey;
            box-shadow: 1px 1px 3px;
            display:flex;
            .image{
                flex:1;
                width:250px;
                height:250px;
                display:flex;
                align-items: center;
                justify-content: center;
                img{
                    padding:25px;
                }
            }
            .product-information{
                flex:3;
            }
            .product-price{
                flex:1;
            }
            
        }
    }
    @media screen and (max-width:1000px){
                .my-cart-container .card{
                    display:grid;
                    grid-template-columns: repeat(2, 1fr);
                    grid-template-columns: repeat(2, minmax(240px,1fr));
                    grid-template-columns: repeat(auto-fit, minmax(300px,1fr));
                }
            }
</style>