<template>
    <div class="row">
        <div class="col-sm-10 offset-1">

            <div class="alert alert-success text-center" role="alert" v-if="saved">
                Referee Details Saved.
            </div>

            <form  @submit.prevent="submit">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name"> Full Name<span class="required">*</span></label>
                            <input type="text" id="name" placeholder="Full Name" v-model="form.name" class="form-control" v-bind:class="{ 'is-invalid': errors.name }">
                            <small class="invalid-feedback" v-if="errors.name">
                                {{ errors.name[0] }}
                            </small>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="relationship"> Relationship <span class="required">*</span></label>
                            <input type="text" id="relationship" placeholder="Relationship" v-model="form.relationship" class="form-control" v-bind:class="{ 'is-invalid': errors.relationship }">
                            <small class="invalid-feedback" v-if="errors.relationship">
                                {{ errors.relationship[0] }}
                            </small>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="acquainted"> No of Years Acquainted <span class="required">*</span></label>
                            <input type="text" id="acquainted" placeholder="No of Years Acquainted" v-model="form.acquainted" class="form-control" v-bind:class="{ 'is-invalid': errors.acquainted }">
                            <small class="invalid-feedback" v-if="errors.acquainted">
                                {{ errors.acquainted[0] }}
                            </small>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nationality"> Nationality<span class="required">*</span></label>
                            <input type="text" id="nationality" placeholder="Nationality" v-model="form.nationality" class="form-control" v-bind:class="{ 'is-invalid': errors.nationality }">
                            <small class="invalid-feedback" v-if="errors.nationality">
                                {{ errors.nationality[0] }}
                            </small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="home_phone"> Home Phone <span class="required">*</span></label>
                            <input type="text" id="home_phone" placeholder="Home Phone" v-model="form.home_phone" class="form-control" v-bind:class="{ 'is-invalid': errors.home_phone }">
                            <small class="invalid-feedback" v-if="errors.home_phone">
                                {{ errors.home_phone[0] }}
                            </small>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="work_phone"> Work Phone<span class="required">*</span></label>
                            <input type="text" id="work_phone" placeholder="Work Phone" v-model="form.work_phone" class="form-control" v-bind:class="{ 'is-invalid': errors.work_phone }">
                            <small class="invalid-feedback" v-if="errors.work_phone">
                                {{ errors.work_phone[0] }}
                            </small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="mobile_phone"> Mobile Phone <span class="required">*</span></label>
                            <input type="text" id="mobile_phone" placeholder="Mobile Phone" v-model="form.mobile_phone" class="form-control" v-bind:class="{ 'is-invalid': errors.mobile_phone }">
                            <small class="invalid-feedback" v-if="errors.mobile_phone">
                                {{ errors.mobile_phone[0] }}
                            </small>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="email"> Email Address<span class="required">*</span></label>
                            <input type="email" id="email" placeholder="Email Address" v-model="form.email" class="form-control" v-bind:class="{ 'is-invalid': errors.email }">
                            <small class="invalid-feedback" v-if="errors.email">
                                {{ errors.email[0] }}
                            </small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="address"> Physical Address  <span class="required">*</span></label>
                            <input type="text" id="address" placeholder="Physical Address" v-model="form.address" class="form-control" v-bind:class="{ 'is-invalid': errors.address }">
                            <small class="invalid-feedback" v-if="errors.address">
                                {{ errors.address[0] }}
                            </small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4 offset-4 ">
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-info" v-if="!disabled">
                                Save Referee Details
                            </button>

                        </div>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-sm-4 offset-4 ">
                    <div class="form-group">
                        <button type="submit" class="btn btn-lg btn-outline-secondary" v-if="disabled" @click="anotherReferee">
                            Add Another Referee
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import {validationMixin} from 'vuelidate'
    import {required, email} from 'vuelidate/lib/validators'

    export default {
        props: ['clickedNext', 'currentStep'],
        mixins: [validationMixin],

        data(){
            return{
                form: {
                    name: '',
                    relationship:'',
                    acquainted: '',
                    nationality: '',
                    home_phone:'',
                    work_phone: '',
                    mobile_phone: '',
                    email: '',
                    address: '',
                },
                disabled: false,
                errors: [],
                saved:false,
            }
        },
        methods:{
            submit(){

                let self = this;

                if(Vue.localStorage.get('userId') !== null){

                    let user_id = Vue.localStorage.get('userId')

                    axios.post('/customer/customer-referees-details', {

                        id: user_id,
                        name: self.form.name,
                        relationship: self.form.relationship,
                        acquainted: self.form.acquainted,
                        nationality: self.form.nationality,
                        home_phone: self.form.home_phone,
                        work_phone: self.form.work_phone,
                        mobile_phone: self.form.mobile_phone,
                        email: self.form.email,
                        address: self.form.address,

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

            anotherReferee(){

                let r = confirm('Add Another Referee?')

                if(r == true){
                    this.form.name = '';
                    this.form.relationship = '';
                    this.form.acquainted = '';
                    this.form.nationality = '';
                    this.form.home_phone = '';
                    this.form.work_phone = '';
                    this.form.mobile_phone = '';
                    this.form.email = '';
                    this.form.address = '';

                    this.disabled = false
                    this.saved = false

                    this.$emit('can-continue', {value: false});
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