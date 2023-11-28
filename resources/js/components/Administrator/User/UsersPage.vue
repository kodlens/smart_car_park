<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-8">
                    <div class="box">
                        <div class="has-text-weight-bold subtitle is-4 table-header">LIST OF USERS</div>

                        <div class="columns">
                            <div class="column">
                                <b-field label="Search" label-position="on-border">
                                    <b-input type="text"
                                        v-model="search.lname" placeholder="Search Lastname"
                                        @keyup.native.enter="loadAsyncData"/>
                                    <p class="control">
                                            <b-tooltip label="Search" type="is-success">
                                        <b-button type="is-primary" icon-right="account-filter" @click="loadAsyncData"/>
                                            </b-tooltip>
                                    </p>
                                </b-field>
                            </div>

                            <div class="column">
                                <div class="buttons is-right mt-3">
                                    <b-button @click="openModal" icon-left="plus" class="is-primary is-small">NEW</b-button>
                                </div>
                            </div>
                        </div>
                        

                     

                        <b-table
                            class="is-info"
                            :data="data"
                            :loading="loading"
                            paginated
                            
                            backend-pagination
                            :total="total"
                            :per-page="perPage"
                            @page-change="onPageChange"
                            aria-next-label="Next page"
                            aria-previous-label="Previous page"
                            aria-page-label="Page"
                            aria-current-label="Current page"
                            backend-sorting
                            :default-sort-direction="defaultSortDirection"
                            @sort="onSort">

                            <b-table-column field="user_id" label="ID" sortable v-slot="props">
                                {{ props.row.user_id }}
                            </b-table-column>

                            <b-table-column field="username" label="USERNAME" sortable v-slot="props">
                                {{ props.row.username }}
                            </b-table-column>

                            <b-table-column field="lname" label="NAME" sortable v-slot="props">
                                {{ props.row.lname }}, {{ props.row.fname }} {{ props.row.mname }}
                            </b-table-column>

                            <b-table-column field="sex" label="SEX" v-slot="props">
                                {{ props.row.sex }}
                            </b-table-column>

                            <b-table-column field="role" label="ROLE" v-slot="props">
                                {{ props.row.role }}
                            </b-table-column>

                            <b-table-column field="contact_no" label="CONTACT NO." v-slot="props">
                                {{ props.row.contact_no }}
                            </b-table-column>


                            <b-table-column label="OPTIONS" v-slot="props">
                                <div class="is-flex">
                                    <b-tooltip label="Edit" type="is-warning">
                                        <b-button class="button is-small mr-1" tag="a" icon-right="pencil" @click="getData(props.row.user_id)"></b-button>
                                    </b-tooltip>
                                    <b-tooltip label="Delete" type="is-danger">
                                        <b-button class="button is-small mr-1" icon-right="delete" @click="confirmDelete(props.row.user_id)"></b-button>
                                    </b-tooltip>
                                    <b-tooltip label="Reset Password" type="is-info">
                                        <b-button class="button is-small mr-1" icon-right="lock" @click="openModalResetPassword(props.row.user_id)"></b-button>
                                    </b-tooltip>
                                </div>
                            </b-table-column>
                        </b-table>

                        <div class="columns">
                            <div class="column">
                                <b-field label="Page" label-position="on-border">
                                    <b-select v-model="perPage" @input="setPerPage" 
                                        size="is-small">
                                        <option value="5">5 per page</option>
                                        <option value="10">10 per page</option>
                                        <option value="15">15 per page</option>
                                        <option value="20">20 per page</option>
                                    </b-select>
                                </b-field>
                            </div>
                        </div>

                    </div>
                </div><!--col -->
            </div><!-- cols -->
        </div><!--section div-->



        <!--modal create-->
        <b-modal v-model="isModalCreate" has-modal-card
                 trap-focus
                 :width="640"
                 aria-role="dialog"
                 aria-label="Modal"
                 aria-modal>

            <form @submit.prevent="submit">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title has-text-weight-bold is-size-6">USER INFORMATION</p>
                        <button
                            type="button"
                            class="delete"
                            @click="isModalCreate = false"/>
                    </header>

                    <section class="modal-card-body">
                        <div class="">
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Username" label-position="on-border"
                                             :type="this.errors.username ? 'is-danger':''"
                                             :message="this.errors.username ? this.errors.username[0] : ''">
                                        <b-input v-model="fields.username"
                                                 placeholder="Username" required>
                                        </b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Last Name" label-position="on-border"
                                             :type="this.errors.lname ? 'is-danger':''"
                                             :message="this.errors.lname ? this.errors.lname[0] : ''">
                                        <b-input v-model="fields.lname"
                                            icon="account"
                                            placeholder="Last Name" required>
                                        </b-input>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="First Name" label-position="on-border"
                                             :type="this.errors.fname ? 'is-danger':''"
                                             :message="this.errors.fname ? this.errors.fname[0] : ''">
                                        <b-input v-model="fields.fname"
                                                 placeholder="First Name" required>
                                        </b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Middle Name" label-position="on-border"
                                             :type="this.errors.mname ? 'is-danger':''"
                                             :message="this.errors.mname ? this.errors.mname[0] : ''">
                                        <b-input v-model="fields.mname"
                                                 placeholder="Middle Name">
                                        </b-input>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="Suffix" label-position="on-border"
                                             :type="this.errors.suffix ? 'is-danger':''"
                                             :message="this.errors.suffix ? this.errors.suffix[0] : ''">
                                        <b-input v-model="fields.suffix"
                                                 placeholder="Suffix">
                                        </b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Contact No" label-position="on-border"
                                             :type="this.errors.contact_no ? 'is-danger':''"
                                             :message="this.errors.contact_no ? this.errors.contact_no[0] : ''">
                                        <b-input type="number" v-model="fields.contact_no"
                                                 placeholder="Contact No" required>
                                        </b-input>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="Email" label-position="on-border"
                                             :type="this.errors.email ? 'is-danger':''"
                                             :message="this.errors.email ? this.errors.email[0] : ''">
                                        <b-input type="email" v-model="fields.email" icon="email"
                                                 placeholder="Email" required>
                                        </b-input>
                                    </b-field>
                                </div>
                            
                            </div>

                            <div class="columns" v-if="global_id < 1">
                                <div class="column">
                                    <b-field label="Password" label-position="on-border"
                                             :type="this.errors.password ? 'is-danger':''"
                                             :message="this.errors.password ? this.errors.password[0] : ''">
                                        <b-input type="password" password-reveal v-model="fields.password"
                                                 placeholder="Password" required>
                                        </b-input>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="Confirm Password" label-position="on-border"
                                             :type="this.errors.password_confirmation ? 'is-danger':''"
                                             :message="this.errors.password_confirmation ? this.errors.password_confirmation[0] : ''">
                                        <b-input type="password" password-reveal v-model="fields.password_confirmation"
                                                 placeholder="Confirm Password" required>
                                        </b-input>
                                    </b-field>
                                </div>
                            </div>


                            <div class="columns">
                                <div class="column">
                                    <b-field label="Sex" label-position="on-border" expanded
                                             :type="this.errors.sex ? 'is-danger':''"
                                             :message="this.errors.sex ? this.errors.sex[0] : ''"
                                            >
                                        <b-select v-model="fields.sex" expanded>
                                            <option value="MALE">MALE</option>
                                            <option value="FEMALE">FEMALE</option>
                                        </b-select>
                                    </b-field>
                                </div>

                                <div class="column">
                                    <b-field label="Role" label-position="on-border" expanded
                                             :type="this.errors.role ? 'is-danger':''"
                                             :message="this.errors.role ? this.errors.role[0] : ''">
                                        <b-select v-model="fields.role" expanded>
                                            <option value="ADMINISTRATOR">ADMINISTRATOR</option>
                                            <option value="USER">USER</option>
                                        </b-select>
                                    </b-field>
                                </div>

                            </div>

                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <button class="button is-primary has-text-weight-bold">
                            SAVE USER
                            <b-icon class="ml-4" icon="content-save-outline"></b-icon>
                        </button>
                    </footer>
                </div>
            </form><!--close form-->
        </b-modal>
        <!--close modal-->




        <!--modal reset password-->
        <b-modal v-model="modalResetPassword" has-modal-card
                 trap-focus
                 :width="640"
                 aria-role="dialog"
                 aria-label="Modal"
                 aria-modal>

            <form @submit.prevent="resetPassword">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Change Password</p>
                        <button
                            type="button"
                            class="delete"
                            @click="modalResetPassword = false"/>
                    </header>

                    <section class="modal-card-body">
                        <div class="">
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Password" label-position="on-border"
                                             :type="this.errors.password ? 'is-danger':''"
                                             :message="this.errors.password ? this.errors.password[0] : ''">
                                        <b-input type="password" v-model="fields.password" password-reveal
                                                 placeholder="Password" required>
                                        </b-input>
                                    </b-field>
                                    <b-field label="Confirm Password" label-position="on-border"
                                             :type="this.errors.password_confirmation ? 'is-danger':''"
                                             :message="this.errors.password_confirmation ? this.errors.password_confirmation[0] : ''">
                                        <b-input type="password" v-model="fields.password_confirmation"
                                                 password-reveal
                                                 placeholder="Confirm Password" required>
                                        </b-input>
                                    </b-field>
                                </div>
                            </div>
                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <button
                            class="button is-primary">SAVE</button>
                    </footer>
                </div>
            </form><!--close form-->
        </b-modal>
        <!--close modal-->


    </div>
</template>

<script>

export default{
   
    data() {
        return{
            data: [],
            total: 0,
            loading: false,
            sortField: 'user_id',
            sortOrder: 'desc',
            page: 1,
            perPage: 10,
            defaultSortDirection: 'asc',


            global_id : 0,

            search: {
                lname: '',
            },

            isModalCreate: false,
            modalResetPassword: false,

            fields: {
                username: '',
                lname: '', 
                fname: '',
                mname: '',
                suffix: '',
          
                password: '', 
                password_confirmation : '',
                sex : '', role: '', 
                contact_no : '',
                email: '',
            },
            errors: {},


         
        }

    },

    methods: {
        /*
        * Load async data
        */
        loadAsyncData() {
            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `lname=${this.search.lname}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/get-users?${params}`)
                .then(({ data }) => {
                    this.data = [];
                    let currentTotal = data.total
                    if (data.total / this.perPage > 1000) {
                        currentTotal = this.perPage * 1000
                    }

                    this.total = currentTotal
                    data.data.forEach((item) => {
                        //item.release_date = item.release_date ? item.release_date.replace(/-/g, '/') : null
                        this.data.push(item)
                    })
                    this.loading = false
                })
                .catch((error) => {
                    this.data = []
                    this.total = 0
                    this.loading = false
                    throw error
                })
        },
        /*
        * Handle page-change event
        */
        onPageChange(page) {
            this.page = page
            this.loadAsyncData()
        },

        onSort(field, order) {
            this.sortField = field
            this.sortOrder = order
            this.loadAsyncData()
        },

        setPerPage(){
            this.loadAsyncData()
        },

        openModal(){
            this.isModalCreate=true;
            this.fields = {};
            this.errors = {};
        },

      


        submit: function(){
            if(this.global_id > 0){
                //update
                axios.put('/users/'+this.global_id, this.fields).then(res=>{
                    if(res.data.status === 'updated'){
                        this.$buefy.dialog.alert({
                            title: 'UPDATED!',
                            message: 'Successfully updated.',
                            type: 'is-success',
                            onConfirm: () => {
                                this.loadAsyncData();
                                this.clearFields();
                                this.global_id = 0;
                                this.isModalCreate = false;
                            }
                        })
                    }
                }).catch(err=>{
                    if(err.response.status === 422){
                        this.errors = err.response.data.errors;
                    }
                })
            }else{
                //INSERT HERE
                axios.post('/users', this.fields).then(res=>{
                    if(res.data.status === 'saved'){
                        this.$buefy.dialog.alert({
                            title: 'SAVED!',
                            message: 'Successfully saved.',
                            type: 'is-success',
                            confirmText: 'OK',
                            onConfirm: () => {
                                this.isModalCreate = false;
                                this.loadAsyncData();
                                this.clearFields();
                                this.global_id = 0;
                            }
                        })
                    }
                }).catch(err=>{
                    if(err.response.status === 422){
                        this.errors = err.response.data.errors;
                    }
                });
            }
        },


        //alert box ask for deletion
        confirmDelete(dataId) {
            this.$buefy.dialog.confirm({
                title: 'DELETE!',
                type: 'is-danger',
                message: 'Are you sure you want to delete this data?',
                cancelText: 'Cancel',
                confirmText: 'Delete',
                onConfirm: () => this.deleteSubmit(dataId)
            });
        },
        //execute delete after confirming
        deleteSubmit(dataId) {
            axios.delete('/users/' + dataId).then(res => {
                this.loadAsyncData();
                this.clearFields()
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },

        clearFields(){
            this.global_id = 0;

            this.fields = {
                username: '',
                lname: '', 
                fname: '',
                mname: '',
                suffix: '',
             
                password: '', 
                password_confirmation : '',
                sex : '', role: '', 
                contact_no : '',
                email : ''
            };
        },


        //update code here
        getData: function(data_id){
            this.clearFields();
            this.global_id = data_id;
            this.isModalCreate = true;

            //nested axios for getting the address 1 by 1 or request by request
            axios.get('/users/'+data_id).then(res=>{
                this.fields = res.data;
            });
        },

        //CHANGE PASSWORD
        openModalResetPassword(dataId){
            this.modalResetPassword = true;
            this.fields = {};
            this.errors = {};
            this.global_id = dataId;
        },
        resetPassword(){
            axios.post('/user-reset-password/' + this.global_id, this.fields).then(res=>{

                if(res.data.status === 'changed'){
                    this.$buefy.dialog.alert({
                        title: 'PASSWORD CHANGED',
                        type: 'is-success',
                        message: 'Password changed successfully.',
                        confirmText: 'OK',
                        onConfirm: () => {
                            this.modalResetPassword = false;
                            this.fields = {};
                            this.errors = {};
                            this.loadAsyncData()
                        }
                    });
                }

            }).catch(err=>{
                this.errors = err.response.data.errors;
            })
        },

      
    },

    mounted() {
        this.loadAsyncData()
    }

}


</script>


<style>

    .table-wrapper{
        border: 1px solid gray;
        padding: 15px;
    }
    .table > tbody > tr {
        /* background-color: blue; */
        transition: background-color 0.5s ease;
    }

    .table > tbody > tr:hover {
        background-color: #EAF6FF;

    }

    .table-header{
        background-color: #009FFD;
        padding: 15px;
    }

</style>
