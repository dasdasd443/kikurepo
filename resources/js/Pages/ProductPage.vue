<template>
    <app-layout>
        <template #content>
            <div class='product-details-container'>
                <div class='photos-container'>
                    <div class='display-photo'>
                        <div class='photo-collection' v-if='product_photos.length != 0'>
                            <img v-for='photo in product_photos' :key='photo.photo_id' :src='"/storage/product_photos/"+product_details.photos_folder+"/" + photo.photo_name' alt="">
                        </div>
                        <div v-else>
                            <img src="/storage/product_photos/no-image.png" alt="no-product-image">
                        </div>
                    </div>
                    <div class='photo-selector'>

                    </div>
                </div>
                <div class='product-details'>
                    <h1 id='product-name'>{{product_details.product_name}}</h1>
                    <span v-if='product_details.product_sku != "0"'>
                        <span>#{{product_details.product_sku}}</span>
                    </span>
                    <span v-else>SKU Unavailable</span>
                    <hr>
                    <div class='product-sub-details'>
                        <h1>Sold by: Kiku Trading Company</h1>
                        <h1>4 out of 5 stars</h1>
                        <h1>136 Reviews</h1>
                    </div>
                    <div class='product-price-details'>
                        <h1 v-if='product_details.product_stock > 0'>
                            In stock <h1 v-if='product_details.product_stock < 10'>Only {{product_details.product_stock}} left!</h1>
                        </h1>
                        <h1 v-else>Out of stock</h1>
                        <h1 id='product-price'>P {{product_details.product_price}}</h1>
                    </div>
                    <hr>
                    <div class='product-sub-description'>
                        <div class='description-text'>
                            <h1>hello there i am description</h1>
                        </div>
                        <hr>
                        <a href="#products-description-container">>See more about this product</a>
                    </div>
                    <div class='product-buttons'>
                        <button id='add-to-cart-button' @click='addToCart(product_details.product_id)'>Add to Cart</button>
                        <button id='add-to-wishlist-button' @click='addToWishlist(product_details.product_id)'>Add to Wishlist</button>
                    </div>
                </div>
            </div>
            <hr>
            <div class='products-description-container' id='products-description-container'>
                Hello i am description
            </div>
        </template>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'

export default {
    components: {
        AppLayout
    },
    methods: {
        addToCart(product_id) {
            
            const cookies_split = document.cookie.split(';')
            const cart_orders_cookie = cookies_split.filter(id => {
                 return id.split('=')[0]==='cart_orders'
            })

            console.log(cart_orders_cookie);

            //if there is an existing cookie for cart orders
            if(cart_orders_cookie.length > 0)
            {
                // new date instance
                const date = new Date()

                //get cookies for cart orders
                const get_cart_orders = JSON.parse(cart_orders_cookie[0].split('=')[1])

                //if the current product is found on the existing cookie
                const isFound = get_cart_orders.find((cart_item) => {
                    return cart_item.product_id == product_id
                })

                //if the order is found on the existing cart orders in cookies
                if(isFound)
                {
                    get_cart_orders.map(cart_item => {
                        if (cart_item.product_id === product_id)
                            cart_item.quantity++
                            console.log(document.cookie)
                    })

                    //set the cookie and give it to /my_cart route
                    //document.cookie = `cart_orders=${JSON.stringify(get_cart_orders)};expires=`+ date.setTime(date.getTime() + 7 * 24 * 60 * 60 * 1000) + `;path=/`
                    document.cookie = `cart_orders=${JSON.stringify(get_cart_orders)};expires=`+ date.setTime(date.getTime() + 7 * 24 * 60 * 60 * 1000) + `;path=/`
                }

                //if the order is not found on the existing cart orders in cookies
                else
                {
                    const cart_order = {
                        product_id,
                        quantity: 1
                    }

                    //set the cookie and give it to /my_cart route
                    get_cart_orders.push(cart_order)
                    //document.cookie = `cart_orders=${JSON.stringify(get_cart_orders)};expires=`+ date.setTime(date.getTime() + 7 * 24 * 60 * 60 * 1000) + `;path=/my_cart`
                    document.cookie = `cart_orders=${JSON.stringify(get_cart_orders)};expires=`+ date.setTime(date.getTime() + 7 * 24 * 60 * 60 * 1000) + `;path=/`
                }
            }
            //if there are no existing cart orders
            else
            {
                console.log('yes');
                const date = new Date();
                const new_cart_order = [
                    {product_id,quantity: 1}
                ]
                
                //set the cookie and give it to /my_cart route
                //document.cookie = `cart_orders=${JSON.stringify(new_cart_order)};expires=`+ date.setTime(date.getTime() + 7 * 24 * 60 * 60 * 1000) + `;path=/my_cart`
                document.cookie = `cart_orders=${JSON.stringify(new_cart_order)};expires=`+ date.setTime(date.getTime() + 7 * 24 * 60 * 60 * 1000) + `;path=/`
            }
            
        },
        addToWishlist(product_id) {
            console.log(product_id)
        }
    },
    props:['product_details','product_photos']
}
</script>

<style lang="scss" scoped>
.products-description-container{
    width:70vw;
    margin: 10vh auto;
}
.product-price-details{
    margin: 50px auto;  
}
.product-details-container{
    width:70vw;
    display:grid;
    margin: 10vh auto;
    gap:3rem;
    grid-template-columns: repeat(2,1fr);
    grid-template-columns: repeat(2,minmax(300px,1fr));
    grid-template-columns: repeat(auto-fit,minmax(300px,1fr));
    .photos-container{
        flex: 1;
    }
    .product-details{
        flex:2;
        .product-sub-description{
            padding:50px;
            .description-text{
                padding:20px 0 20px 0;
            }
        }
        .product-buttons{
            font-size:30px;
            display:grid;
            gap:4rem;
            grid-template-columns: repeat(2,1fr);
            grid-template-columns: repeat(2,minmax(240px,1fr));
            grid-template-columns: repeat(auto-fit,minmax(240px,1fr));
            button{
                padding:20px;
                box-shadow: 3px 3px rgba(0,0,0,0.1);
                border-radius: 3px 3px 3px 3px;
            }
            button:focus{
                outline: 0;
            }
            #add-to-cart-button
            {
                background-image: linear-gradient(90deg, #fdcc0d 0%, rgba(255, 208, 0, 0.787) 100%);
            }
            #add-to-wishlist-button
            {
                background-image: linear-gradient(90deg, #fd950d 0%, rgba(255, 157, 0, 0.787) 100%);
            }
        }
        #product-name{
            font-size:36px;
        }
        #product-price{
            font-size: 32px;
        }
        .product-sub-details{
            display:flex;
            gap: 1rem;
            h1:first-child{
                margin-right:auto;
            }
        }
    }
}
</style>