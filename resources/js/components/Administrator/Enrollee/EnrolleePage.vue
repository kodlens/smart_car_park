<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-8-dekstop is-10-tablet">
                    <div class="box">
                        <div class="has-text-weight-bold subtitle is-4">LEARNERS</div>


                        <div class="columns">
                            <div class="column">
                                <b-field label="Academic Year">
                                    <b-select
                                        v-model="search.ay">
                                        <option selected value="">ALL</option>
                                        <option v-for="(item, ix) in academicYears" 
                                            :key="ix"
                                            :value="item.academic_year_id">
                                            {{ item.academic_year_code }} - {{ item.academic_year_desc }}
                                        </option>
                                    </b-select>
                                </b-field>
                            </div>
                        </div>
                        <div class="columns">
                            <div class="column">
                                <b-field>
                                    <b-field label="Search">
                                        <b-input type="text"
                                            v-model="search.lname" placeholder="Search Lastname"
                                            @keyup.native.enter="loadAsyncData"/>
                                    </b-field>
                                    <b-field label="Grade Level">
                                        <b-select
                                            v-model="search.grade">
                                            <option selected value="">ALL</option>
                                        <option v-for="(item, ix) in gradeLevels" 
                                            :key="ix"
                                            :value="item.grade_level">{{ item.grade_level }}</option>
                                        </b-select>
                                    </b-field>
                                </b-field>
                                
                            </div>
                         

                            <div class="column">
                                <div class="buttons is-right">
                                    <b-button
                                        label="Search"
                                        icon-left="magnify"
                                        @click="loadAsyncData"
                                        type="is-primary"></b-button>
                                </div>
                            </div>
                        </div>
                       

                        <div class="buttons is-right mt-3">
                            <b-button tag="a" href="/manage-learners/create"
                                icon-left="plus"
                                class="is-primary is-small">ADD LEARNER</b-button>

                            <b-button tag="a" :href="`/print/print-page-coe?ay=${search.ay}`"
                                icon-left="plus"
                                class="is-primary is-small">GENERATE COE</b-button>
                        </div>

                        <div>
                            <span>TOTAL : {{  total }}</span>
                        </div>
                        <b-table
                            :data="data"
                            :loading="loading"
                            paginated
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

                            <b-table-column field="learner_id" label="ID" sortable v-slot="props">
                                {{ props.row.learner_id }}
                            </b-table-column>

                            <b-table-column field="academic_year_code" label="A.Y. Code" sortable v-slot="props">
                                {{ props.row.academic_year.academic_year_code }}
                            </b-table-column>

                            <b-table-column field="lname" label="Name" sortable v-slot="props">
                                {{ props.row.learner.lname }}, {{ props.row.learner.fname }} {{ props.row.learner.mname }}
                            </b-table-column>

                            <b-table-column field="sex" label="Sex" v-slot="props">
                                {{ props.row.learner.sex }}
                            </b-table-column>

                            <b-table-column field="grade_level" label="Grade Level" v-slot="props">
                                {{ props.row.grade_level }}
                            </b-table-column>

                            <b-table-column field="track_strand" label="Track/Strand" v-slot="props">
                                <span v-if="props.row.track">
                                    {{ props.row.track.track }}
                                </span>

                                <span v-if="props.row.strand">
                                    / {{ props.row.strand.strand }}

                                </span>

                            </b-table-column>

                            <b-table-column field="section" label="Section" v-slot="props">
                                {{ props.row.section.section }}
                            </b-table-column>


                            <b-table-column label="Action" v-slot="props">
                                <!-- <div class="is-flex">
                                    <b-tooltip label="Edit" type="is-warning">
                                        <b-button class="button is-small mr-1" tag="a" icon-right="pencil" @click="getData(props.row.learner_id)"></b-button>
                                    </b-tooltip>
                                    <b-tooltip label="Delete" type="is-danger">
                                        <b-button class="button is-small mr-1" icon-right="delete" @click="confirmDelete(props.row.learner_id)"></b-button>
                                    </b-tooltip>
                
                                </div> -->
                            </b-table-column>
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





    </div>
</template>

<script>

export default{

    data() {
        return{
            data: [],
            total: 0,
            loading: false,
            sortField: 'enrol_id',
            sortOrder: 'desc',
            page: 1,
            perPage: 20,
            defaultSortDirection: 'asc',


            global_id : 0,

            search: {
                ay: '',
                lname: '',
                grade: '',
            },

   
            fields: {},
            errors: {},

            gradeLevels: [],
            academicYears: [],
        }

    },

    methods: {
        /*
        * Load async data
        */
        loadAsyncData() {
            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `ay=${this.search.ay}`,
                `lname=${this.search.lname}`,
                `grade=${this.search.grade}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/get-enrollees?${params}`)
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


        //alert box ask for deletion
        confirmDelete(delete_id) {
            this.$buefy.dialog.confirm({
                title: 'DELETE!',
                type: 'is-danger',
                message: 'Are you sure you want to delete this data?',
                cancelText: 'Cancel',
                confirmText: 'Delete',
                onConfirm: () => this.deleteSubmit(delete_id)
            });
        },
        //execute delete after confirming
        deleteSubmit(delete_id) {
            axios.delete('/manage-learners/' + delete_id).then(res => {
                this.loadAsyncData();
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },

        //update code here
        getData: function(data_id){
            window.location = '/manage-learners/' + data_id + '/edit'
        },


        loadGradeLevels(){
            axios.get('/load-grade-levels').then(res=>{
                this.gradeLevels = res.data
            }).catch(err=>{
            
            })
        },

        loadAcademicYears(){
            axios.get('/load-academic-years').then(res=>{
                this.academicYears = res.data
            }).catch(err=>{
            
            })
        }




    },

    mounted() {
        this.loadAcademicYears()
        this.loadGradeLevels()
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
