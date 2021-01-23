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
                        <h1>{{shipping_address.address_line1}}, 
                            {{shipping_address.address_line2}},
                            {{shipping_address.city}},
                            {{shipping_address.zip_code}}
                        </h1>
                    </div>
                    <hr>
                    <div class="billing-address">
                        <h1 class='address-title'>Billing Address</h1>
                        <h1>{{billing_address.address_line1}}, 
                            {{billing_address.address_line2}},
                            {{billing_address.city}},
                            {{billing_address.zip_code}}
                        </h1>
                    </div>
                </div>
                <div class='payment-container'>
                    <h1 class='payment-title'>Payment</h1>
                    <form @submit.prevent='checkoutPayment' class='card-form'>
                        <div class='form-group'>
                            <input type="text" id='card-fname' v-model='firstname'>
                            <label for="card-name">Cardholder's First name</label>
                        </div>
                        <div class='form-group'>
                            <input type="text" id='card-lname' v-model='lastname'>
                            <label for="card-name">Cardholder's Last name</label>
                        </div>
                        <div class='card-container'>

                        </div>
                        <button type='submit'>Proceed to checkout</button>
                    </form>
                    
                </div>
            </div>
        </template>
    </basic-modal-layout>
</template>

<script>
import BasicModalLayout from './layouts/BasicModalLayout.vue'
import {loadStripe} from '@stripe/stripe-js';

export default {
    components: { BasicModalLayout } ,
    data() {
        return {
            firstname: '',
            lastname: ''      
        }
    },
    props: ['totalPayment','billing_address','shipping_address'],
    methods: {
        async checkoutPayment() {
            var response = fetch('/secret', {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                },
                
                method: "POST",
                body: JSON.stringify({
                    payment: this.totalPayment
                })
            }).then(response => {
                return response.json();
            }).then(responseJson => {
                var clientSecret = responseJson.client_secret;
                // Call stripe.confirmCardPayment() with the client secret.
                return clientSecret;
            }).then(async clientSecret => {

                const elem = stripe.confirmCardPayment(clientSecret,{
                    payment_method: {
                        card: card,
                        billing_details: {
                            name: `${this.firstname} ${this.lastname}`,
                        }
                    }
                }).then(result => {
                    if(result.error){
                        console.log(result.error.message)
                    }else if (result.paymentIntent.status === 'succeeded') {
                        // Show a success message to your customer
                        // There's a risk of the customer closing the window before callback
                        // execution. Set up a webhook or plugin to listen for the
                        // payment_intent.succeeded event that handles any business critical
                        // post-payment actions.
                        console.log('success!')
                    }
                });
            });
        },
        async initializeStripe() {
            window.stripe = await loadStripe('pk_test_51HuvwMJuH4Qnm7aCsa9mHV7aZ35qE1VWrjy8kNJRWNQN5pO9Htexujc1tsx9LHnogJh9Etycko92DYTwABwHk2M100AF0sFJgI');
            const elements = stripe.elements()

            window.card = elements.create('card');

            const cardDiv = document.createElement('div');
            cardDiv.id = "card-element"
            document.querySelector('.card-container').appendChild(cardDiv);

            const errorDiv = document.createElement('div');
            errorDiv.id = "card-errors"
            document.querySelector('.card-container').appendChild(errorDiv);

            card.mount('#card-element');

            card.on('change', ({error}) => {
            let displayError = document.getElementById('card-errors');
            if (error) {
                displayError.textContent = error.message;
            } else {
                displayError.textContent = '';
            }
            });
        }
    },
    mounted() {
        this.initializeStripe();
    }
}
</script>

<style lang='scss' scoped>
.content-container{
    display:flex;
    gap:1rem;
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
        display:grid;
        gap:1rem;
        .payment-title{
            font-size:30px;
        }
        .card-form{
            display:grid;
            gap:1rem;
            .form-group{
                display:grid;
                input{
                    outline:1px solid rgba(0, 0, 0, 0.089);
                    padding:5px;
                }
            }
            .card-container{
                display:grid;
                gap:1rem;
                color:red;
            }
            button{
                background: #ebebeb63;
                transition:.45s all;
                padding:15px 0 15px 0;
            }
            button:focus{
                outline:none;
            }
            button:hover{
                box-shadow: 1px 1px 1px;
            }
        }
        #card-element{
            outline:1px solid black;
        }
    }
}
</style>