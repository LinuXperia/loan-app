<template>
    <div class="card-body text-center">
        <div class="col-sm-6 offset-3">
            <div class="alert alert-danger text-center" v-if="errors">
                <span v-if="errors.approved">{{ errors.approved[0]}}</span>
            </div>
            <div class="alert alert-success text-center" v-if="success">
                <span v-if="success.approved">{{ success.approved[0]}}</span>
            </div>
        </div>

        <div class="row" v-if="payment.approved === null">
            <div class="col-sm-4 offset-1">
                <button class="btn btn-outline-success btn-block mb-4" @click="approve(true)" >APPROVE PAYMENT</button>
            </div>
            <div class="col-sm-4 offset-1">
                <button class="btn btn-danger btn-block" @click="approve(false)">DECLINE PAYMENT</button>
            </div>
        </div>

        <div class="row" v-if="payment.approved !== null">
            <div class="col-sm-6" :class="!payment.approved ? 'offset-3' : ''" v-if="!payment.approved">
                <button class="btn btn-outline-success btn-block mb-4" @click="approve(true)" >APPROVE PAYMENT</button>
            </div>
            <div class="col-sm-6" :class="payment.approved ? 'offset-3' : ''" v-if="payment.approved">
                <button class="btn btn-danger btn-block" @click="approve(false)">DECLINE PAYMENT</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        props: ['paymentDetails'],
        data(){
            return {
                payment:'',
                errors:null,
                success: null,
            }
        },
        methods: {
            convertToJson(){
                this.payment = JSON.parse(this.paymentDetails);
            },
            approve(status){

                let message = status === true ? "Approve Payment" : "Decline Payment"

                let r = confirm('Do you want to ' + message  + '?');

                if(r === true){
                    axios.put('/loans/payment/approve-payment', {
                        id: this.payment.id,
                        status: status,
                    })
                        .then(response => {

                            this.payment.approved = status
                            this.errors = null
                            this.success = response.data.success
                        })
                        .catch(error => {

                            this.success = null
                            this.errors = error.response.data.errors
                        })
                }


            },
        },
        mounted(){
            this.convertToJson()
        }

    }
</script>

<style>
    .mb-4{
        margin-bottom: 0.5rem !important;
    }
</style>