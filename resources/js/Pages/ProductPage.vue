<template>
    <app-layout>
        <template #content>
            <div class='product-details-container'>
                <div class='photos-container'>
                    <div class='display-photo'>
                        <div class='photo-collection' v-if='product_photos.length != 0'>
                            <div class='product-photo'>
                                    <div class="photo-display">
                                        <div :class="'photo photo-'+index" v-for='(photo,index) in product_photos' :key='photo.photo_id'>

                                            <img :src='"/storage/product_photos/"+product_details.photos_folder+"/" + photo.photo_name' alt="">
                                            <div class="photo-buttons">
                                                <button @click='changePhotoDisplay(index - 1)'>&#60;</button>
                                                <button @click='changePhotoDisplay(index + 1)'>&#62;</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                            </div>
                            <div class='photo-selectors'>
                                <div class="photos-selection" v-for='(photo,index) in product_photos' :key='photo.photo_id'>
                                    <img :class='`photo-thumbnail-${index}`' :src='"/storage/product_photos/"+product_details.photos_folder+"/" + photo.photo_name' alt="" @click='changePhotoDisplay(index)'>
                                </div>
                            </div>
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
                    <div class='product-buttons'>
                        <button v-if='product_details.product_stock > 0' class='add-to-cart-button active-add-button' @click='addToCart(product_details.product_id)'>Add to Cart</button>
                        <button v-else class='add-to-cart-button' disabled>Add to Cart</button>
                        <button class='add-to-wishlist-button active-add-button' @click='addToWishlist(product_details.product_id)'>Add to Wishlist</button>
                    </div>
                    <hr>
                    <div class='product-sub-description'>
                        <div class='description-text'>
                            <h1>Dimensions: {{`${product_details.product_length} x ${product_details.product_width} x ${product_details.product_height} inch`}}</h1>
                            <br>
                            <h1>Description: </h1>
                            <h1>{{product_details.product_description}}</h1>
                        </div>
                        <hr>
                    </div>
                    
                </div>
            </div>
            <hr>
        </template>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'

export default {
    data() {
        return {
            currentPhotoIndex: 0
        }
    },
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
        },
        changePhotoDisplay(index) {
            let newIndex = index;
            if(index < 0 )
            {
                newIndex = this.product_photos.length - 1;
            }
            else if(index == this.product_photos.length)
            {
                newIndex = 0;
            }

            document.querySelector(`.photo-${this.currentPhotoIndex}`).style.display = 'none';
            document.querySelector(`.photo-thumbnail-${this.currentPhotoIndex}`).style.border ='2px solid transparent';
            document.querySelector(`.photo-${newIndex}`).style.display ='flex';
            document.querySelector(`.photo-thumbnail-${newIndex}`).style.border ='2px solid grey';

            this.currentPhotoIndex = newIndex;
            
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
    margin: 20px auto;  
}
.product-details-container{
    width:70vw;
    display:grid;
    margin: 10vh auto;
    gap:5rem;
    grid-template-columns: repeat(2,1fr);
    grid-template-columns: repeat(2,minmax(300px,1fr));
    grid-template-columns: repeat(auto-fit,minmax(300px,1fr));
    .photos-container{
        flex: 1;
        .display-photo{
            display:grid;
            margin:auto;
            align-items: center;
            justify-content: center;
            .photo-collection{
                display:flex;
                flex-direction: column;
                .product-photo{
                    display:flex;  
                    .photo-display{
                        margin:auto;
                        position: relative;
                        .photo-buttons{
                            position:absolute;
                            display:flex;
                            justify-content: space-between;
                            align-items: center;
                            height:100%;
                            margin:auto;
                            width:100%;
                            button{
                                background-color:rgba(0,0,0,0.3);
                                padding:10px;
                                transition: all .45s;
                            }
                            button:hover{
                                background-color:rgba(0,0,0,0.6);
                            }
                            button:focus{
                                outline:none;
                            }
                        }
                        .photo:first-child{
                            display:flex;
                        }
                        .photo{
                            display:none;
                            box-shadow: 3px 3px 10px;
                            max-height:1000px;
                        }
                    }
                }
                .product-photo:{
                    display:none;
                }
                .photo-selectors{
                    display: flex;
                    margin:auto;    
                    justify-content: space-evenly;
                    padding:20px;
                    width:100%;
                    img{
                        flex:1;
                        height:50px;
                    }
                    .photos-selection{
                        border:2px solid transparent;
                        transition: all .3s;
                    }
                    .photos-selection:hover{
                        border:2px solid grey;
                    }
                }
            }
            
        }
    }
    .product-details{
        flex:2;
        .product-sub-description{
            padding:25px;
            .description-text{
                padding:10px 0 10px 0;
            }
        }
        .product-buttons{
            font-size:15px;
            display:grid;
            grid-template-columns: repeat(2,1fr);
            grid-template-columns: repeat(2,minmax(200px,1fr));
            grid-template-columns: repeat(auto-fit,minmax(200px,1fr));
            button{
                background:rgba(0,0,0,0.3);
                padding:15px 30px;
                box-shadow: 3px 3px rgba(0,0,0,0.1);
                width:200px;
                margin:10px auto;
                transition: all .3s;
            }
            button:focus{
                outline: 0;
            }
            .active-add-button:hover{
                background: rgba(0,0,0,0.7);
                color:white;
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
            gap: 2rem;
            h1:first-child{
                margin-right:auto;
            }
        }
    }
}
</style>