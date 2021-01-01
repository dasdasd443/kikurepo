<template>
    <app-layout>
        <template #content>
            {{error}}
        </template>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
export default {
    components:{
        AppLayout
    },
    props:['error']
}
</script>

<style lang="scss" scoped>

</style>