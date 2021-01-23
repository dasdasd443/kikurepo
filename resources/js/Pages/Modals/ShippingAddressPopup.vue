<template>
    <basic-modal-layout>
        <template #header>
            <h1>Shipping Address</h1>
            <button @click='$emit("closePopup")'>&times;</button>
        </template>
        <template #content>
            <div class="address-form">
                <form @submit.prevent="$emit('closePopup')" method='POST'>
                    <div class='form-group'>
                        <label for="shipping-name">First Name: </label>
                        <input type="text" id='shipping-first-name' :value='address.first_name'>
                    </div>
                    <br>
                    <div class='form-group'>
                        <label for="shipping-name">Last Name: </label>
                        <input type="text" id='shipping-last-name' :value='address.last_name'>
                    </div>
                    <br>
                    <div class='form-group'>
                        <label for="shipping-house-no">Address 1: </label>
                        <input type="text" id='shipping-address-1' :value='address.address_line1'>
                    </div>
                    <br>
                    <div class='form-group'>
                        <label for="shipping-street">Address 2: </label>
                        <input type="text" id='shipping-address-2' :value='address.address_line2'>
                    </div>
                    <br>
                    <div class='form-group city-form'>
                        <label for="shipping-city">City: </label>
                        <input type="text" id='shipping-city' :value='address.city'>
                        <label for="shipping-zip-code">Zip Code: </label>
                        <input type="text" id='shipping-zip-code' :value='address.zip_code'>
                    </div>  
                    <br>
                    <div class='form-group'>
                        <label for="shipping-propvince">Country: </label>
                        <input type="text" id='shipping-country' :value='address.country'>
                    </div>
                    <div class='submit-form'>
                        <button type='submit' @click.prevent='editAddress(address.address_id)'>Edit Address</button>
                    </div>
                </form>
            </div>
            <div class='edit-confirmation-container'>
                <div class='shipping-address-list-container'>
                    <h1>Here is a list of available shipping addresses</h1>
                </div>
                
            </div>
        </template>
    </basic-modal-layout>
        

</template>

<script>
import BasicModalLayout from './layouts/BasicModalLayout.vue'
export default {
    components: { BasicModalLayout },
    props:['address'],
    methods: {
        editAddress(address_id) {
            fetch(`/edit_address/${address_id}`,{
                headers:{
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                },
                method: 'PUT',
                body: JSON.stringify({
                    first_name: document.querySelector('#shipping-first-name').value,
                    last_name: document.querySelector('#shipping-last-name').value,
                    address_1: document.querySelector('#shipping-address-1').value,
                    address_2: document.querySelector('#shipping-address-2').value,
                    city: document.querySelector('#shipping-city').value,
                    zip_code: document.querySelector('#shipping-zip-code').value,
                    country: document.querySelector('#shipping-country').value,
                })
            }).then(response=> {
                location.reload();
            })
        }
    }
}
</script>

<style lang="scss" scoped>
.popup-container{
    background:white;
    width:50%;
    height:650px;
    overflow: scroll;
    margin: 100px auto;
    .popup-header{
        display:flex;
        justify-content: space-between;
        align-items: center;
        padding:20px;
        h1{
            font-size:36px;
        }
        
    }
    .popup-content{
        padding:50px;
        display:grid;
        grid-template-columns: repeat(2,1fr);
        grid-template-columns: repeat(2,minmax(300px,1fr));
        grid-template-columns: repeat(auto-fit,minmax(150px,1fr));
        .address-form{
            flex:1;
            .city-form{
                display:flex;
                width:50%;
                align-items: center;
                justify-content: space-between;
                width:100%;
                gap:1rem;
                 @media screen and (max-width:1400px){
                    display:grid;
                    grid-template-columns: repeat(4,minmax(100px,1fr));
                    grid-template-columns: repeat(auto-fit,minmax(100px,1fr));
                }
            }
            input{
                padding:5px;
                outline:1px solid black;
                font-size:15px;
                width:100%;
            }
            .submit-form{
                display:flex;
                justify-content:flex-end;
                button:focus{
                    outline:none;
                }
                button{
                    margin:20px 0 0 0;
                    justify-content: flex-end;
                    padding:5px;
                    transition:all .45s;
                    border-radius: 5px 5px 5px 5px;
                }
                button:hover{
                    background: grey;
                    color:white;
                }
            }
        }
        .edit-confirmation-container{
            flex:1;
            .shipping-address-list-container{
                padding:20px;
            }
        }
    }
}
@media screen and (max-width:1000px){
    .city-form{
        display:none;
        grid-template-columns: repeat(2,1fr);
        grid-template-columns: repeat(2,minmax(200px,1fr));
        grid-template-columns: repeat(auto-fit,minmax(150px,1fr));
    }
}
</style>