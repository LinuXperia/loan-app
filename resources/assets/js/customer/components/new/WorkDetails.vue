<template>
    <div class="row">
        <div class="col-sm-10 offset-1">
            <div>
                <div class="row">
                    <div :class="['col-sm-12 form-group']">
                        <h4 class="text-center">SELECT EMPLOYED OR SELF EMPLOYED</h4>
                        <select id="type" class="form-control" v-model="type" v-on:change="workType">
                            <option disabled value="">SELECT EMPLOYED OR SELF EMPLOYED</option>
                            <option value="employed">EMPLOYED</option>
                            <option value="self">SELF EMPLOYED</option>
                        </select>

                    </div>
                </div>
            </div>

            <hr>


            <div v-if="showSelf">

                <div class="alert alert-success text-center" role="alert" v-if="saved">
                    Business Details Saved.
                </div>

                <form  @submit.prevent="submit">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="business_name"> Business Name<span class="required">*</span></label>
                                <input type="text" id="business_name" placeholder="Business Name" v-model="form.business_name" class="form-control" v-bind:class="{ 'is-invalid': errors.business_name }">
                                <small class="invalid-feedback" v-if="errors.business_name">
                                    {{ errors.business_name[0] }}
                                </small>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="b_address"> Business Address<span class="required">*</span></label>
                                <input type="text" id="b_address" placeholder="Business Address" v-model="form.address" class="form-control" v-bind:class="{ 'is-invalid': errors.address }">
                                <small class="invalid-feedback" v-if="errors.address">
                                    {{ errors.address[0] }}
                                </small>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="b_years"> Business Time<span class="required">*</span></label>
                                <input type="number" id="b_years" placeholder="How long have you been in the business" v-model="form.years" class="form-control" v-bind:class="{ 'is-invalid': errors.years }">
                                <small class="invalid-feedback" v-if="errors.years">
                                    {{ errors.years[0] }}
                                </small>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="b_phone"> Business Phone<span class="required">*</span></label>
                                <input type="text" id="b_phone" placeholder="Business Phone" v-model="form.phone" class="form-control" v-bind:class="{ 'is-invalid': errors.phone }">
                                <small class="invalid-feedback" v-if="errors.phone">
                                    {{ errors.phone[0] }}
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="business_name"> Business physical address <span class="required">*</span></label>
                                <input type="text" id="physical_address" placeholder="Business physical address" v-model="form.physical_address" class="form-control" v-bind:class="{ 'is-invalid': errors.physical_address }">
                                <small class="invalid-feedback" v-if="errors.physical_address">
                                    {{ errors.physical_address[0] }}
                                </small>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="gross"> Gross Annual Income<span class="required">*</span></label>
                                <input type="text" id="gross" placeholder="Gross Annual Income" v-model="form.gross" class="form-control" v-bind:class="{ 'is-invalid': errors.gross }">
                                <small class="invalid-feedback" v-if="errors.gross">
                                    {{ errors.gross[0] }}
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="nature">Nature of Business <span class="required">*</span></label>
                                <textarea id="nature" placeholder="Describe Nature of Business" v-model="form.nature" class="form-control" v-bind:class="{ 'is-invalid': errors.nature }"></textarea>
                                <small class="invalid-feedback" v-if="errors.nature">
                                    {{ errors.nature[0] }}
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 offset-4 ">
                            <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-info" v-if="!disabled">
                                    Save Business Details
                                </button>

                            </div>
                        </div>
                    </div>
                </form>

            </div>

            <div v-if="showEmployed">
                <div class="alert alert-success text-center" role="alert" v-if="saved">
                    Work Details Saved.
                </div>

                <form  @submit.prevent="submit">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="employer"> Employer <span class="required">*</span></label>
                                <input type="text" id="employer" placeholder="Employer Name" v-model="form.employer" class="form-control" v-bind:class="{ 'is-invalid': errors.employer }">
                                <small class="invalid-feedback" v-if="errors.employer">
                                    {{ errors.employer[0] }}
                                </small>
                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="years"> Number of Years with Employers <span class="required">*</span></label>
                                <input type="number" id="years" placeholder="Number of Years with Employers" v-model="form.years" class="form-control" v-bind:class="{ 'is-invalid': errors.years }">
                                <small class="invalid-feedback" v-if="errors.years">
                                    {{ errors.years[0] }}
                                </small>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="address"> Work Address <span class="required">*</span></label>
                                <input type="text" id="address" placeholder="Work Address" v-model="form.address" class="form-control" v-bind:class="{ 'is-invalid': errors.address }">
                                <small class="invalid-feedback" v-if="errors.address">
                                    {{ errors.address[0] }}
                                </small>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="phone"> Phone <span class="required">*</span></label>
                                <input type="number" id="phone" placeholder="Work phone" v-model="form.phone" class="form-control" v-bind:class="{ 'is-invalid': errors.phone }">
                                <small class="invalid-feedback" v-if="errors.phone">
                                    {{ errors.phone[0] }}
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="occupation"> Occupation <span class="required">*</span></label>
                                <input type="text" id="occupation" placeholder="Occupation" v-model="form.occupation" class="form-control" v-bind:class="{ 'is-invalid': errors.occupation }">
                                <small class="invalid-feedback" v-if="errors.occupation">
                                    {{ errors.occupation[0] }}
                                </small>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="previous_employer"> Previous Employer <span class="required">*</span></label>
                                <input type="text" id="previous_employer" placeholder="Previous Employer" v-model="form.previous_employer" class="form-control" v-bind:class="{ 'is-invalid': errors.previous_employer }">
                                <small class="invalid-feedback" v-if="errors.previous_employer">
                                    {{ errors.previous_employer[0] }}
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="tenure">Tenure <span class="required"> *</span></label>
                                <select name="tenure" id="tenure" v-model="form.tenure" class="form-control" v-bind:class="{ 'is-invalid': errors.tenure }">
                                    <option value="">TENURE</option>
                                    <option value="contact">CONTRACT</option>
                                    <option value="permanent">PERMANENT</option>
                                </select>
                                <small class="invalid-feedback" v-if="errors.tenure">
                                    {{ errors.tenure[0] }}
                                </small>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 offset-4 ">
                            <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-info" v-if="!disabled">
                                    Save Work Details
                                </button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

</template>

<script>

    export default {
        props: ['clickedNext', 'currentStep'],

        data(){
            return{
                form: {
                    employer: '',
                    business_name:'',
                    years: '',
                    address: '',
                    physical_address:'',
                    phone: '',
                    occupation: '',
                    tenure: '',
                    previous_employer: '',
                    gross: '',
                    nature:''
                },
                disabled: false,
                errors: [],
                saved:false,
                type: '',
                showSelf: false,
                showEmployed: false
            }
        },
        methods:{
            submit(){

                let self = this;

                if(Vue.localStorage.get('userId') !== null){

                    let user_id = Vue.localStorage.get('userId')

                    if(self.type == 'self'){
                        //self employed

                        axios.post('/customer/customer-self-employment-details', {

                            id: user_id,
                            employment_type: self.type,
                            business_name: self.form.business_name,
                            years: self.form.years,
                            address: self.form.address,
                            phone: self.form.phone,
                            physical_address: self.form.physical_address,
                            gross: self.form.gross,
                            nature: self.form.nature,

                        })
                        .then(function (response) {

                            if(response.data.id == user_id){

                                self.saved = true
                                self.errors = []
                                self.disabled = true
                                self.$emit('can-continue', {value: true});
                            }else {
                                console.log('error in user id')
                            }

                        })
                        .catch(function (error) {

                            self.errors= error.response.data.errors

                            self.$emit('can-continue', {value: false});

                        });

                    }else if (self.type == 'employed'){

                        //employed
                        axios.post('/customer/customer-work-details', {

                            id: user_id,
                            employment_type: self.type,
                            employer: self.form.employer,
                            years: self.form.years,
                            address: self.form.address,
                            phone: self.form.phone,
                            occupation: self.form.occupation,
                            tenure: self.form.tenure,
                            previous_employer: self.form.previous_employer,

                        })
                        .then(function (response) {

                            if(response.data.id == user_id){

                                self.saved = true
                                self.errors = []
                                self.disabled = true
                                self.$emit('can-continue', {value: true});
                            }else {
                                console.log('error in user id')
                            }


                        })
                        .catch(function (error) {

                            self.errors= error.response.data.errors

                            self.$emit('can-continue', {value: false});

                        });
                    }else {
                        console.log('error in type');
                    }


                }else {
                    console.log('no user id')
                }
            },
            workType(){

                if(this.type == 'self'){

                    this.showEmployed = false
                    this.showSelf = true

                }else if (this.type == 'employed'){

                    this.showSelf = false
                    this.showEmployed = true
                }
            }

        },
    }
</script>
<style lang="scss">
    small.help-block{
        color: red;
    }
    label{
        margin-bottom: .1rem;
        font-size: 12px;

        span.required{
            color: #f9100a;
        }
    }
    .stepper-box .bottom .stepper-button.previous, .stepper-box .top .stepper-button-top.previous{
        z-index: -200;
    }
</style>