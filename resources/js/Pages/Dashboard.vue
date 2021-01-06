<template>
    <app-layout>

        <template #content>
            Hello and Welcome
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

</style>
