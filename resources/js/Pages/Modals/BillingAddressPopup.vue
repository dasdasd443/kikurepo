<template>
    <div class='popup'>
        <div class='popup-container'>
            <div class='popup-header'>
                <h1>Billing Address</h1>
                <button @click='$emit("closePopup")'>Close</button>
            </div>
            <hr>
            <div class='popup-content'>
                <div class="address-form">
                    <form @submit.prevent="$emit('closePopup')" method='POST'>
                        <div class='form-group'>
                            <label for="name">Name: </label>
                            <input type="text" id='name'>
                        </div>
                        <br>
                        <div class='form-group'>
                            <label for="house-no">House No: </label>
                            <input type="text" id='house-no'>
                        </div>
                        <br>
                        <div class='form-group'>
                            <label for="street">Street: </label>
                            <input type="text" id='street'>
                        </div>
                        <br>
                        <div class='form-group city-form'>
                            <label for="city">City: </label>
                            <input type="text" id='city'>
                            <label for="zip-code">Zip Code: </label>
                            <input type="text" id='zip-code'>
                        </div>  
                        <br>
                        <div class='form-group'>
                            <label for="propvince">Province: </label>
                            <input type="text" id='province'>
                        </div>
                        <div class='submit-form'>
                            <button type='submit'>Edit Address</button>
                        </div>
                    </form>
                </div>
                <div class='edit-confirmation-container'>
                    <div class='billing-address-list-container'>
                        <h1>Here is a list of available billing addresses</h1>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    
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
        button:focus{
            outline:none;
        }
        button{
            justify-content: flex-end;
            align-items: center;
            padding:5px;
            transition:all .45s;
            border-radius: 5px 5px 5px 5px;
        }
        button:hover{
            background: grey;
            color:white;
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
            .billing-address-list-container{
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