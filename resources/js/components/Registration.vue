<template>
    <section class="section">
        <div class="columns is-centered">
            <div class="column is-8-tablet is-5-widescreen">
                <form @submit.prevent="submit">

                    <div class="box">
                        <div class="box-title">
                            PERSONAL INFORMATION
                        </div>

                        <div class="panel-body">

                            <div class="divider">ACCOUNT</div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Username"
                                             :type="errors.username ? 'is-danger':''"
                                             :message="errors.username ? errors.username[0] : ''">
                                        <b-input type="text" v-model="fields.username" placeholder="Username" 
                                            icon="account" required></b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Password"
                                             :type="errors.password ? 'is-danger':''"
                                             :message="errors.password ? errors.password[0] : ''">
                                        <b-input type="password"  v-model="fields.password"
                                            placeholder="Password" icon="lock" password-reveal
                                                required></b-input>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="Re-type Password">
                                        <b-input type="password" icon="lock" v-model="fields.password_confirmation" 
                                            placeholder="Re-type Password" password-reveal
                                                required></b-input>
                                    </b-field>
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    <b-field label="E-mail"
                                        :type="errors.email ? 'is-danger':''"
                                        :message="errors.email ? errors.email[0] : ''">
                                        <b-input type="email" v-model="fields.email" 
                                            placeholder="E-mail" icon="email"
                                                required></b-input>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="Contact No."
                                        :type="errors.contact_no ? 'is-danger':''"
                                        :message="errors.contact_no ? errors.contact_no[0] : ''">
                                        <b-input type="tel" 
                                            v-model="fields.contact_no" 
                                            pattern="^(9)\d{9}$"
                                            placeholder="Format: 9191112222" icon=""></b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Last Name"
                                            :type="errors.lname ? 'is-danger':''"
                                            :message="errors.lname ? errors.lname[0] : ''" >
                                        <b-input icon="account" placeholder="Last Name" v-model="fields.lname" 
                                            type="text" required></b-input>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="First Name"
                                             :type="errors.fname ? 'is-danger':''"
                                             :message="errors.fname ? errors.fname[0] : ''">
                                        <b-input icon="account" v-model="fields.fname" placeholder="First Name" 
                                            type="text" required></b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Middle Name">
                                        <b-input v-model="fields.mname" type="text" placeholder="Middle Name"></b-input>
                                    </b-field>
                                </div>

                                <div class="column">
                                    <b-field label="Extension (Jr, III, Sr.)">
                                        <b-input type="text" v-model="fields.suffix" placeholder="Extension (Jr, III, Sr.)"></b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Sex" expanded
                                            :type="errors.sex ? 'is-danger':''"
                                            :message="errors.sex ? errors.sex[0] : ''">
                                        <b-select placeholder="Sex" v-model="fields.sex" icon="account" 
                                            required expanded>
                                            <option value="MALE">MALE</option>
                                            <option value="FEMALE">FEMALE</option>
                                        </b-select>
                                    </b-field>
                                </div>
                            </div>


                            <!-- Current Address -->

                            <!-- <div class="mb-2">
                                <h2><span>Current Address</span></h2>
                            </div>
                            
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Province" expanded
                                             :type="errors.province ? 'is-danger':''"
                                             :message="errors.province ? errors.province[0] : ''">
                                        <b-select v-model="fields.province" expanded placeholder="Province" @input="loadCities">
                                            <option v-for="(item, index) in provinces" :key="index" :value="item.provCode">{{ item.provDesc }}</option>
                                        </b-select>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="City/Municipality" expanded
                                             :type="errors.city ? 'is-danger':''"
                                             :message="errors.city ? errors.city[0] : ''">
                                        <b-select expanded v-model="fields.city" placeholder="City" @input="loadBarangays">
                                            <option v-for="(item, index) in cities" :key="index" :value="item.citymunCode">{{ item.citymunDesc }}</option>
                                        </b-select>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Barangay" expanded
                                             :type="errors.barangay ? 'is-danger':''"
                                             :message="errors.barangay ? errors.barangay[0] : ''">
                                        <b-select v-model="fields.barangay" expanded placeholder="Barangay">
                                            <option v-for="(item, index) in barangays" :key="index" :value="item.brgyCode">{{ item.brgyDesc }}</option>
                                        </b-select>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="House #. Street">
                                        <b-input type="text" 
                                            v-model="fields.street" 
                                            placeholder="House #. Street"></b-input>
                                    </b-field>
                                </div>

                                <div class="column">
                                    <b-field label="Zip Code"
                                        :type="errors.zipcode ? 'is-danger':''"
                                        :message="errors.zipcode ? errors.zipcode[0] : ''">
                                        <b-input type="text" 
                                            v-model="fields.zipcode" 
                                            placeholder="Zip Code"></b-input>
                                    </b-field>
                                </div>
                            </div> -->
                            <hr>

                            <div class="buttons is-right">
                                <button class="button is-primary is-outlined">
                                    SUBMIT INFORMATION
                                    &nbsp;
                                    <b-icon icon="arrow-right"></b-icon>
                                </button>
                            </div>

                        </div> <!--panel -body-->
                    </div> <!--panel-->

                </form>
            </div><!--column-->
        </div><!--cols-->
    </section>
</template>

<script>
export default {

    data(){
        return{

            fields: {

                username: null,
                password: null,

                lname: null,
                fname: null,
                mname: null,
                sex:null,
           

                province: null,
                city: null,
                barangay: null,
                street: null,
                zipcode: null,

            },

            errors: {},

            provinces: [],
            cities: [],
            barangays: [],

          

            btnClass: {
                'button' : true,
                'is-loading': false,
                'is-primary': true,
            }
        }
    },
    methods: {
        //ADDRESS
        loadProvinces: function(){
            axios.get('/load-provinces').then(res=>{
                this.provinces = res.data;
            })
        },
        loadCities: function(){
            axios.get('/load-cities?prov=' + this.fields.province).then(res=>{
                this.cities = res.data;
            })
        },

        loadBarangays: function(){
            axios.get('/load-barangays?prov=' + this.fields.province + '&city_code='+this.fields.city).then(res=>{
                this.barangays = res.data;
            })
        },

      
        //ADDRESS

        //copy current address
       

        submit(){
            this.errors = {}; //clear all errors, to refresh errors
            this.btnClass['is-loading'] = true;

            axios.post('/registration', this.fields).then(res=>{
                if(res.data.status === 'saved'){
                    this.btnClass['is-loading'] = false;

                    this.$buefy.dialog.alert({
                        title: "SAVED!",
                        message: 'Account successfully registered. You can login the account now.',
                        type: 'is-success',
                        onConfirm: ()=>  window.location = '/login'
                    });
                }
                this.btnClass['is-loading'] = false;

            }).catch(err=>{
                this.btnClass['is-loading'] = false;

                if(err.response.status === 422){
                    this.errors = err.response.data.errors;
                    if(this.errors.exist){
                        this.$buefy.dialog.alert({
                            title: 'Exist!',
                            hasIcon: true,
                            message: this.errors.exist[0],
                            type: 'is-danger',
                        })
                    }else{
                        this.$buefy.dialog.alert({
                            title: 'Error!',
                            hasIcon: true,
                            message: 'Some fields are required. Please check fields marked red.',
                            type: 'is-danger',
                        })
                    }

                }else{
                    alert('An error occured.');
                }
            });
        },

        initData(){
            //this.loadProvinces();
        },

      
    },


    mounted() {

        this.initData();


    }
}
</script>

<style scoped>


    .box-title{
        font-weight: bold;
        font-size: 1.5rem;
        text-align: center;
    }

/*    dere lang kubia ang panel color*/
</style>
