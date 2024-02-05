<template>
    <div>

        <div class="section">

            <div class="columns is-centered">
                <div class="column is-6">

                    <div class="columns">
                        <div class="column">
                            <h2> <b> How to get your QR code? </b> </h2>
                            <ol type="1" class="m-3">
                                <li>Login to your student <a href="http://mygadtc.gadtc.edu.ph/login">portal</a>.</li>
                                <li>Below the enroll button are your QR code. </li>
                                <li>Scan the QR code using the camera.</li>  
                            </ol>   
                        </div>
                    </div>

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

            axios.post('/submit-details/', {
                student_id : this.result[0].split(':')[1],
                fullname : this.result[1].split(':')[1],
                program : this.result[3].split(':')[1].split('-')[0],
                year_level : this.result[3].split(':')[1].split('-')[1],
                contact_no : this.result[2].split(':')[1],
            }).then(res=>{
               this.alertBox()
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

        alertBox(){
            this.$buefy.snackbar.open({
                message: "Successfully scanned.",
                position: 'is-top',
            })
        }

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
