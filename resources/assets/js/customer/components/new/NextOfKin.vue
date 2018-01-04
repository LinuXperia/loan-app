<template>
    <div class="row">
        <div class="col-sm-10 offset-1">
            <div class="alert alert-success text-center" role="alert" v-if="saved">
                Next of Kin Details Saved.
            </div>
            <form  @submit.prevent="submit">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="name"> Full Name<span class="required"> *</span></label>
                        <input type="text" id="name" placeholder="Full Name" v-model="form.name" class="form-control" v-bind:class="{ 'is-invalid': errors.name }">
                        <small class="invalid-feedback" v-if="errors.name">
                            {{ errors.name[0] }}
                        </small>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="relationship"> Relationship<span class="required"> *</span></label>
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
                        <label for="phone"> Phone Number<span class="required"> *</span></label>
                        <input type="number" id="phone" placeholder="Phone Number" v-model="form.phone" class="form-control" v-bind:class="{ 'is-invalid': errors.phone }">
                        <small class="invalid-feedback" v-if="errors.phone">
                            {{ errors.phone[0] }}
                        </small>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="email"> Email <span class="required"> *</span></label>
                        <input type="email" id="email" placeholder="Email" v-model="form.email" class="form-control" v-bind:class="{ 'is-invalid': errors.email }">
                        <small class="invalid-feedback" v-if="errors.email">
                            {{ errors.email[0] }}
                        </small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="address"> Address <span class="required"> *</span></label>
                        <input type="text" id="address" placeholder="Address" v-model="form.address" class="form-control" v-bind:class="{ 'is-invalid': errors.address }">
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
                            Save customer Next of Kin Details
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
                    name: '',
                    relationship: '',
                    phone: '',
                    address: '',
                    email: ''
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

                    axios.post('/customer/customer-next-of-kin', {

                        id: user_id,
                        name: this.form.name,
                        relationship: this.form.relationship,
                        phone: this.form.phone,
                        address: this.form.address,
                        email: this.form.email,
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