<template>
    <app-layout>

        <template #content>
            <div class='logo'>
                <h1 class='logo-title'>KIKU<small>
                    Trading Company</small></h1>
                
            </div>
        </template>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {
                products: []
            }
        },
        components: {
            AppLayout,
            Welcome,
        },
        computed:{
        },
        methods: {
            displayProducts() {
                axios.get('/api/products').then(response =>{
                    this.products = response.data
                });
            },
        },
        mounted(){
        }
    }
</script>

<style lang='scss' scoped>
.logo{
    display:grid;
    justify-content: center;
    align-items: center;
    -webkit-user-select: none; /* Safari */        
    -moz-user-select: none; /* Firefox */
    -ms-user-select: none; /* IE10+/Edge */
    user-select: none; /* Standard */  
    white-space:pre; 
    .logo-title{    
        background-image:linear-gradient(#393e464f 0%, #393e46 100%);
        background-clip: text;
        color:transparent;
        letter-spacing: 5vw;
        font-size:30vw;
        position:relative;  
        line-height:1.6;
        small{
            font-size:.05em;
            letter-spacing: 5px;
            line-height:1;
            position: absolute;
            left:0;
            top:0;
            color:black;
        }
    }
}
</style>
