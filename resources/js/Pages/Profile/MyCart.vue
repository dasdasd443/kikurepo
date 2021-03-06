<template>
    <app-layout>
        <template #content>
            <div class='my-cart'>
                <div id='show-orders' class='my-cart-container' v-if='sumCartOrders(cart_details)'>
                    <div v-for='(product,index) in cart_details' :key='product[0].product_id'>
                        <div class='message' :id='`message-item-${index}-container`'>
                            <h1 :id ='`message-item-${index}`'></h1>
                        </div>
                        <div class='card' v-if='product[1] > 0' :id='"item-no"+index'>
                            <div class='image'>
                                <img :src='"/storage/product_photos/"+product[0].photos_folder+"/" + product[2][0].photo_name' alt="" v-if='product[2].length!=0'>
                                <img v-else src="/storage/product_photos/no-image.png" alt="">
                            </div>
                            <div class='product-information'>
                                <h1><a :href='"/product_details/"+product[0].product_id'>{{product[0].product_name}}</a></h1>
                                <div class='quantity-container'>
                                    <h1 >Qty:</h1>
                                    <form>
                                        <input @change='changeQuantity(index,product[0].product_price)' :id='`cart_no`+index' type="number" :value='product[1]'>
                                    </form>
                                </div>
                            </div>
                            <div class='product-price'>
                                <h1 :id='"product-price-"+index'>{{product[0].product_price * product[1]}}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='my-cart-container dont-show-orders' v-else>
                    <div class='text-container'>
                        <h1>Empty Cart!</h1>
                        <br>
                        <span>Looking to buy an item? Click <a href="/">here</a> to start shopping!</span>
                    </div>
                    <div class='no-cart-logo-container'>
                        <h1>Logo Here</h1>
                    </div>
                </div>
                <div class='checkout-container' v-if='sumCartOrders(cart_details)'>
                    <div class='error-checkout'>
                        <h1 id='error-checkout-message'>Test</h1>
                        <button onclick='this.parentElement.style.display="none"'>&times;</button>
                    </div>
                    <div class='checkout'>
                        <div class='addresses'>
                            <h1>Shipping Address</h1>
                            <div class='shipping-address'>
                                <h1>{{addresses.shipping_address.address_line1}}, 
                                    {{addresses.shipping_address.address_line2}}, 
                                    {{addresses.shipping_address.city}}, 
                                    {{addresses.shipping_address.zip_code}}, 
                                    {{addresses.shipping_address.country}}</h1>
                                <button @click='editAddress(".ShippingAddress")'>Edit</button>
                            </div>
                            <h1>Billing Address</h1>
                            <div class='billing-address'>
                                <h1>{{addresses.billing_address.address_line1}}, 
                                    {{addresses.billing_address.address_line2}}, 
                                    {{addresses.billing_address.city}}, 
                                    {{addresses.billing_address.zip_code}}, 
                                    {{addresses.billing_address.country}}</h1>
                                <button @click='editAddress(".BillingAddress")'>Edit</button>
                            </div>
                        </div>
                        <hr>
                        <div class='available-shippers'>
                            <div class='shippers-title-container'>
                                <h1>Available Shippers</h1>
                                <h1>Shipping Cost</h1>
                            </div>
                            <br>
                            <div class='shipper-options-container'>
                                <select name="shipper" v-model='selected_shipper' @change='changeShipper'>
                                    <option :value='shippers' v-for='shippers in available_shippers' :key='shippers.shipping_id'>
                                        {{shippers.shipper_name}}
                                    </option>
                                </select>
                                <h1 :key='shipping_costs_key'>{{shipping_costs}}</h1>
                            </div>
                        </div>
                        <hr>
                        <div class='order-summary'>
                            <h1>Order Summary</h1>
                            <div class='summary-details'>
                                <div id='subtotal'>
                                    <h1>Subtotal</h1>
                                    <h1>{{getTotalPrice()}}</h1>
                                </div>
                                <div id='shipping-fee'>
                                    <h1>Shipping Fee</h1>
                                    <h1>{{shipping_costs}}</h1>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='checkout-section' :key="checkoutKey">
                            <div class='total-price-section'>
                                <button class='checkout-button' @click='checkoutPayment'>Checkout</button>
                                <h1 class='total-price'>{{sub_total + shipping_costs}}</h1>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <ShippingAddressPopup @closePopup='closePopup' :class='"ShippingAddress popup"' :address='addresses.shipping_address'/>
                <BillingAddressPopup @closePopup='closePopup' :class='"BillingAddress popup"' :address='addresses.billing_address'/>
                <CheckoutModal @closePopup='closePopup' :class='"Checkout popup"' :totalPayment='sub_total+shipping_costs' :billing_address='addresses.billing_address' :shipping_address='addresses.shipping_address'/>
            </div>
            
        </template>
    </app-layout>    
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import ShippingAddressPopup from '@/Pages/Modals/ShippingAddressPopup.vue'
import BillingAddressPopup from '@/Pages/Modals/BillingAddressPopup.vue'
import CheckoutModal from '@/Pages/Modals/CheckoutModal.vue'

export default {
    data() {
        return {
            cart_products: '',
            product_quantity: 0,
            checkoutKey: 0,
            available_shippers: 0,
            selected_shipper: 0,
            shipping_costs: 0,
            package_type: '',
            shipping_costs_key: 0,
            sub_total: this.getTotalPrice()
        }
    },
    components: { AppLayout , ShippingAddressPopup, BillingAddressPopup, CheckoutModal},
    props:['cart_details','cart_cookie','addresses'],
    mounted() {
        this.cart_products = this.cart_details,
        this.getShippers(),
        this.calculatePackageDimensions()
    },
    methods: {

        //calculates the price based on the shipper being selected

        changeShipper() {
            if(this.selected_shipper != 0){
                switch(this.package_type){
                    case "Large": this.shipping_costs = this.selected_shipper.large_cargo_rate;break;
                    case "Medium": this.shipping_costs = this.selected_shipper.medium_cargo_rate;break;
                    case "Small": this.shipping_costs = this.selected_shipper.small_cargo_rate;break;
                }
            }else{
                this.shipping_costs = 0;
            }

            console.log(this.shipping_costs)
        },

        //calculates the total dimensions of all packages from the cart and determines if the cargo is
        //large medium or small

        calculatePackageDimensions(){
            const totalPackageLength = this.cart_products.reduce( (total, item) => {
                return total + (item[0].product_length * item[1]);
            },0);

            const totalPackageWidth = this.cart_products.reduce( (total, item) => {
                return total + (item[0].product_width * item[1]);
            },0);

            const totalPackageHeight = this.cart_products.reduce( (total, item) => {
                return total + (item[0].product_height * item[1]);
            },0);

            const volume = totalPackageLength * totalPackageWidth * totalPackageHeight

            if(volume >= 1500){
                this.package_type = "Large"
            }else if(volume >= 500){
                this.package_type = "Medium"
            }else{
                this.package_type = "Small"
            }
        },

        //gets the total price of each item, price * quantity

        getTotalPrice:function() {
            if(this.cart_details) {
                return this.sub_total = this.cart_details.reduce((total_val,current) => {
                    return total_val + (current[0].product_price * current[1])
                },0)
            }

        },

        //gets the amount of items ordered (quantity)

        sumCartOrders(cart) {
            if(cart) {
                return cart.reduce( (total,item) => {
                    return total + item[1]
                }, 0)
            }
        },

        //changes the amount of the quantity of an item order
        //removes the item if the quantity changed to 0
        //updates the quantity value on the cart cookie
        //updates the sub total and the shipping cost

        changeQuantity(index,price) {
            const quantity_value = document.querySelector(`#cart_no`+index).value;
            const date = new Date();

            this.cart_cookie[index].quantity = quantity_value;

            this.cart_products[index][1] = quantity_value;

            document.cookie = `cart_orders=${JSON.stringify(this.cart_cookie)};expires=`+ date.setTime(date.getTime() + 7 * 24 * 60 * 60 * 1000) + `;path=/`
            
            document.querySelectorAll('.message').forEach(elem => {
                elem.style.display = 'none';
            });

            if(quantity_value == 0) {
                document.querySelector(`#item-no${index}`).style.display = 'none';

                const elem = document.querySelector(`#message-item-${index}-container`).style
                elem.display = 'flex'
                elem.background='lightgreen'
                
                document.querySelector(`#message-item-${index}`).innerHTML = "Item removed"
            }

            if(this.sumCartOrders(this.cart_details) == 0){
                document.cookie = `cart_orders=0;expires=`+ new Date(0,0,0) + `;path=/`
            }

            this.checkoutKey+=1;
            this.calculatePackageDimensions()
            this.getTotalPrice()
            this.changeShipper()
        },

        //edits the address depending on which type of address is being passed on the parameter (billing or shipping)

        editAddress(address) {
            document.querySelector(address).style.display='block';
        },

        //function that closes all popup modals

        closePopup() {
            document.querySelectorAll('.popup').forEach(elem => {
                elem.style.display='none';
            });
        },

        //function for checkout modal

        checkoutPayment() {
            if(this.selected_shipper != 0){
                document.querySelector(".Checkout").style.display='block';
            }else{
                document.querySelector("#error-checkout-message").innerHTML = "Select a shipper";
                document.querySelector(".error-checkout").style.display = "flex";
            }
        },

        //gets all the available shippers
        async getShippers() {
            const response = await axios.get('/api/shippers');

            this.available_shippers =  response.data;
        }

    },
        
}
</script>

<style lang='scss' scoped>
.error-checkout{
    display:none;
    justify-content: space-between;
    align-items: center;
    margin: 0 0 10px 0;
    border-radius: 0 5px 0 0;
    background-color:rgba(250, 0, 0, 0.363);
    button{
        padding:5px;
        font-size:20px;
    }
    h1{
        padding:5px;
    }
}
.message{
    display:none;
    justify-content: center;
    align-items: center;
    margin:auto;
    padding:10px;
    width:100%;
}
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
.available-shippers{
    .shippers-title-container{
        display:flex;
        justify-content: space-between;
        h1{
            font-size:20px;
        }
    }
    .shipper-options-container{
        padding:10px 0 10px 0;
        display:flex;
        justify-content: space-between;
        align-items: center;
        select{
            padding: 10px 0 10px 0;
        }
        select:focus{
            outline:none;
        }

    }
}
.dont-show-orders{
    display:grid;
    width:70vw;
    background:white;
    margin:auto;
    align-items: center;
    padding:50px;
    grid-template-columns: repeat(2,1fr);
    grid-template-columns: repeat(2,minmax(300px,1fr));
    grid-template-columns: repeat(auto-fit,minmax(300px,1fr));
    .text-container{
        h1 {
            font-size: 50px;
        }
    }
    .no-cart-logo-container{
        display: flex;
        justify-content: flex-end;
    }

}
.my-cart{
    display:flex;   
    gap:1rem;
    width:80vw;
    margin:50px auto;
    @media screen and (max-width:1000px){
        display:grid;
        grid-template-columns: repeat(2, 1fr);
        grid-template-columns: repeat(2,minmax(400px,1fr));
        grid-template-columns: repeat(auto-fit,minmax(400px,1fr));
    }
    .checkout-container{
        flex:1;
        .checkout{
            width:100%;
            padding:25px;
            border:1px solid black;
            background:white;
            .addresses{
                gap:1rem;
                h1{
                    padding: 0 0 10px 0;
                }
            }
            .checkout-section{
                display:grid;
                font-size:20px;
                .total-price-section{
                    margin-top:20px;
                    display:flex;
                    flex:3;
                    justify-content: space-between;
                    .total-price{
                        padding:25px 0 25px 25px;
                    }
                }
                .checkout-button{
                    padding:25px 40px 25px 40px;
                    background: #ebebeb63;
                    transition: all .45s;
                    border-radius: 10px 0 0 0;
                    
                }
                .checkout-button:hover, .checkout-button:focus{
                        box-shadow: 1px 1px 1px;
                        outline: none;
                }
            }
            .shipping-address, .billing-address{
                display:flex;
                justify-content: space-between;
                gap:1rem;
                align-items: center;
                button:focus{
                    outline:none;
                }
                padding:0 0 25px 0;
            }
            .order-summary{
                .summary-details{
                    #subtotal{
                        display:flex;
                        align-items: center;
                        justify-content: space-between;
                    }
                    #shipping-fee{
                        display:flex;
                        align-items: center;
                        justify-content: space-between;
                    }
                }
            }
        }
    }
    .my-cart-container{
        flex:2;
        width:100%;
        display:grid;
        gap:1rem;
        .card{
            box-shadow: 1px 1px 3px;
            display:flex;
            background:white;
            .image{
                flex:1;
                width:200px;
                height:200px;
                display:flex;
                align-items: center;
                justify-content: center;
                img{
                    padding:25px;
                }
            }
            .product-information{
                flex:3;
                display:flex;
                align-items: center;
                font-size: 20px;
                padding:20px;
                h1{
                    padding:25px;
                    flex:2;
                }
                .quantity-container{
                    flex:1;
                    display:flex;
                    align-items: center;
                    input{
                        width:40px;
                        padding:5px;
                        border-radius: 5px 5px 5px 5px;
                        box-shadow: 1px 1px 1px;
                        text-align: center;
                    }
                    input:focus{
                        outline: none;
                    }
                    input::-webkit-outer-spin-button,
                    input::-webkit-inner-spin-button {
                        -webkit-appearance: none;
                        margin: 0;
                    }
                }
            }
            .product-price{
                flex:1;
                display:flex;
                align-items: center;
                justify-content: center;
                #price{
                    font-size:30px;
                }
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
}
</style>