<template>
    <div>
        <div class="mynav">
            <div class="mynav-brand">{{ showName }}</div>
            <div class="burger-button" @click="open = true">
                <div class="burger-div"></div>
                <div class="burger-div"></div>
                <div class="burger-div"></div>
            </div>
        </div>

        <section>
            <b-sidebar
                type="is-light"
                :fullheight="fullheight"
                :fullwidth="fullwidth"
                :overlay="overlay"
                :right="right"
                v-model="open">
                <div class="p-4">
                    <h3 class="title is-4">{{ showName }} PANEL</h3>
                    <b-menu>
                        <b-menu-list>
                            <b-menu-item label="Home" icon="home" tag="a" href="/"></b-menu-item>
                        </b-menu-list>

                        <b-menu-list label="Menu">
                            <b-menu-item icon="information-outline" label="Dashboard" tag="a" href="/dashboard-user"></b-menu-item>
                        </b-menu-list>

                        <b-menu-list>
                            <b-menu-item label="My Apointment" icon="calendar" tag="a" href="/my-appointment"></b-menu-item>
                        </b-menu-list>

                        <b-menu-list>
                            <b-menu-item label="My Profile" icon="account" tag="a" href="/my-profile"></b-menu-item>
                        </b-menu-list>


                        <b-menu-list label="Actions">
                            <b-menu-item @click="logout" label="Logout"></b-menu-item>
                        </b-menu-list>
                    </b-menu>
                </div>
            </b-sidebar>

        </section>
    </div>

</template>

<script>
export default {
    data(){
        return{
            open: false,
            overlay: true,
            fullheight: true,
            fullwidth: false,
            right: true,

            user: null,
        }
    },
    methods: {
        logout(){
            axios.post('/logout').then(()=>{
                window.location = '/';
            })
        },

        loadUser(){
            axios.get('/get-user').then(res=>{
                this.user = res.data;
            })
        }
    },

    mounted() {
        this.loadUser()
    },

    computed: {
        showName: function(){
            if(this.user){
                return this.user.fname.toUpperCase();
            }
            return '';
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
    border-bottom: 2px solid rgba(22, 69, 28, 0.53);
    display: flex;
}

.mynav-brand{
    font-weight: bold;
    font-size: 1.2em;
}



</style>
