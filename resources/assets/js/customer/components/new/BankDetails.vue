<template>
    <div class="row">
        <div class="col-sm-10 offset-1">
            <div class="alert alert-success text-center" role="alert" v-if="saved">
                Bank Details Saved.
            </div>
            <form  @submit.prevent="submit">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name"> Bank Name  <span class="required">*</span></label>
                            <input type="text" id="name" placeholder="Bank Name" v-model="form.name" class="form-control" v-bind:class="{ 'is-invalid': errors.name }">
                            <small class="invalid-feedback" v-if="errors.name">
                                {{ errors.name[0] }}
                            </small>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="branch"> Bank Branch  <span class="required">*</span></label>
                            <input type="text" id="branch" placeholder="Bank Branch" v-model="form.branch" class="form-control" v-bind:class="{ 'is-invalid': errors.branch }">
                            <small class="invalid-feedback" v-if="errors.branch">
                                {{ errors.branch[0] }}
                            </small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="type"> Bank Account Type  <span class="required">*</span></label>
                            <input type="text" id="type" placeholder="Bank Account Type" v-model="form.type" class="form-control" v-bind:class="{ 'is-invalid': errors.type }">
                            <small class="invalid-feedback" v-if="errors.type">
                                {{ errors.type[0] }}
                            </small>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="facility"> Facility Taken <span class="required">*</span></label>
                            <input type="text" id="facility" placeholder="Facility Taken" v-model="form.facility" class="form-control" v-bind:class="{ 'is-invalid': errors.facility }">
                            <small class="invalid-feedback" v-if="errors.facility">
                                {{ errors.facility[0] }}
                            </small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="amount"> Amount  <span class="required">*</span></label>
                            <input type="number" id="amount" placeholder="Amount" v-model="form.amount" class="form-control" v-bind:class="{ 'is-invalid': errors.amount }">
                            <small class="invalid-feedback" v-if="errors.amount">
                                {{ errors.amount[0] }}
                            </small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 offset-4 ">
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-info" v-if="!disabled">
                                Save Bank Details
                            </button>

                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-sm-4 offset-4 ">
                    <div class="form-group">
                        <button type="submit" class="btn btn-lg btn-outline-secondary" v-if="disabled" @click="anotherBankDetails">
                           Add Another Bank Details
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['clickedNext', 'currentStep'],
        data(){
            return {
                form: {
                    name: '',
                    branch: '',
                    type: '',
                    facility: '',
                    amount: ''
                },
                disabled: false,
                errors: [],
                saved: false,
            }
        },
        methods: {
            submit(){

                let self = this;

                if (Vue.localStorage.get('userId') !== null) {

                    let user_id = Vue.localStorage.get('userId')

                    axios.post('/customer/customer-bank-details', {

                        id: user_id,
                        name: this.form.name,
                        branch: this.form.branch,
                        type: this.form.type,
                        facility: this.form.facility,
                        amount: this.form.amount,
                    })
                        .then(function (response) {

                            if (response.data.id == user_id) {

                                self.saved = true

                                self.errors = []

                                self.disabled = true
                                self.$emit('can-continue', {value: true});

                            } else {


                                self.$emit('can-continue', {value: false});
                            }


                        })
                        .catch(function (error) {

                            self.errors= error.response.data.errors

                            self.$emit('can-continue', {value: false});

                        });
                } else {
                    console.log('no user id')
                }

            },
            anotherBankDetails(){

                let r = confirm('Add Another Bank Account?')

                if (r == true) {
                    this.form.name = '';
                    this.form.branch = '';
                    this.form.type = '';
                    this.form.facility = '';
                    this.form.amount = '';

                    this.disabled = false
                    this.saved = false

                    this.$emit('can-continue', {value: false});
                }

            }
        },
    }
</script>
<style lang="scss">
    small.invalid-feedback{
        color: red;
        font-size: 10px;
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