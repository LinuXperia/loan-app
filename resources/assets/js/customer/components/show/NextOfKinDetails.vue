<template>
    <div class="card-body">
        <div class="row">
        <div class="col-sm-8 offset-2 alert alert-success text-center" role="alert" v-if="saved">
            Next of Kin Details Saved.
        </div>
        </div>
        <form  @submit.prevent="submit">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="name"> Full Name<span class="required"> *</span></label>
                        <input type="text" id="name" placeholder="Full Name" v-model="form.name" class="form-control" v-bind:class="{ 'is-invalid': errors.name }" :disabled="disabled">
                        <small class="invalid-feedback" v-if="errors.name">
                            {{ errors.name[0] }}
                        </small>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="relationship"> Relationship<span class="required"> *</span></label>
                        <input type="text" id="relationship" placeholder="Relationship" v-model="form.relationship" class="form-control" v-bind:class="{ 'is-invalid': errors.relationship }" :disabled="disabled">
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
                        <input type="number" id="phone" placeholder="Phone Number" v-model="form.phone" class="form-control" v-bind:class="{ 'is-invalid': errors.phone }" :disabled="disabled">
                        <small class="invalid-feedback" v-if="errors.phone">
                            {{ errors.phone[0] }}
                        </small>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="email"> Email <span class="required"> *</span></label>
                        <input type="email" id="email" placeholder="Email" v-model="form.email" class="form-control" v-bind:class="{ 'is-invalid': errors.email }" :disabled="disabled">
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
                        <input type="text" id="address" placeholder="Address" v-model="form.address" class="form-control" v-bind:class="{ 'is-invalid': errors.address }" :disabled="disabled">
                        <small class="invalid-feedback" v-if="errors.address">
                            {{ errors.address[0] }}
                        </small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 offset-4 ">
                    <div class="form-group">
                        <button type="submit" class="btn btn-lg btn-outline-success" v-if="!disabled">
                            Update customer Next of Kin Details
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-sm-4 offset-4 ">
                <div class="form-group">
                    <button type="submit" class="btn btn-lg btn-outline-info" v-if="disabled" @click="editForm">
                        Edit customer Next of Kin Details
                    </button>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
    export default {
        props: ['kinDetails'],
        data(){
            return{
                form:'',
                disabled: true,
                errors: [],
                saved:false,
            }
        },
        methods:{
            convetToJson(){
                this.form = JSON.parse(this.kinDetails)
            },

            editForm(){
                if(this.disabled == true){
                    this.disabled = false
                }

            },
            submit(){

                let self = this;

                axios.put('/customer/update-customer-next-of-kin', {
                    id: this.form.user_id,
                    name: this.form.name,
                    relationship: this.form.relationship,
                    phone: this.form.phone,
                    address: this.form.address,
                    email: this.form.email,
                })
                .then(function (response) {
                    self.saved = true
                    self.errors = []
                    self.disabled = true
                })
                .catch(function (error) {

                    self.errors= error.response.data.errors
                    self.disabled = false
                });

            },

        },
        mounted(){

            this.convetToJson();

        }
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