<template>
    <div class="login-wrapper">
        <form @submit.prevent="submit">
            <div class="login-card">
                <div class="title is-4 is-centered">
                    SIGN IN
                </div>
                <hr class="hr-line">

                <div class="panel-body">
                    <div class="columns">
                        <div class="column">
                            <img src="/img/login-logo.png" />
                        </div>

                        <div class="column">
                            <b-field class="login-input" label="Username" label-position="on-border"
                                :type="this.errors.username ? 'is-danger':''"
                                :message="this.errors.username ? this.errors.username[0] : ''">
                                <b-input type="text" icon="account" v-model="fields.username" placeholder="Username" />
                            </b-field>

                            <b-field label="Password" label-position="on-border">
                                <b-input type="password" icon="lock" v-model="fields.password" password-reveal placeholder="Password" />
                            </b-field>

                            <div class="buttons is-centered mt-4">
                                <button class="button is-primary is-outlined">LOGIN</button>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </form>

    </div>
</template>

<script>

export default {
    data(){
        return {
            fields: {
                username: null,
                password: null,
            },

            errors: {},
        }
    },

    methods: {
        submit: function(){
            axios.post('/login', this.fields).then(res=>{
                window.location = '/login';
               //window.location = '/dashboard';
            }).catch(err=>{
                if(err.response.status === 422){
                    this.errors = err.response.data.errors;
                }
            });
        }
    }
}
</script>


<style scoped src="../../css/login.css"></style>
