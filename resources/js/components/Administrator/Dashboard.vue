<template>
    <div>
        <div class="welcome-container">

            <!-- <div class="logo-wrapper">
                <img src="/img/tc_division.png" class="division-logo" alt="Division Logo">
                <img src="/img/tcnhs_logo.png" class="tcnhs-logo" alt="TCNHS Logo">
            </div>
           
            <div class="loader-3">
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
            </div>-->

            <div class="columns">
                <div class="column is-6">
                    <div class="buttons">
                        <b-button label="Search" 
                            @click="loadParkingSpaces"
                            type="is-info" icon-right="magnify"></b-button>
                    </div>
                    <div class="report-text" v-for="(park, index) in parkingSpaces" :key="index">
                        <div class="park-container">
                            <div class="p-4">
                                <div>
                                    <div class="has-text-weight-bold is-size-6">
                                        {{ park.name }}
                                    </div>

                                    <div v-if="park.is_occupied === 0">
                                        <div class="available">AVAILABLE</div>
                                        <div>
                                            <b-button class="is-link"
                                                @click="openModalReserveMe(index)"
                                                size="is-small" label="RESERVE ME"></b-button>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <div class="mb-2 occupied">OCCUPIED</div>
                                        <div>
                                            <img src="/img/car.png" style="width: 250px;" alt="">
                                        </div>

                                        <div class="mb-2" v-if="park.user_id === user.user_id">
                                            <button class="button is-success mb-2"
                                                @click="exitPark(index)">
                                                Enter Parking Space
                                            </button>
                                            <button class="button is-warning mb-2"
                                                @click="exitPark(index)">
                                                Exit Parking Space
                                            </button>
                                        </div>
                                        

                                    </div>
                                   
                                </div>
                            </div>
                        </div> 
                    </div> 
                </div>
            </div>
 
        </div> <!--welcome container-->


        <!--modal reserve-->
        <b-modal v-model="modalReserveMe" has-modal-card
                 trap-focus
                 :width="640"
                 aria-role="dialog"
                 aria-label="Modal"
                 aria-modal>

            <form action="/paymongo/pay">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title has-text-weight-bold is-size-5">RESERVE ME</p>
                        <button
                            type="button"
                            class="delete"
                            @click="modalReserveMe = false"/>
                    </header>

                    <section class="modal-card-body">
                        <div class="">
                            <div class="columns">
                                <div class="column">
                                   <!-- <p>To make reservation for this parking area, a payment must be made.</p>-->
                                    <p>PARKING FEE: &#8369;{{ fields.amount }}</p> 

                                    <input type="hidden" name="park" v-model="fields.row">
                                    <input type="hidden" name="user_id" v-model="user.user_id">

                                    <b-field label="Reservation From">
                                        <b-datetimepicker v-model="fields.date_time_reserve_from" name="date_time_reserve_from" 
                                            @input="computeAmount" placeholder="Date and Time Reservation"></b-datetimepicker>
                                    </b-field>

                                    <b-field label="Reservation To">
                                        <b-datetimepicker v-model="fields.date_time_reserve_to" name="date_time_reserve_to" 
                                            @input="computeAmount" placeholder="Date and Time Reservation"></b-datetimepicker>
                                    </b-field>

                                    <b-field label="No. of Hours">
                                        <input type="text" v-model="fields.hr" name="hours" 
                                            @input="computeAmount" placeholder="1" :min="1">
                                    </b-field>

                                    <input type="hidden" name="start" v-model="fields.date_time_reserve_from">
                                    <input type="hidden" name="end" v-model="fields.date_time_reserve_to">

                                   
                                </div>
                            </div>
                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <button
                            class="button is-primary">
                                PAY
                                <b-icon icon="arrow-right" class="ml-2"></b-icon>    
                        </button>
                    </footer>
                </div>
            </form><!--close form-->
        </b-modal>
        <!--close modal-->


    </div>
</template>

<script>
export default {
	data(){
		return{
            info: {},
            parkingSpaces: [],
            reports: [],
            user: [],

            modalReserveMe: false,
            errors: {},
            fields: {
                hr:1,
                amount:20
            },

		}
	},

	methods:{
        loadParkingSpaces(){
            axios.get('/load-parking-spaces').then(res=>{
                this.parkingSpaces = res.data
                
            }).catch(err=>{
            
            })
        },
        loadProfile(){
            axios.get('/load-profile').then(res=>{
                this.user = res.data;
                
            }).catch(err=>{
            
            })
        },

        loadParkReservation(){
            axios.get('/load-parking-reservation').then(res=>{
                console.log(res.data)
            }).catch(err=>{
                
            })
        },

        exitPark(row){
            this.fields.park_id = row
            axios.post('/exit-park',this.fields).then(res=>{
                window.location = '/home';
            }).catch(err=>{

            })
        },


        openModalReserveMe(row){
            this.fields.row = row
            this.modalReserveMe = true
        },
        computeAmount(){
            var a = new Date(this.fields.date_time_reserve_to);
            var b = new Date(this.fields.date_time_reserve_from);
            var hours = Math.abs(b - a) / 36e5;

            //this.fields.amount = this.fields.hr * 20
            this.fields.hr = hours
            this.fields.amount = hours * 20
        },
        
        
	},
    computed:{
       
    },

    mounted() {
    
    this.loadParkingSpaces();
    this.fields;
    this.loadProfile();
    this.loadParkReservation();
    }
}
</script>
<!-- 
<style scoped src="../../../css/admin-home.css">
</style> -->

<style scoped>
.welcome-container{
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
 
}


.park-container{
    border-top: 2px solid #000; /* Set the top border */
    border-left: 2px solid #000; /* Set the left border */
    border-bottom: 2px solid #000; /* Set the bottom border */
    border-right: none; /* No border on the right */
    margin-bottom: 10px;
    height: 220px;
    min-width: 300px;
}


.occupied{
    color: red;
    font-weight: bolder;

}
.available{
    color: green;
    font-weight: bolder;
}

</style>
