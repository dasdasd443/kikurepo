<template>
    <basic-modal-layout>
        <template #header>
            <h1>Hello I am the title</h1>
            <button @click='$emit("closePopup")'>Close</button>
        </template>
        <template #content>
            <h1>And I am the content</h1>
        </template>
    </basic-modal-layout>
</template>

<script>
import BasicModalLayout from './layouts/BasicModalLayout.vue'

export default {
    components: { BasicModalLayout }    
}
</script>

<style lang='scss' scoped>

</style>