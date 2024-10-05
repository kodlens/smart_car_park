<template>
    <div>

        <div class="section">

            <div class="columns is-centered">
                <div class="column is-6-widescreen is-8-desktop">

                    <div class="box">

                        <div class="box-body">

                            <div class="mb-2">
                                <div class="profile-text">PROFILE</div>
                            </div>

                            <!-- <b-notification
                                v-if="user.active === 0"
                                type="is-danger is-light"
                                aria-close-label="Close notification"
                                role="alert">
                                Account is not yet activated for mobile use.
                            </b-notification> -->
<!-- 
                            <div class="columns">
                                <div class="column">
                                    <qrcode v-if="user.qr_code"
                                        class="qr-code"
                                        :value="user.qr_code" 
                                        :options="{ width: 200 }"></qrcode>
                                </div>
                            </div> -->
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Last Name"
                                        :type="errors.lname ? 'is-danger':''"
                                        :message="errors.lname ? errors.lname[0] : ''">
                                        <b-input type="text" v-model="user.lname" placeholder="Last Name"></b-input>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="First Name"
                                        :type="errors.fname ? 'is-danger':''"
                                        :message="errors.fname ? errors.fname[0] : ''">
                                        <b-input type="text" v-model="user.fname" placeholder="First Name"></b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Middle Name">
                                        <b-input type="text" v-model="user.mname" placeholder="Middle Name"></b-input>
                                    </b-field>
                                </div>

                                <div class="column">
                                    <b-field label="Middle Name">
                                        <b-input type="text" v-model="user.suffix" placeholder="Middle Name"></b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Contact No.">
                                        <b-input type="text" v-model="user.contact_no" placeholder="Contact No."></b-input>
                                    </b-field>
                                </div>
                            </div>


                            <div class="columns">
                                <div class="column">
                                    <b-field label="Email"
                                        :type="errors.email ? 'is-danger':''"
                                        :message="errors.email ? errors.email[0] : ''">
                                        <b-input type="text" v-model="user.email" placeholder="Email"></b-input>
                                    </b-field>
                                </div>

                                <div class="column">
                                    <b-field label="Sex" expanded
                                        :type="errors.sex ? 'is-danger':''"
                                        :message="errors.sex ? errors.sex[0] : ''">
                                        <b-select v-model="user.sex"
                                            expanded placeholder="Sex">
                                            <option value="MALE">MALE</option>
                                            <option value="FEMALE">FEMALE</option>
                                        </b-select>
                                    </b-field>
                                </div>
                            </div>
                        </div> <!--box body -->

                        <div class="box-footer">
                            <div class="buttons mt-2 is-right">
                                <b-button label="Update Profile"
                                    class="is-primary is-outlined"
                                    @click="updateProfile"></b-button>
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
            user: {
                lname: '',
                fname: '',
                mname: '',
                sex: '',
                email: '',
                contact_no: '',

            },
            errors: {},
        }
    },

    methods: {
        loadProfile(){
            axios.get('/load-profile').then(res=>{
                this.user = res.data
            })
        },

        updateProfile(){
            axios.put('/my-profile/' + this.user.user_id, this.user).then(res=>{
                if(res.data.status === 'updated'){
                    this.$buefy.dialog.alert({
                        title: 'Updated!',
                        message: 'Profile successfully updated.',
                        onConfirm: ()=>{
                            this.loadProfile()
                        }
                    });
                }
            }).catch(err=>{
                this.errors = err.response.data.errors
            })
        }
    },

    mounted(){
        this.loadProfile()
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
