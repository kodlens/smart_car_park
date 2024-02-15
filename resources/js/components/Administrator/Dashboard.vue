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
                                    <!-- {{ loadParkReservation(park.par_id) }} -->

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

                                        <div class="mb-2" v-if="park.parkReservation">
                                            <button class="button is-success mb-2"
                                                @click="displayQr(index)"
                                                v-if="(park.parkReservation.enter_time == null) && (park.parkReservation.user_id == user.user_id)">
                                                Enter Parking Space
                                            </button>
                                            <button class="button is-warning mb-2"
                                                v-if="(park.parkReservation.enter_time !== null) && (park.parkReservation.user_id == user.user_id)"
                                                @click="displayQr(index)">
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
                                        <b-datetimepicker v-model="fields.date_time_reserve_from" editable name="date_time_reserve_from" 
                                            @input="computeAmount" placeholder="Date and Time Reservation"></b-datetimepicker>
                                    </b-field>

                                    <b-field label="Reservation To">
                                        <b-datetimepicker v-model="fields.date_time_reserve_to" editable name="date_time_reserve_to" 
                                            @input="computeAmount" placeholder="Date and Time Reservation"></b-datetimepicker>
                                    </b-field>

                                    <b-field label="No. of Hours">
                                        <b-input type="text" v-model="fields.hr" name="hours" 
                                            @input="computeAmount" readonly placeholder="1" :min="1" />
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

        <b-modal v-model="modalQR" has-modal-card
                 trap-focus
                 :width="640"
                 aria-role="dialog"
                 aria-label="Modal"
                 aria-modal>
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title has-text-weight-bold is-size-5">RESERVATION QR</p>
                        <button
                            type="button"
                            class="delete"
                            @click="loadParkingSpaces"/>
                    </header>

                    <section class="modal-card-body">
                        <div class="">
                            <div class="columns">
                                <div class="column">
                                    <div class="qr">
                                        <qrcode :value="qr" :options="{ width: 400 }"></qrcode>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <button
                            @click="loadParkingSpaces"
                            class="button is-primary">
                                done
                                <b-icon icon="arrow-right" class="ml-2"></b-icon>    
                        </button>
                    </footer>
                </div>
        </b-modal>


    </div>
</template>

<script>
export default {

 
	data(){

        const currentDate = new Date();
    
		return{
            info: {},
            parkingSpaces: [],
            reports: [],
            user: [],

            modalReserveMe: false,
            modalQR: false,
            errors: {},
            fields: {
                date_time_reserve_from: currentDate,
                date_time_reserve_to: new Date(currentDate.getTime() + (1 * 60 * 60 * 1000)), // Add 1 hour

                hr:1,
                amount:20
            },
            qr: null
		}
	},

	methods:{
        loadParkingSpaces(){
            axios.get('/load-parking-spaces').then(res=>{
                this.parkingSpaces = res.data
                this.modalQR = false
                
            }).catch(err=>{
            
            })
        },
        loadProfile(){
            axios.get('/load-profile').then(res=>{
                this.user = res.data;
                
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
        displayQr(index){
            this.qr = this.parkingSpaces[index].parkReservation.qr_ref;
            this.modalQR = true;
        }
        
        
	},
    computed:{
        qrCode(){
            return this.parkReserved.qr_ref;
        }
    },

    mounted() {
    
    this.loadParkingSpaces();
    this.fields;
    this.loadProfile();
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
.qr{
    display: flex;
    justify-content: center;
}

</style>
