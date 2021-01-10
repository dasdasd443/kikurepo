<template>
    <app-layout>
        <template #content>
            <div class='product-details-container'>
                <div class='photos-container'>
                    <div class='display-photo'>
                        <div class='photo-collection' v-if='product_photos.length != 0'>
                            <button>X</button>
                            <img v-for='photo in product_photos' :key='photo.photo_id' :src='"/storage/product_photos/"+product_details.photos_folder+"/" + photo.photo_name' alt="">
                            <button>Y</button>
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
                        <h1>{{(product_reviews.average > 0)? product_reviews.average: 0}} out of 5 stars</h1>
                        <h1>{{product_reviews.count}} {{(product_reviews.count > 1)?'Reviews':'Review'}}</h1>
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
                            <h1>{{product_details.product_description}}</h1>
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
                {{product_details.product_details}}
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
                location.href = "javascript:history.back()"
            })
            
        },
        addToWishlist(product_id) {
            console.log(product_id)
        }
    },
    props:['product_details','product_photos','product_reviews']
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
        .display-photo{
            width:70%;
            height:70%;
            margin:auto;
            align-items: center;
            .photo-collection{
                display:flex;
            }
        }
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