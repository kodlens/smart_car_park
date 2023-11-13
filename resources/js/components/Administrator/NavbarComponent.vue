<template>
    <div>
        <b-navbar>
            <template #brand>
                <b-navbar-item>
                    <span>ADMINISTRATOR PANEL</span>
                </b-navbar-item>
            </template>
            <template #start>
                
            </template>

            <template #end>
                <b-navbar-item href="/admin-home">
                    Home
                </b-navbar-item>

                <!-- <b-navbar-item href="/manage-patient">
                    Patient
                </b-navbar-item> -->
               
                <b-navbar-dropdown label="Setup">
                    <b-navbar-item href="/academic-year">
                        Academic Year
                    </b-navbar-item>
                    <b-navbar-item href="/track">
                        Track
                    </b-navbar-item>
                    <!-- <b-navbar-item href="/role">
                        Category
                    </b-navbar-item> -->
                </b-navbar-dropdown>
                <b-navbar-item href="/accounts">
                    Accounts
                </b-navbar-item>
                
                <b-navbar-item tag="div">
                    <div class="buttons">
                        <button @click="logout" class="w2-button">
                            <span class="mdi mdi-logout"></span>
                            LOG OUT
                        </button>
                    </div>
                </b-navbar-item>
            </template>
        </b-navbar>

    </div>


</template>

<script>
export default {
    data(){
        return{
            open: false,
            overlay: false,
            fullheight: true,
            fullwidth: false,
            right: true,
            expandOnHover: true,
            reduce: false,
            mobile: "reduce",

            user: {
                role: '',
                lname: '',
                fname: '',
                mname: '',
            },
        }
    },
    methods: {
        logout(){
            axios.post('/logout').then(()=>{
                window.location = '/';
            })
        },

        loadUser(){
            axios.get('/load-user').then(res=>{
                this.user = res.data;
            })
        }
    },

    mounted(){
        this.loadUser();
    },

    computed: {
        userRole(){
            return this.user.role.toUpperCase() + ' (' + this.user.lname.toUpperCase() + ', ' + this.user.fname.toUpperCase() + ')';

        }
    }
}
</script>

<style scoped>


    .logo{
        padding: 0 30px 0 30px;
        height: 90px;
    }

    .burger-div{
        width: 20px;
        height: 3px;
        background-color: #696969;
        margin: 0 0 3px 0;
        margin-left: auto;
        border-radius: 10px;
    }

    .burger-button{
        display: flex;
        flex-direction: column;
        margin-left: auto;
    }

    .mynav{
        padding: 25px;
        border-bottom: 2px solid rgba(196, 196, 196, 0.53);
        display: flex;
    }

    .mynav-brand{
        font-weight: bold;
        font-size: 1.2em;
        
    }

  /* .hero{
        background-image: url("/img/bg-hero.jpg");
        background-repeat: no-repeat;
        background-size: cover;
    } */


</style>
