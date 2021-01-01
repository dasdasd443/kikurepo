<template>
    <app-layout>

        <template #content>
            <div v-for='n in products' :key='n.product_id'>
                {{n.product_name}}
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
            this.displayProducts();
        }
    }
</script>

<style lang='scss' scoped>

</style>
