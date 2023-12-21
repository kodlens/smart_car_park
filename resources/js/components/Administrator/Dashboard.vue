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
                                                size="is-small" label="RESERVE ME"></b-button>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <div class="mb-2 occupied">OCCUPIED</div>
                                        <div>
                                            <img src="/img/car.png" style="width: 250px;" alt="">
                                        </div>

                                    </div>
                                   
                                </div>
                            </div>
                        </div> 
                    </div> 
                </div>
            </div>
 
        </div>
    </div>
</template>

<script>
export default {
	data(){
		return{
            info: {},
            parkingSpaces: [],
            reports: [],

		}
	},

	methods:{
        loadParkingSpaces(){
            axios.get('/load-parking-spaces').then(res=>{
                this.parkingSpaces = res.data
            }).catch(err=>{
            
            })
        }
	},

    mounted() {
    this.loadParkingSpaces()
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
    height: 200px;
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
