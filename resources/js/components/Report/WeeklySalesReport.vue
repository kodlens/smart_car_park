<template>
    <section>

        <div class="print-page">
            <div class="has-text-weight-bold has-text-centered mb-2">WEEKLY SALES REPORT</div>
            <div class="no-print">

                <div class="is-flex">
                    <b-datepicker
                        class=""
                        v-model="inputdate"
                        placeholder="Click to select..."
                        icon="calendar-today"
                        trap-focus>
                    </b-datepicker>

                    <p class="controls">
                        <b-button @click="loadMonthhlyReport" type="is-primary" icon-right="magnify">
                            LOAD REPORT
                        </b-button>
                    </p>
                </div>

            </div>


            <div class="buttons mt-2 no-print">
                <b-button @click="printPreview" icon-right="printer">
                    PRINT PREVIEW
                </b-button>
            </div>

            <div>
                <table class="table">
                    <tr>
                        <th>Date</th>
                        <th>Sale</th>
                    </tr>
                    <tr v-for="(item, index) in monthlySales" :key="index">
                        <td>{{ new Date(item.start_time).toLocaleString() }}</td>
                        <td> {{ item.price }} </td>
                    </tr>

                    <tr>
                        <td>TOTAL:</td>
                        <td>{{totalSales}}</td>
                    </tr>
                   
                </table>

                

            </div>

        </div>
    </section>
</template>

<script>
export default {
    data(){
        return {
            inputdate: new Date(),
            monthlySales : []
        }
    },

    methods: {


        loadMonthhlyReport(){
            const ndate = this.$formatDate(this.inputdate)

            const params = [
                `inputdate=${ndate}`,
            ].join('&')

            axios.get(`/load-monthly-sales-report?${params}`).then(res=>{
                this.monthlySales = res.data
            })
        },

        printPreview(){
            window.print()
        }
    },

    computed: {
        totalSales(){
            let total = 0;

            this.monthlySales.forEach(item => {
                total += item.price
            })

            return total;
        }
    }
}
</script>


<style scoped>
.print-page{ 
    width: 8.5in;
    margin: 10px auto;
}

@media print {

    .nprint{
        display: none;
    }
    header, footer, aside, nav, form, iframe, input, .datepicker, .controls, .menu, .hero, .adslot {
        display: none;
    }

    .buttons{
        display: none;
    }

    .table {
        margin: auto;
    }

}



</style>