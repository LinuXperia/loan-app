<template>

    <div class="card-body">
        <div class="row">

            <div class="col-sm-12">
                <div class="alert alert-success text-center" v-if="saved">
                    <h4>Payment Successful: <strong>LOAN BALANCE: KSH. {{ balance }}</strong></h4>
                    <p>Wait for admin payment approval.</p>
                </div>
            </div>
        </div>
        <form class="form-horizontal" @submit.prevent="submit">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="reference_no">LOAN REFERENCE </label>
                <div class="col-sm-10">
                    <input type="text"  id="reference_no" class="form-control" disabled :value="loanDetails.reference_no" v-bind:class="{ 'is-invalid': errors.reference_no }">
                    <small class="invalid-feedback" v-if="errors.reference_no">
                        {{ errors.reference_no[0] }}
                    </small>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="amount">PAYMENT AMOUNT <span class="required"> *</span></label>
                <div class="col-sm-10">
                    <input type="number"  id="amount" class="form-control" v-bind:class="{ 'is-invalid': errors.amount }" v-model="form.amount" :disabled="disabled">
                    <small class="invalid-feedback" v-if="errors.amount">
                        {{ errors.amount[0] }}
                    </small>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="mode">PAYMENT MODE <span class="required"> *</span></label>
                        <div class="col-sm-8">
                            <select name="" id="mode" v-model="form.mode" class="form-control" :disabled="disabled" v-bind:class="{ 'is-invalid': errors.duration }">
                                <option value="cash">CASH</option>
                                <option value="mpesa">MPESA</option>
                                <option value="cheque">CHEQUE</option>
                            </select>
                            <small class="invalid-feedback" v-if="errors.mode">
                                {{ errors.mode[0] }}
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group row" v-if="form.mode == 'mpesa'">
                        <label class="col-sm-4 col-form-label" for="mpesa">MPESA NUMBER <span class="required"> *</span></label>
                        <div class="col-sm-8">
                            <input type="text"  id="mpesa" class="form-control" v-bind:class="{ 'is-invalid': errors.mpesa }" v-model="form.mpesa" :disabled="disabled">
                            <small class="invalid-feedback" v-if="errors.mpesa">
                                {{ errors.mpesa[0] }}
                            </small>
                        </div>
                    </div>
                    <div class="form-group row" v-if="form.mode == 'cheque'">
                        <label class="col-sm-4 col-form-label" for="cheque">CHEQUE NUMBER <span class="required"> *</span></label>
                        <div class="col-sm-8">
                            <input type="text"  id="cheque" class="form-control" v-bind:class="{ 'is-invalid': errors.cheque }" v-model="form.cheque" :disabled="disabled">
                            <small class="invalid-feedback" v-if="errors.cheque">
                                {{ errors.cheque[0] }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="description">DESCRIPTION <span class="required"> *</span></label>
                <div class="col-sm-10">
                    <textarea  id="description" class="form-control" v-bind:class="{ 'is-invalid': errors.description }" v-model="form.description" :disabled="disabled"></textarea>
                    <small class="invalid-feedback" v-if="errors.description">
                        {{ errors.description[0] }}
                    </small>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 offset-3" v-if="!saved">
                    <button type="submit" class="btn btn-info btn-block">Submit Loan Payment Details</button>
                </div>
            </div>

        </form>
        <div class="row">
            <div class="col-sm-6 offset-3" v-if="saved">
                <button class="btn btn-outline-secondary btn-block" @click="editForm">Edit Loan Payment Details</button>
            </div>
        </div>
        <hr class="style4">
        <uploads :payment = "payment" v-if="payment !== '' && form.mode == 'cheque'"></uploads>
    </div>
</template>
<script>
    import moment from 'moment'
    import Uploads from './Uploads.vue'
    export default{
        props: ['loan'],
        components: {
            Uploads
        },

        data(){
            return {
                errors:[],
                saved:false,
                disabled:false,
                payment:'',
                loanDetails:'',
                balance: '',
                form: {
                    amount:'0.00',
                    mode: 'cash',
                    cheque: '',
                    mpesa: '',
                    description: ''
                }
            }
        },
        methods: {
            convertToJson(){
                this.loanDetails = JSON.parse(this.loan)
            },

            editForm(){
                let r = confirm('Do you want to Edit Loan Payment Details?')

                if(r == true){
                    if(this.disabled === true && this.loan !== ''){

                        this.disabled = false
                        this.saved=false
                    }
                }
            },
            formatMoney(x){
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            },

            submit(){

                if(this.form.mode == 'mpesa'){
                    this.form.cheque = '';
                }

                if(this.form.mode == 'cheque'){

                    this.form.mpesa = '';
                }

                if(this.payment !== ''){

                    //update loan details

                    axios.put('/loans/payment/payment-details-update', {
                        payment_id: this.payment,
                        amount: this.form.amount,
                        mode: this.form.mode,
                        mpesa: this.form.mpesa,
                        cheque: this.form.cheque,
                        description: this.form.description
                    })
                    .then((response) =>{

                        this.payment = response.data.data.payment_id
                        this.balance = response.data.data.balance

                        this.errors=[]

                        this.disabled = true
                        this.saved = true
                    })
                    .catch((error) => {

                        this.errors = error.response.data.errors
                    })
                }else {

                    //new loan details
                    axios.post('/loans/payment/payment-details', {
                        loan_id: this.loanDetails.id,
                        amount: this.form.amount,
                        mode: this.form.mode,
                        mpesa: this.form.mpesa,
                        cheque: this.form.cheque,
                        description: this.form.description
                    })
                    .then((response) =>{

                        this.payment = response.data.data.payment_id
                        this.balance = response.data.data.balance

                        this.errors=[]

                        this.disabled = true
                        this.saved = true
                    })
                    .catch((error) => {

                        this.errors = error.response.data.errors
                    })
                }
            }

        },
        mounted(){
            this.convertToJson()
        },
    }
</script>
<style lang="scss" scoped>

    label{
        span.required{
            color: red
        }
        hr.style4 {
            border-top: 1px dotted #8c8b8b;
        }
    }
</style>