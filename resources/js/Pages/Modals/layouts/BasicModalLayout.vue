<template>
    <div class='popup'>
        <div class='popup-container'>
            <div class='popup-header'>
                <slot name="header"></slot>
                
            </div>
            <hr>
            <div class='popup-content'>
                <slot name="content"></slot>
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
    }
}
</style>