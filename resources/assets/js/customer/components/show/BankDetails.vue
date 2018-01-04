<template>
    <div class="row">
        <div class="col-sm-10 offset-1">
            <div class="alert alert-success text-center" role="alert" v-if="saved">
                Bank Details Saved.
            </div>
            <div v-for="(formDetail, index) in formDetails">
                <form  @submit.prevent="submit">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name"> Bank Name  <span class="required">*</span></label>
                                <input type="text" id="name" placeholder="Bank Name" v-model="formDetail.name" class="form-control" v-bind:class="{ 'is-invalid': errors.name }" :disabled="disabled">
                                <small class="invalid-feedback" v-if="errors.name">
                                    {{ errors.name[0] }}
                                </small>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="branch"> Bank Branch  <span class="required">*</span></label>
                                <input type="text" id="branch" placeholder="Bank Branch" v-model="formDetail.branch" class="form-control" v-bind:class="{ 'is-invalid': errors.branch }" :disabled="disabled">
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
                                <input type="text" id="type" placeholder="Bank Account Type" v-model="formDetail.type" class="form-control" v-bind:class="{ 'is-invalid': errors.type }" :disabled="disabled">
                                <small class="invalid-feedback" v-if="errors.type">
                                    {{ errors.type[0] }}
                                </small>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="facility"> Facility Taken <span class="required">*</span></label>
                                <input type="text" id="facility" placeholder="Facility Taken" v-model="formDetail.facility" class="form-control" v-bind:class="{ 'is-invalid': errors.facility }" :disabled="disabled">
                                <small class="invalid-feedback" v-if="errors.facility">
                                    {{ errors.facility[0] }}
                                </small>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" v-model="formDetail.id">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="amount"> Amount  <span class="required">*</span></label>
                                <input type="number" id="amount" placeholder="Amount" v-model="formDetail.amount" class="form-control" v-bind:class="{ 'is-invalid': errors.amount }" :disabled="disabled">
                                <small class="invalid-feedback" v-if="errors.amount">
                                    {{ errors.amount[0] }}
                                </small>
                            </div>
                        </div>
                        <!--<div class="col-sm-6 ">
                            <button  class="btn btn-outline-info btn-sm float-sm-right mt-4" @click.prevent="editForm(index)" v-if="disabled">
                                Edit Bank Details
                            </button>
                            <button type="submit" class="btn btn-outline-success btn-sm float-sm-right mt-4" v-if="!disabled">
                                Update Bank Details
                            </button>
                        </div>-->
                    </div>
                </form>
                <hr>
            </div>

            <div class="row">
                <div class="col-sm-4 offset-4 ">
                    <div class="form-group">
                       <!-- <button type="submit" class="btn btn-lg btn-outline-secondary" v-if="disabled" @click="anotherBankDetails">
                            Add Another Bank Details
                        </button>-->

                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['bankDetails'],
        data(){
            return {
                formDetails:'',
                formDetail:'',
                disabled: true,
                errors: [],
                saved: false,
            }
        },
        methods: {
            convetToJson(){

               this.formDetails = JSON.parse( this.bankDetails )
            },

            editForm(index){

            },
            submit(){

                let self = this;

                axios.post('/customer/customer-bank-details', {

                    id: user_id,
                    name: this.form.name,
                    branch: this.form.branch,
                    type: this.form.type,
                    facility: this.form.facility,
                    amount: this.form.amount,
                })
                .then(function (response) {
                    self.saved = true

                    self.errors = []

                    self.disabled = true
                })
                .catch(function (error) {

                    self.errors= error.response.data.errors

                });

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
                }

            }
        },
        mounted(){

            this.convetToJson();

        }
    }
</script>
<style lang="scss" scoped>
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
    .mt-4{
        margin-top: 4%;
    }
</style>