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

            <div class="report-text">
                <div class="box">
                    <div class="p-4">
                        <div>
                            <div class="has-text-weight-bold is-size-4 report-title">NO. OF ENROLLEES</div>
                            <table class="report-table">
                                <tr v-for="(item, index) in reports" :key="index">
                                    <td>{{ item.strand }}</td>
                                    <td>{{ item.no_enrolee }}</td>
                                </tr>
                            </table>
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

            reports: [],

		}
	},

	methods:{

        loadReport(){
            axios.get('/load-reports').then(res=>{
                this.reports = res.data
            })
        }
	},

    mounted() {
        this.loadReport()
    }
}
</script>

<style scoped src="../../../css/admin-home.css">
</style>
