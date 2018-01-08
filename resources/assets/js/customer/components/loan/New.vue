<template>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-success text-center" v-if="saved">
                    <h4>Total Amount To Pay: <strong>KSH. {{ total_amount }}</strong></h4>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="alert alert-info text-center" v-if="!saved">
                    <h4>Amount To Pay: <strong>KSH. {{ calculateLoan }}</strong></h4>
                </div>
            </div>
        </div>
        <form class="form-horizontal" @submit.prevent="submit">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="type">Loan Type <span class="required"> *</span></label>
                <div class="col-sm-10">
                    <select name="type" id="type" class="form-control" v-bind:class="{ 'is-invalid': errors.type }" v-model="form.type" :disabled="disabled">
                        <option value="">Select Loan Type</option>
                        <option value="Loan Against Log Book">Loan Against Log Book</option>
                    </select>
                    <small class="invalid-feedback" v-if="errors.type">
                        {{ errors.type[0] }}
                    </small>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="amount">Borrowed Amount <span class="required"> *</span></label>
                <div class="col-sm-10">
                    <input type="number"  id="amount" class="form-control" v-bind:class="{ 'is-invalid': errors.amount }" v-model="form.amount" :disabled="disabled">
                    <small class="invalid-feedback" v-if="errors.amount">
                        {{ errors.amount[0] }}
                    </small>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="rate" data-toggle="tooltip" data-placement="top" title="eg: 5 for 5%">Interest Rate <span class="required"> *</span></label>
                <div class="col-sm-10">
                    <input type="number"  id="rate" class="form-control" v-bind:class="{ 'is-invalid': errors.rate }" v-model="form.rate" :disabled="disabled">
                    <small class="invalid-feedback" v-if="errors.rate">
                        {{ errors.rate[0] }}
                    </small>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="duration" data-toggle="tooltip" data-placement="top" title="duration in months">Duration <span class="required"> *</span></label>
                        <div class="col-sm-8">
                            <input type="number"  id="duration" class="form-control" v-bind:class="{ 'is-invalid': errors.duration }" v-model="form.duration" @change="calculateDuration" placeholder="Number of months" :disabled="disabled">
                            <small class="invalid-feedback" v-if="errors.duration">
                                {{ errors.duration[0] }}
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="payment_date">Payment Date <span class="required"> *</span></label>
                        <div class="col-sm-8">
                            <input type="text"  id="payment_date" class="form-control" v-bind:class="{ 'is-invalid': errors.payment_date }" v-model="form.payment_date" disabled>
                            <small class="invalid-feedback" v-if="errors.payment_date">
                                {{ errors.payment_date[0] }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="processing_fee">Processing Fee <span class="required"> *</span></label>
                        <div class="col-sm-8">
                            <input type="number"  id="processing_fee" class="form-control" v-bind:class="{ 'is-invalid': errors.processing_fee }" v-model="form.processing_fee" :disabled="disabled">
                            <small class="invalid-feedback" v-if="errors.processing_fee">
                                {{ errors.processing_fee[0] }}
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="legal_fee">Legal Fee <span class="required"> *</span></label>
                        <div class="col-sm-8">
                            <input type="number"  id="legal_fee" class="form-control" v-bind:class="{ 'is-invalid': errors.legal_fee }" v-model="form.legal_fee" :disabled="disabled">
                            <small class="invalid-feedback" v-if="errors.legal_fee">
                                {{ errors.legal_fee[0] }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="car_track">Car Track Installation <span class="required"> *</span></label>
                        <div class="col-sm-8">
                            <input type="number"  id="car_track" class="form-control" v-bind:class="{ 'is-invalid': errors.car_track }" v-model="form.car_track" :disabled="disabled">
                            <small class="invalid-feedback" v-if="errors.car_track">
                                {{ errors.car_track[0] }}
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="car_track_maintenance">Car Track Maintenance <span class="required"> *</span></label>
                        <div class="col-sm-8">
                            <input type="number"  id="car_track_maintenance" class="form-control" v-bind:class="{ 'is-invalid': errors.car_track_maintenance }" v-model="form.car_track_maintenance" :disabled="disabled">
                            <small class="invalid-feedback" v-if="errors.car_track_maintenance">
                                {{ errors.car_track_maintenance[0] }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="logistics">Logistics Fee <span class="required"> *</span></label>
                        <div class="col-sm-8">
                            <input type="number"  id="logistics" class="form-control" v-bind:class="{ 'is-invalid': errors.logistics }" v-model="form.logistics" :disabled="disabled">
                            <small class="invalid-feedback" v-if="errors.logistics">
                                {{ errors.logistics[0] }}
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="kra_search">KRA Search <span class="required"> *</span></label>
                        <div class="col-sm-8">
                            <input type="number"  id="kra_search" class="form-control" v-bind:class="{ 'is-invalid': errors.kra_search }" v-model="form.kra_search" :disabled="disabled">
                            <small class="invalid-feedback" v-if="errors.kra_search">
                                {{ errors.kra_search[0] }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="mv">MV Transfer Fee <span class="required"> *</span></label>
                        <div class="col-sm-8">
                            <input type="number"  id="mv" class="form-control" v-bind:class="{ 'is-invalid': errors.mv }" v-model="form.mv" :disabled="disabled">
                            <small class="invalid-feedback" v-if="errors.mv">
                                {{ errors.mv[0] }}
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="discharge_fee">Discharge Fee <span class="required"> *</span></label>
                        <div class="col-sm-8">
                            <input type="number"  id="discharge_fee" class="form-control" v-bind:class="{ 'is-invalid': errors.discharge_fee }" v-model="form.discharge_fee" :disabled="disabled">
                            <small class="invalid-feedback" v-if="errors.discharge_fee">
                                {{ errors.discharge_fee[0] }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="remarks">Remarks</label>
                <div class="col-sm-10">
                    <textarea  id="remarks"  class="form-control" v-bind:class="{ 'is-invalid': errors.remarks }" v-model="form.remarks" :disabled="disabled"></textarea>
                    <small class="invalid-feedback" v-if="errors.remarks">
                        {{ errors.remarks[0] }}
                    </small>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 offset-3" v-if="!saved">
                    <button type="submit" class="btn btn-info btn-block">Submit Loan Details</button>
                </div>
            </div>

        </form>
        <div class="row">
            <div class="col-sm-6 offset-3" v-if="saved">
                <button class="btn btn-outline-secondary btn-block" @click="editForm">Edit Loan Details</button>
            </div>
        </div>
        <hr class="style4">
        <uploads :loan = "loan" v-if=" loan !== ''"></uploads>
    </div>
</template>
<script>
    import moment from 'moment'
    import Uploads from './Uploads.vue'
    export default{
        props: ['customerDetails','agentDetails'],
        components: {
            Uploads
        },

        data(){
            return {
                customer: '',
                agent: '',
                errors:[],
                total_amount: '0.00',
                saved:false,
                disabled:false,
                loan:'',
                form: {
                    type: '',
                    amount:'0.00',
                    rate:'0',
                    duration:'',
                    payment_date:'',
                    processing_fee: '0.00',
                    legal_fee: '0.00',
                    car_track: '0.00',
                    car_track_maintenance: '0.00',
                    kra_search: '0.00',
                    logistics: '0.00',
                    mv: '0.00',
                    discharge_fee: '0.00',
                    remarks:''
                }
            }
        },
        methods: {
            convertToJson(){
                this.customer = JSON.parse(this.customerDetails)
                this.agent = JSON.parse(this.agentDetails)
            },

            editForm(){
                let r = confirm('Do you want to Edit Loan Details?')

                if(r == true){
                    if(this.disabled === true && this.loan !== ''){

                        this.disabled = false
                        this.saved=false
                    }
                }
            },

            calculateDuration(){

                if(this.form.duration > 0 && this.form.duration < 4){

                    var pay_date = moment().add(this.form.duration, 'months').calendar();
                    this.form.payment_date = pay_date;
                    this.errors=[]

                }else {
                    var error = []
                        error['duration'] =  ['This duration time is invalid!']
                    this.errors = error
                }
            },
            formatMoney(x){
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            },

            submit(){

                if(this.loan !== ''){

                    //update loan details
                    axios.post('/loans/loan-details-update', {
                        loan_id: this.loan,
                        amount: this.form.amount,
                        type: this.form.type,
                        rate: parseInt(this.form.rate),
                        duration: this.form.duration,
                        payment_date: this.form.payment_date,
                        processing_fee: this.form.processing_fee,
                        legal_fee: this.form.legal_fee,
                        car_track: this.form.car_track,
                        car_track_maintenance: this.form.car_track_maintenance,
                        kra_search: this.form.kra_search,
                        logistics: this.form.logistics,
                        mv: this.form.mv,
                        discharge_fee: this.form.discharge_fee,
                        remarks: this.form.remarks,
                        total_amount: this.total_amount
                    })
                    .then((response) =>{

                        this.loan = response.data.data

                        this.errors=[]

                        console.log(this.loan)
                        this.disabled = true
                        this.saved = true
                    })
                    .catch((error) => {

                        this.errors = error.response.data.errors
                    })
                }else {

                    //new loan details
                    axios.post('/loans/loan-details', {
                        user_id: this.customer.id,
                        agent_id: this.agent.id,
                        amount: this.form.amount,
                        type: this.form.type,
                        rate: parseInt(this.form.rate),
                        duration: this.form.duration,
                        payment_date: this.form.payment_date,
                        processing_fee: this.form.processing_fee,
                        legal_fee: this.form.legal_fee,
                        car_track: this.form.car_track,
                        car_track_maintenance: this.form.car_track_maintenance,
                        kra_search: this.form.kra_search,
                        logistics: this.form.logistics,
                        mv: this.form.mv,
                        discharge_fee: this.form.discharge_fee,
                        remarks: this.form.remarks,
                        total_amount: this.total_amount
                    })
                    .then((response) =>{

                        this.loan = response.data.data

                        this.errors=[]

                        console.log(this.loan)
                        this.disabled = true
                        this.saved = true
                    })
                    .catch((error) => {

                        this.errors = error.response.data.errors
                    })
                }
            }

        },
        computed: {
            calculateLoan(){

                let totalAmount = 0;

                if(this.form.amount > 0 && this.form.rate > 0 && this.form.duration > 0){

                    var principal =parseInt( this.form.amount)
                    var rate = parseInt(this.form.rate) / 100
                    var duration = parseInt(this.form.duration)

                    totalAmount = ((rate * principal) * duration) + principal

                    if(this.form.processing_fee > 0){
                        totalAmount = totalAmount + parseInt(this.form.processing_fee)
                    }
                    if(this.form.legal_fee > 0){
                        totalAmount = totalAmount + parseInt(this.form.legal_fee)
                    }
                    if(this.form.car_track > 0){
                        totalAmount = totalAmount + parseInt(this.form.car_track)
                    }
                    if(this.form.car_track_maintenance > 0){
                        totalAmount = totalAmount + parseInt(this.form.car_track_maintenance)
                    }
                    if(this.form.kra_search > 0){
                        totalAmount = totalAmount + parseInt(this.form.kra_search)
                    }
                    if(this.form.logistics > 0){
                        totalAmount = totalAmount + parseInt(this.form.logistics)
                    }
                    if(this.form.mv > 0){
                        totalAmount = totalAmount + parseInt(this.form.mv)
                    }
                    if(this.form.discharge_fee > 0){
                        totalAmount = totalAmount + parseInt(this.form.discharge_fee)
                    }
                }


               return this.formatMoney(this.total_amount = totalAmount);
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