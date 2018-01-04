<template>
    <div class="row">
        <div class="col-sm-10 offset-1">
            <div class="alert alert-success text-center" role="alert" v-if="saved">
               Residence Details Saved.
            </div>
            <form  @submit.prevent="submit">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="address"> Current Residential Address  <span class="required">*</span></label>
                            <input type="text" id="address" placeholder="Current Residential Address" v-model="form.address" class="form-control" v-bind:class="{ 'is-invalid': errors.address }">
                            <small class="invalid-feedback" v-if="errors.address">
                                {{ errors.address[0] }}
                            </small>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="stay"> Length of Stay (yrs)  <span class="required">*</span></label>
                            <input type="number" id="stay" placeholder="Length of Stay" v-model="form.stay" class="form-control" v-bind:class="{ 'is-invalid': errors.stay }">
                            <small class="invalid-feedback" v-if="errors.stay">
                                {{ errors.stay[0] }}
                            </small>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="previous"> Previous Residence  <span class="required">*</span></label>
                            <input type="text" id="previous" placeholder="Previous Residence" v-model="form.previous" class="form-control" v-bind:class="{ 'is-invalid': errors.previous }">
                            <small class="invalid-feedback" v-if="errors.previous">
                                {{ errors.previous[0] }}
                            </small>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <select name="title" id="title" v-model="form.house" class="form-control" v-bind:class="{ 'is-invalid': errors.house }">
                                <option value="">TYPE OF HOUSE</option>
                                <option value="rented">RENTED</option>
                                <option value="owned">OWNED</option>
                                <option value="parents">LIVING WITH PARENTS</option>
                                <option value="mortgaged">MORTGAGED</option>
                                <option value="employer provided">EMPLOYER PROVIDED</option>
                            </select>
                            <small class="invalid-feedback" v-if="errors.house">
                                {{ errors.house[0] }}
                            </small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="permanent_address"> Permanent Address  <span class="required"></span></label>
                            <input type="text" id="permanent_address" placeholder="Permanent Address if Different from Current Address" v-model="form.permanent_address" class="form-control" v-bind:class="{ 'is-invalid': errors.permanent_address }">
                            <small class="invalid-feedback" v-if="errors.permanent_address">
                                {{ errors.permanent_address[0] }}
                            </small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 offset-4 ">
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-info" v-if="!disabled">
                                Save Residence Details
                            </button>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</template>

<script>

    export default {
        props: ['clickedNext', 'currentStep'],
        data(){
            return{
                form: {
                    address: '',
                    stay: '',
                    previous: '',
                    house: '',
                    permanent_address: ''
                },
                disabled: false,
                errors: [],
                saved:false
            }
        },
        methods:{
            submit(){

                let self = this;

                if(Vue.localStorage.get('userId') !== null){

                    let user_id = Vue.localStorage.get('userId')

                    axios.post('/customer/customer-residence-details', {

                        id: user_id,
                        address: this.form.address,
                        stay: this.form.stay,
                        previous: this.form.previous,
                        house: this.form.house,
                        permanent_address: this.form.permanent_address,
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
                    console.log('no user id')
                }
            },
        },
    }
</script>
<style lang="scss">
    small.invalid-feedback{
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