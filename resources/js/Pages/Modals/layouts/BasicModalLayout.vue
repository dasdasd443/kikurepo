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
::-webkit-scrollbar{
    width: 0;
}
.popup-container{
    background:white;
    width:50%;
    height:650px;
    margin: 100px auto;
    overflow: scroll;
    .popup-header{
        display:flex;
        justify-content: space-between;
        align-items: center;
        padding:20px;
        background-color:#393e46;
        color:white;
        width:100%;
        h1{
            font-size:36px;
        }
        button:focus{
            outline:none;
        }
        button{
            justify-content: flex-end;
            align-items: center;
            font-size:36px;
            padding:20px;
            transition:all .45s;
            border-radius: 5px 5px 5px 5px;
        }
        button:hover{
            color:black;
        }
    }
    .popup-content{
        padding:50px;
        
    }
}
</style>