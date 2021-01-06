<template>
    <div class='popup'>
        <div class='popup-container'>
            <h1>Hello I am the real Popup</h1>
            <button @click='$emit("closePopup")'>Close</button>
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
    height:50vh;
    width:50%;
    margin:250px auto;
}
</style>