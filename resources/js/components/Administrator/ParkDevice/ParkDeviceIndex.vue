<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-6-widescreen is-10-tablet">
                    <div class="box">
                        <div class="has-text-weight-bold subtitle is-4 table-header">PARK DEVICES</div>

                        <div class="columns">
                            <div class="column">
                                <b-field label="Search" label-position="on-border">
                                    <b-input type="text"
                                        v-model="search.search" 
                                        placeholder="Search..."
                                        @keyup.native.enter="loadAsyncData"/>
                                    <p class="control">
                                        <b-tooltip label="Search" type="is-success">
                                            <b-button 
                                                type="is-primary" 
                                                icon-right="account-filter" 
                                                @click="loadAsyncData"/>
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
                            <!-- 
                            <b-table-column field="parking_fee_id" label="ID" sortable v-slot="props">
                                {{ props.row.parking_fee_id }}
                            </b-table-column> -->

                            <b-table-column field="park_id" centered label="Id" sortable v-slot="props">
                                {{ props.row.park_id }}
                            </b-table-column>

                            <b-table-column field="name" label="Device Name" sortable v-slot="props">
                                {{ props.row.name }}
                            </b-table-column>
                            <!-- <b-table-column field="device_mac" label="Parking Price" sortable v-slot="props">
                                {{ props.row.device_mac }}
                            </b-table-column> -->
                            <b-table-column field="device_ip" label="IP" sortable v-slot="props">
                                {{ props.row.device_ip }}
                            </b-table-column>

                            <b-table-column field="occupied" label="Occupied" sortable v-slot="props">
                                <span v-if="props.row.is_occupied === 1" class="yes">YES</span>
                                <span v-else class="no">NO</span>
                            </b-table-column>

                            <b-table-column label="OPTIONS" v-slot="props">
                                <div class="is-flex">
                                    <b-tooltip label="Edit" type="is-warning">
                                        <b-button class="button is-small mr-1" 
                                            tag="a" 
                                            icon-right="pencil" 
                                            @click="getData(props.row.park_id)"></b-button>
                                    </b-tooltip>
                                    <b-tooltip label="Delete" type="is-danger">
                                        <b-button class="button is-small mr-1" 
                                            icon-right="delete" 
                                            @click="confirmDelete(props.row.park_id)"></b-button>
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
                        <p class="modal-card-title has-text-weight-bold is-size-6">PARK DEVICE INFORMATION</p>
                        <button
                            type="button"
                            class="delete"
                            @click="isModalCreate = false"/>
                    </header>

                    <section class="modal-card-body">
                        <div class="">
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Device Name" label-position="on-border"
                                        :type="errors.name ? 'is-danger':''"
                                        :message="errors.name ? errors.name[0] : ''">
                                        <b-input v-model="fields.name"
                                            placeholder="Device Name" required>
                                        </b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Device IP" label-position="on-border"
                                        :type="errors.device_ip ? 'is-danger':''"
                                        :message="errors.device_ip ? errors.device_ip[0] : ''">
                                        <b-input v-model="fields.device_ip"
                                            placeholder="Device IP" required>
                                        </b-input>
                                    </b-field>
                                </div>
                            </div>

                             <div class="columns">
                                <div class="column">
                                    <b-field label="Occupied"
                                        :type="errors.is_occupied ? 'is-danger':''"
                                        :message="errors.is_occupied ? errors.is_occupied[0] : ''">
                                        <b-checkbox v-model="fields.is_occupied"
                                            :true-value="1"
                                            :false-value="0">
                                        </b-checkbox>
                                    </b-field>
                                </div>
                            </div>
 
                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <button class="button is-primary has-text-weight-bold">
                            Save
                            <b-icon class="ml-4" icon="content-save-outline"></b-icon>
                        </button>
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
            sortField: 'park_id',
            sortOrder: 'desc',
            page: 1,
            perPage: 10,
            defaultSortDirection: 'asc',


            global_id : 0,

            search: {
                search: '',
            },

            isModalCreate: false,
           

            fields: {
                parking_hours: null,
                parking_price: 0
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
                `search=${this.search.search}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/get-park-devices?${params}`)
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
            this.clearFields()
            this.errors = {};
        },

      


        submit: function(){
            if(this.global_id > 0){
                //update
                axios.put('/park-devices/'+this.global_id, this.fields).then(res=>{
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
                axios.post('/park-devices', this.fields).then(res=>{
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
            axios.delete('/park-devices/' + dataId).then(res => {
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
            this.fields.name = null
            this.fields.device_ip = null
            this.fields.is_occupied = 0
        },


        //update code here
        getData: function(data_id){
            this.clearFields();
            this.global_id = data_id;
            this.isModalCreate = true;

            //nested axios for getting the address 1 by 1 or request by request
            axios.get('/park-devices/'+ data_id).then(res=>{
                this.fields = res.data;
            });
        },

      
    },

    mounted() {
        this.loadAsyncData()
    }

}


</script>


<style scoped>

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
        color: white;
    }


    .yes {
        font-weight: bold;
        background-color: green;
        font-size: 10px;
        padding: 5px 10px;
        color:white;
    }

    .no {
        font-weight: bold;
        background-color: red;
        font-size: 10px;
        padding: 5px 10px;
        color:white;
    }

</style>
