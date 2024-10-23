<template>
    <div>

        <div class="section">

            <div class="columns is-centered">
                <div class="column is-6-widescreen is-8-desktop">

                    <div class="box">

                        <div class="box-body">

                            <div class="mb-2">
                                <div class="profile-text">CHANGE PASSWORD</div>
                        
                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Old Password"
                                            :type="errors.old_password ? 'is-danger':''"
                                            :message="errors.old_password ? errors.old_password[0] : ''">
                                            <b-input type="password" password-reveal 
                                                v-model="fields.old_password" placeholder="Old Password"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Password"
                                            :type="errors.password ? 'is-danger':''"
                                            :message="errors.password ? errors.password[0] : ''">
                                            <b-input type="password" password-reveal 
                                                v-model="fields.password" placeholder="Password"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Confirm Password"
                                            :type="errors.password_confirmation ? 'is-danger':''"
                                            :message="errors.password_confirmation ? errors.password_confirmation[0] : ''">
                                            <b-input type="password" password-reveal 
                                                v-model="fields.password_confirmation" placeholder="First Name"></b-input>
                                        </b-field>
                                    </div>
                                </div>
                            </div>
                        </div> <!--box body -->

                        <div class="box-footer">
                            <div class="buttons mt-2 is-right">
                                <b-button label="Change Password"
                                    class="is-primary is-outlined"
                                    @click="submit"></b-button>
                            </div>
                        </div>
                    </div><!-- box -->
                </div>
            </div>
        </div>

    </div>
</template>

<script>

export default{

    data(){
        return {
            fields: {
                old_password: '',
                password: '',
                password_confirmation: '',
            },
            errors: {},
        }
    },

    methods: {
      

        submit(){
            this.errors = {}
            axios.post('/my-change-password', this.fields).then(res=>{
                if(res.data.status === 'changed'){
                    this.$buefy.dialog.alert({
                        title: 'Password Changed!',
                        message: 'Password successfully change.',
                        onConfirm: ()=>{
                            this.fields.old_password = ''
                            this.fields.password = ''
                            this.fields.password_confirmation = ''
                        }
                    });
                }
            }).catch(err=>{
                this.errors = err.response.data.errors
            })
        }
    },

    mounted(){
        
    }
}
</script>

<style scoped>
.profile-text{
    font-weight: bold;
    font-size: 1.3em;
    border-bottom: 1px solid #b6b6b6;
    margin-bottom: 15px;
}

.box-footer{
    margin-top: 15px;
    border-top: 1px solid #b6b6b6;
}

.qr-code{
    display: block;
    margin: auto;
}
</style>
