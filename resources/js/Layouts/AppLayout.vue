<template>
    <div>
        
        <!-- Page Heading -->
        <!--<header class="bg-white shadow">
                <slot name="header"></slot>
        </header>-->

        <header class='header shadow'>
            <nav class='header-container'>
                <div class='title-container'>
                    <h2><inertia-link href='/'>Kiku Trading Company</inertia-link></h2>
                </div>
                <div class='search-container'>
                    <form action="GET" @submit.prevent='search'>
                        <label for="search-text"><button class='category-button'>All</button></label>
                        <input type="text" id='search-text' placeholder='Search for a product'>
                        <button type='submit' class='search-button'>Search</button>
                    </form>
                </div>
                <div class='user-container'>
                    <div class='account-details' @mouseover="displayAccountDiv" @mouseleave='notDisplayAccountDiv'>
                        <h1>My account</h1>
                        <div class='account-target'>
                            <div v-if='user_data'>
                                <span>Account Details</span>
                                <span v-if='user_data.user_type == "User"'>My orders</span>
                                <span v-if='user_data.user_type == "Seller"' @click='store'>My Store</span>
                                <span v-if='user_data.user_type == "Admin"'>Manage Accounts</span>
                                <span @click='logout'>Logout</span>
                            </div>
                            <div v-else>
                                <span @click='register'>Register</span>
                                <span @click='login'>Login</span>
                            </div>
                        </div>
                    </div>
                    <h1><a href="/user/my_cart">My Cart</a></h1>
                </div>
            </nav>
        </header>
        <div class='bg-white shadow categories-container'>
            <h1>Browse by Categories: </h1>
            <div class='category-list'>
                <h1 v-for='category in static_categories' :key='category.name'>
                    <a :href='"/browse/" + category.value'>
                        {{category.name}}
                    </a>
                </h1>
            </div>
        </div>

        <!-- Page Content -->
        <main>
            <slot name="content"></slot>
        </main>

        <!-- Modal Portal -->
        <portal-target name="modal" multiple>
        </portal-target>
    </div>
</template>

<script>
    import JetApplicationMark from '@/Jetstream/ApplicationMark'
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'
    import JetNavLink from '@/Jetstream/NavLink'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'

    export default {
        components: {
            JetApplicationMark,
            JetDropdown,
            JetDropdownLink,
            JetNavLink,
            JetResponsiveNavLink,
        },

        data() {
            return {
                showingNavigationDropdown: false,
                user_data: false,
                categories: [],
                static_categories: [
                    {name: "Mirrors", value: "mirrors"},
                    {name: "Furnitures", value: "furnitures"},
                    {name: "Bedroom", value: "bedroom"},
                    {name: "Kitchen and Dining", value: "kitchen-and-dining"},
                    {name: "Musical Instruments", value: "musical-instruments"},
                    {name: "Jars and Vases", value: "jars-and-vases"},
                    {name: "Arts and Decorative Items", value: "arts-and-decorative-items"},
                    {name: "Clocks", value: "clocks"},
                    {name: "Antiques", value: "antiques"},
                    {name: "Dolls and Figurative Items", value: "dolls-and-figurative-items"},
                ]
            }
        },

        methods: {
            

            //Web routes
            logout() {
                axios.post(route('weblogout').url()).then(response => {
                    window.location = route('/').url();
                });
            },
            login() {
                axios.get(route('login').url()).then(response => {
                    window.location = route('login').url();
                });
            },
            register() {
                axios.get(route('register').url()).then(response => {
                    window.location = route('register').url();
                });
            },
            store() {
                axios.get(route('store').url()).then(response => {
                    window.location = route('store').url();
                });
            },
            //Request for categories

            async getCategories(){
                const response = await axios.get(route('getCategories').url());

                this.categories = response.data;
            },

            //Request for user details
            requestUser() {
                axios.get(route('user').url()).then(response =>{
                    this.user_data = response.data;
                    //console.log(this.user_data);
                });
                
            },

            //hover effect of My Account element
            displayAccountDiv(){
                let account = document.querySelector('.account-target').style;
                account.opacity =  '1';
            },
            notDisplayAccountDiv(){
                let account = document.querySelector('.account-target').style;
                account.opacity =  '0';
            }
        },
        mounted() {
            this.requestUser();
            this.getCategories();
        }
    }
</script>
<style>
*{
    scroll-behavior: smooth;    
}
::-webkit-scrollbar{
    width:10px;
}
::-webkit-scrollbar-thumb{
    background-image: linear-gradient(0deg, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0.9) 100%);
}

</style>
<style lang='scss' scoped>
body{
    background: #f7f7f7; 
}
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Roboto';
    }
    .category-list{
        display:flex;
        gap:1rem;
        align-items: center;
        justify-content: space-between;
        h1{
            cursor:pointer;
        }
    }
    .categories-container{
        display:flex;
        align-items: center;
        gap:1rem;
        overflow-x:hidden;
    }
    .header-container{
        display:flex;
        font-size:20px;
        height: 100px;
        z-index: 2;
        background: #393e46; 
        color:white;
        .title-container{
            display:flex;
            flex:1;
            align-items: center;
            justify-content: center;
            font-size: 25px;
        }
        .search-container{
            display:flex;
            flex:3;
            align-items: center;
            justify-content: center;
            color:black;
            form{
                font-size: 15px;
                display:flex;
                justify-content: center;
                align-items: center;
                width:100%;
                #search-text{
                    width:60%;
                    padding: 5px;
                }
                button{
                    background: white;
                    border:1px solid black;
                    padding: 5px 25px 5px 25px;
                }
                input:focus, button:focus{
                    outline: 0;
                }
            }
        }
        .user-container{
            flex: 1;
            display:flex;
            align-items:center;
            justify-content: space-evenly;
            .account-details{
                position:relative;
                h1{
                    cursor: pointer;
                }
                .account-target{
                    display:block;
                    opacity:0;
                    border:1px solid grey;
                    transition:all .3s;
                    hr{
                        border-color:black;
                        width: 100%;
                        margin: 10px 0 10px 0;
                    }
                    position: absolute;
                    z-index: 2;
                    background-color:rgba(255,255,255,1);
                    color:black;
                    margin: 2px 0 0 -95px;
                    border-radius: 5px 0 5px 5px;
                    width:200px;
                    padding:10px;
                    justify-content: center;
                    align-items: center;
                    span{
                        display:flex;
                        align-content: center;
                        font-size:15px;
                        cursor:pointer;
                        padding:10px;
                    }
                }
            }
            .account-details:hover{
            }

        }
    }
</style>
