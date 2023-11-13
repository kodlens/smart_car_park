<template>
    <b-navbar>
        <template #brand>
            <b-navbar-item>
                <img src="/img/logo.png" />
                
            </b-navbar-item>
        </template>

        <template #start>
           

        </template>

        <template #end>
           
            <b-navbar-item href="/">
                Home
            </b-navbar-item>
            <b-navbar-item href="/">
                About Us
            </b-navbar-item>
            <b-navbar-item tag="div">
                <div v-if="!currentLogin" class="buttons">
                    <a class="button is-primary is-outlined" href="/login">
                        <strong>Login</strong>
                    </a>
                </div>
                <div v-else class="buttons">
                    <b-button label="LOGOUT" icon-left="logout" @click="logout">
                    </b-button>
                </div>
            </b-navbar-item>
            
        </template>
    </b-navbar>

</template>

<script>
export default {
    props: ['propUser'],

    data(){
        return{
            user: null,
        }
    },

    methods:{
        initData: function(){
            if(this.propUser){
                this.user = JSON.parse(this.propUser);
            }
        },

        logout(){
            axios.post('/logout').then(()=>{
                window.location = '/';
            })
        }
    },

    mounted(){
        this.initData();
    },

    computed: {
        showName(){
            if(this.user){
                return this.user.fname.toUpperCase();
            }
            return '';
        },
        currentLogin(){
            return !!this.user;
        }
    }

}
</script>

<style>
    .navbar-item{
        font-weight: bold;
    }
</style>
