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
    .logo-title{    
        background-image:linear-gradient(#393e464f 0%, #393e46 100%);
        background-clip: text;
        color:transparent;
        letter-spacing: 5vw;
        font-size:30vw;
        position:relative;  
        small{
            font-size:20px;
            letter-spacing: 5px;
            line-height:1px;
            position: relative;
            color:black;
            top:10;
            z-index: 1111;
        }
    }
}
</style>
