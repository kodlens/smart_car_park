<template>
    <div>

        <div class="section">

            <div class="columns is-centered">
                <div class="column is-6">

                    <div class="columns">
                        <div class="column">
                            <h2 style="text-align: center;"> <b> Scan QR here! </b> </h2>
                        </div>
                    </div>

                    <div class="camera">
                        <qrcode-stream :camera="camera" @decode="onDecode" @init="onInit">
                            <div v-if="validationSuccess" class="validation-success">
                                Scanned successfully.
                            </div>

                            <div v-if="validationFailure" class="validation-failure">
                                Nothing found.
                            </div>

                            <div v-if="validationPending" class="validation-pending">
                                Processing...
                            </div>
                        </qrcode-stream>
                    </div>

                   

                    <div class="buttons mt-1 is-centered">
                        <b-button @click="turnCameraOn" label="TURN ON"></b-button>
                        <b-button @click="turnCameraOff" label="TURN OFF"></b-button>
                    </div>

                </div><!--col-->
            </div><!--close div -->


            

        </div><!--section -->

        

    </div><!--root div-->
</template>

<script>
export default {
    data(){
        return{

            isValid: undefined,
            camera: 'off',
            result: null,
            isProcessing: false,

            isModalValidModal: false,

            data: {},

            modalResult: false,

        }
    },

    methods: {

        onInit (promise) {
            promise
                .catch(console.error)
                .then(this.resetValidationState)
        },

        resetValidationState () {
            this.isValid = undefined
        },

        async onDecode (content) {
            //console.log(content);
            this.result = content.split(';');

            this.turnCameraOff();
           

            // pretend it's taking really long
            this.isProcessing = true;
            //await this.timeout(3000);

            axios.post('/decode-qr/'+content).then(res=>{
               this.alertCustom()
            }).catch(err=>{
                this.isProcessing = false;
                this.data = {};
            })
            
           
           

            this.isProcessing = false;
            this.isValid = false;

            //this.isValid = content.startsWith('http') //this will return boolean value

            // some more delay, so users have time to read the message
            await this.timeout(2000);
            this.turnCameraOn()
        },

        turnCameraOn () {
            this.camera = 'auto';
        },

        turnCameraOff () {
            this.camera = 'off'
        },

        timeout (ms) {
            return new Promise(resolve => {
                window.setTimeout(resolve, ms)
            })
        },

        alertCustom() {
                this.$buefy.dialog.alert({
                    title: 'Title Alert',
                    message: 'I have a title, a custom button and <b>HTML</b>!',
                    confirmText: 'Cool!'
                })
        },

    },

    computed: {
        validationPending() {
            return this.isProcessing;
        },

        validationSuccess() {

            return this.isValid === true
        },

        validationFailure() {
            return this.isValid === false
        },
    },

    mounted(){
        this.turnCameraOn()
    }


}
</script>

<style scoped>

.validation-success,
.validation-failure,
.validation-pending {
    position: absolute;
    width: 100%;
    height: 100%;

    background-color: rgba(255, 255, 255, .8);
    text-align: center;
    font-weight: bold;
    font-size: 1.4rem;
    padding: 10px;

    display: flex;
    flex-flow: column nowrap;
    justify-content: center;
}
.validation-success {
    color: green;
}
.validation-failure {
    color: red;
}

.camera{
    margin: auto;
    width:300px;
    height: 300px;
    border: 1px solid gray;
}

.decode-result{
    text-align: center;
}


</style>
