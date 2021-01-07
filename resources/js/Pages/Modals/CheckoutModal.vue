<template>
    <basic-modal-layout>
        <template #header>
            <h1>Checkout</h1>
            <button @click='$emit("closePopup")'>&times;</button>
        </template>
        <template #content>
            <div class='content-container'>
                <div class='address-container'>
                    <div class="shipping-address">
                        <h1 class='address-title'>Shipping Address</h1>
                        <h1>MAKAI's Dorm Gov M. Cuenco Ave Talamban Cebu City Cebu 6000</h1>
                    </div>
                    <hr>
                    <div class="billing-address">
                        <h1 class='address-title'>Billing Address</h1>
                        <h1>MAKAI's Dorm Gov M. Cuenco Ave Talamban Cebu City Cebu 6000</h1>
                    </div>
                </div>
                <div class='payment-container'>
                    <h1>Payment</h1>
                    <button @click='checkoutPayment'>Proceed to checkout</button>
                </div>
            </div>
        </template>
    </basic-modal-layout>
</template>

<script>
import BasicModalLayout from './layouts/BasicModalLayout.vue'

export default {
    components: { BasicModalLayout } ,
    props: ['totalPayment'],
    methods: {
        checkoutPayment() {
            var response = fetch('/secret').then(function(response) {
                return response.json();
            }).then(function(responseJson) {
                var clientSecret = responseJson.client_secret;
                // Call stripe.confirmCardPayment() with the client secret.
                console.log(clientSecret)
            });
        }
    },
    mounted() {
    }
}
</script>

<style lang='scss' scoped>
.content-container{
    display:flex;
    align-items: center;
    .address-container{
        flex:1;
        h1{
            padding:10px;
        }
        .address-title{
            font-size:30px;
        }
    }
    .payment-container{
        flex:1;
    }
}
</style>