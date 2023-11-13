<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-8">
                    <div class="box">
                        <div class="has-text-weight-bold subtitle is-4">STRANDS</div>
                        <b-field label="Search">
                            <b-input type="text"
                                     v-model="search.strand" placeholder="Search Strand"
                                     @keyup.native.enter="loadAsyncData"/>
                            <p class="control">
                                <b-tooltip label="Search" type="is-success">
                                    <b-button type="is-primary" icon-right="account-filter" @click="loadAsyncData"/>
                                </b-tooltip>
                            </p>
                        </b-field>

                        <div class="buttons is-right mt-3">
                            <b-button @click="openModal" icon-left="plus" class="is-primary is-small">NEW</b-button>
                        </div>

                        <b-table
                            :data="data"
                            :loading="loading"
                            paginated
                            detailed
                            backend-pagination
                            :total="total"
                            :pagination-rounded="true"
                            :per-page="perPage"
                            @page-change="onPageChange"
                            aria-next-label="Next page"
                            aria-previous-label="Previous page"
                            aria-page-label="Page"
                            aria-current-label="Current page"
                            backend-sorting
                            :default-sort-direction="defaultSortDirection"
                            @sort="onSort">

                            <b-table-column field="strand_id" label="ID" sortable v-slot="props">
                                {{ props.row.strand_id }}
                            </b-table-column>

                            <b-table-column field="track" label="Track" sortable v-slot="props">
                                {{ props.row.track.track }}
                            </b-table-column>

                            <b-table-column field="strand" label="Strand" sortable v-slot="props">
                                {{ props.row.strand }}
                            </b-table-column>

                            <b-table-column field="strand_desc" label="Description" sortable v-slot="props">
                                {{ props.row.strand_desc }}
                            </b-table-column>

                            <b-table-column label="Action" v-slot="props">
                                <div class="is-flex">
                                    <b-tooltip label="Edit" type="is-warning">
                                        <b-button class="button is-small mr-1" tag="a" icon-right="pencil" @click="getData(props.row.strand_id)"></b-button>
                                    </b-tooltip>
                                    <b-tooltip label="Delete" type="is-danger">
                                        <b-button class="button is-small mr-1" icon-right="delete" @click="confirmDelete(props.row.strand_id)"></b-button>
                                    </b-tooltip>
                                    <b-tooltip label="Add Subject" type="is-info">
                                        <b-button class="button is-small mr-1" icon-right="text-long" 
                                            @click="openModalAddCourse(props.row.strand_id)"></b-button>
                                    </b-tooltip>

                                </div>
                            </b-table-column>

                            <template #detail="props">

                                <tr>
                                    <th>Code</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>

                                <tr v-for="(item, index) in props.row.courses" :key="`course${index}`">
                                    <td>
                                        <span v-if="item.course">
                                            {{ item.course.course_code }}
                                        </span>
                                        
                                    </td>
                                    <td>
                                        <span v-if="item.course">
                                            {{ item.course.course_desc }}
                                        </span>
                                    </td>
                                    <td>
                                        <b-tooltip label="Delete" type="is-danger">
                                            <b-button class="button is-small mr-1" 
                                                icon-right="delete" 
                                                @click="confirmDeleteStrandCourse(item.strand_course_id)"></b-button>
                                        </b-tooltip>
                                    </td>
                                </tr>
                            </template>
                        </b-table>

                        <div class="columns">
                            <div class="column">
                                <b-field label="Page" label-position="on-border">
                                    <b-select v-model="perPage" @input="setPerPage" class="is-small">
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
                        <p class="modal-card-title">Strand Information</p>
                        <button
                            type="button"
                            class="delete"
                            @click="isModalCreate = false"/>
                    </header>

                    <section class="modal-card-body">
                        <div class="">
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Track" label-position="on-border"
                                             expanded
                                             :type="this.errors.track_id ? 'is-danger':''"
                                             :message="this.errors.track_id ? this.errors.track_id[0] : ''">
                                        <b-select v-model="fields.track_id"
                                            expanded
                                            placeholder="Track" required>
                                            <option :value="item.track_id" v-for="(item, ix) in tracks" :key="`track${ix}`">
                                                {{ item.track }}
                                            </option>
                                        </b-select>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Strand" label-position="on-border"
                                        :type="this.errors.strand ? 'is-danger':''"
                                        :message="this.errors.strand ? this.errors.strand[0] : ''">
                                        <b-input v-model="fields.strand"
                                        placeholder="Strand" required>
                                        </b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Description" label-position="on-border"
                                             :type="this.errors.strand_desc ? 'is-danger':''"
                                             :message="this.errors.strand_desc ? this.errors.strand_desc[0] : ''">
                                        <b-input v-model="fields.strand_desc"
                                                 type="textarea"
                                                 placeholder="Description" required>
                                        </b-input>
                                    </b-field>
                                </div>
                            </div>

                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <button class="button is-primary">Save</button>
                    </footer>
                </div>
            </form><!--close form-->
        </b-modal>
        <!--close modal-->


        <!--modal create-->
        <b-modal v-model="modalAddCourse" has-modal-card
                 trap-focus
                 :width="640"
                 aria-role="dialog"
                 aria-label="Modal"
                 aria-modal>

            <form @submit.prevent="submitAddCourse">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Add Subject to Strand</p>
                        <button
                            type="button"
                            class="delete"
                            @click="modalAddCourse = false"/>
                    </header>

                    <section class="modal-card-body">
                        <div class="">
                            
                            <div class="columns">
                                <div class="column">
                                    <modal-browse-course 
                                        :prop-name="course.course"
                                        @browseCourse="emitBrowseCourse"></modal-browse-course>
                                </div>
                            </div>

                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <button class="button is-primary">Save</button>
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
            sortField: 'strand_id',
            sortOrder: 'desc',
            page: 1,
            perPage: 10,
            defaultSortDirection: 'asc',

            global_id : 0,

            search: {
                strand: '',
            },

            isModalCreate: false,
            modalAddCourse: false,

            modalResetPassword: false,

            fields: {
                track_id: null,
                strand: null,
                strand_desc: null,
            },      
            errors: {},

            course: {
                course: '',
            },

      

            tracks: [],


        }

    },

    methods: {
        /*
        * Load async data
        */
        loadAsyncData() {
            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `strand=${this.search.strand}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/get-strands?${params}`)
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
            this.global_id = 0;
            this.errors = {};
        },

        openModalAddCourse(id){
            this.modalAddCourse=true;
            this.global_id = 0;
            this.fields = {};
            this.errors = {};
            this.fields.strand_id = id
            this.course.course = ''
        },


        submit: function(){
            if(this.global_id > 0){
                //update
                axios.put('/strands/'+this.global_id, this.fields).then(res=>{
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
                axios.post('/strands', this.fields).then(res=>{
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


        submitAddCourse(){
            if(this.global_id > 0){
                //update
                axios.put('/add-course/'+this.global_id, this.fields).then(res=>{
                    if(res.data.status === 'updated'){
                        this.$buefy.dialog.alert({
                            title: 'UPDATED!',
                            message: 'Successfully updated.',
                            type: 'is-success',
                            onConfirm: () => {
                                this.loadAsyncData();
                                this.clearFields();
                                this.global_id = 0;
                                this.modalAddCourse = false;
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
                axios.post('/add-course', this.fields).then(res=>{
                    if(res.data.status === 'saved'){
                        this.$buefy.dialog.alert({
                            title: 'SAVED!',
                            message: 'Successfully saved.',
                            type: 'is-success',
                            confirmText: 'OK',
                            onConfirm: () => {
                                this.modalAddCourse = false;
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
        confirmDelete(delete_id) {
            this.$buefy.dialog.confirm({
                title: 'DELETE!',
                type: 'is-danger',
                message: 'Are you sure you want to delete this data?',
                cancelText: 'Cancel',
                confirmText: 'Delete?',
                onConfirm: () => this.deleteSubmit(delete_id)
            });
        },
        //execute delete after confirming
        deleteSubmit(delete_id) {
            axios.delete('/strands/' + delete_id).then(res => {
                this.loadAsyncData();
                this.clearFields()
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },

        clearFields(){
            this.global_id = 0
            this.fields = {}
        },

        loadTracks(){
            axios.get('/load-tracks').then(res=>{
                this.tracks = res.data;
            })
        },
      
        //update code here
        getData: function(data_id){
            this.clearFields();
            this.global_id = data_id;
            this.isModalCreate = true;

            //nested axios for getting the address 1 by 1 or request by request
            axios.get('/strands/'+data_id).then(res=>{
                this.fields = res.data;
            });
        },

        emitBrowseCourse(row){
            this.course.course = row.course_code + ' - ' + row.course_desc
            this.fields.course_id = row.course_id
        },



        confirmDeleteStrandCourse(delete_id) {
            this.$buefy.dialog.confirm({
                title: 'DELETE!',
                type: 'is-danger',
                message: 'Are you sure you want to delete this data?',
                cancelText: 'Cancel',
                confirmText: 'Delete?',
                onConfirm: () => this.deleteSubmitStrandCourse(delete_id)
            });
        },
        //execute delete after confirming
        deleteSubmitStrandCourse(delete_id) {
            axios.delete('/strand-courses/' + delete_id).then(res => {
                this.loadAsyncData();
                this.clearFields()
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },



    },

    mounted() {
        this.loadTracks()
        this.loadAsyncData()
    }

}


</script>


<style>

.table > tbody > tr {
    /* background-color: blue; */
    transition: background-color 0.5s ease;
}

.table > tbody > tr:hover {
    background-color: rgb(233, 233, 233);

}

</style>
