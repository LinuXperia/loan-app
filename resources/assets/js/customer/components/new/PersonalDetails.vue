<template>
   <div class="row">
       <div class="col-sm-10 offset-1">
           <div class="alert alert-success text-center" role="alert" v-if="saved">
               Personal Details Saved.
           </div>
           <form  @submit.prevent="submit">
               <div class="row">
                   <div class="col-sm-12">
                       <div class="form-group">
                           <label for="home"> Title  <span class="required">*</span></label>
                           <select name="title" id="title" v-model="form.title" class="form-control" v-bind:class="{ 'is-invalid': errors.title }">
                               <option value="">SELECT ONE</option>
                               <option value="mr">MR</option>
                               <option value="mrs">MRS</option>
                               <option value="miss">MISS</option>
                               <option value="dr">DR</option>
                               <option value="prof">PROF</option>
                           </select>
                           <small class="invalid-feedback" v-if="errors.title">
                               {{ errors.title[0] }}
                           </small>
                       </div>

                   </div>
               </div>
               <div class="row">
                   <div class="col-sm-6">
                       <div class="form-group">
                           <label for="sname"> Sur Name  <span class="required">*</span></label>
                           <input type="text" id="sname" placeholder="Sur Name Address" v-model="form.sname" class="form-control" v-bind:class="{ 'is-invalid': errors.sname }">
                           <small class="invalid-feedback" v-if="errors.sname">
                               {{ errors.sname[0] }}
                           </small>
                       </div>
                   </div>

                   <div class="col-sm-6">
                       <div class="form-group">
                           <label for="fname"> First Name <span class="required">*</span></label>
                           <input type="text" id="fname" placeholder="First Name" v-model="form.fname" class="form-control" v-bind:class="{ 'is-invalid': errors.fname }">
                           <small class="invalid-feedback" v-if="errors.fname">
                               {{ errors.fname[0] }}
                           </small>
                       </div>
                   </div>
               </div>

               <div class="row">
                   <div class="col-sm-6">
                       <div class="form-group">
                           <label for="lname"> Middle Name  <span class="required"></span></label>
                           <input type="text" id="lname" placeholder="Physical Address" v-model="form.lname" class="form-control" v-bind:class="{ 'is-invalid': errors.lname }">
                           <small class="invalid-feedback" v-if="errors.lname">
                               {{ errors.lname[0] }}
                           </small>
                       </div>
                   </div>

                   <div class="col-sm-6">
                       <div class="form-group">
                           <label for="idNumber"> ID Number  <span class="required">*</span></label>
                           <input type="number" id="idNumber" placeholder=" ID Number" v-model="form.idNumber" class="form-control" v-bind:class="{ 'is-invalid': errors.idNumber }">
                           <small class="invalid-feedback" v-if="errors.idNumber">
                               {{ errors.idNumber[0] }}
                           </small>
                       </div>
                   </div>
               </div>

               <div class="row">
                   <div class="col-sm-6">
                       <div class="form-group">
                           <label for="pin"> PIN  <span class="required">*</span></label>
                           <input type="text" id="pin" placeholder="PIN" v-model="form.pin" class="form-control" v-bind:class="{ 'is-invalid': errors.pin }">
                           <small class="invalid-feedback" v-if="errors.pin">
                               {{ errors.pin[0] }}
                           </small>
                       </div>
                   </div>

                   <div class="col-sm-6">
                       <div class="form-group">
                           <label for="email"> Email Address  <span class="required">*</span></label>
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
                           <label for="nationality"> Nationality  <span class="required">*</span></label>
                           <input type="text" id="nationality" placeholder="Nationality" v-model="form.nationality" class="form-control" v-bind:class="{ 'is-invalid': errors.nationality }">
                           <small class="invalid-feedback" v-if="errors.nationality">
                               {{ errors.nationality[0] }}
                           </small>
                       </div>
                   </div>
                   <div class="col-sm-6">
                       <div class="form-group">
                           <label for="mobile"> Mobile Phone <span class="required">*</span></label>
                           <input type="number" id="Mobile" placeholder="Mobile Phone" v-model="form.mobile" class="form-control" v-bind:class="{ 'is-invalid': errors.mobile }">
                           <small class="invalid-feedback" v-if="errors.mobile">
                               {{ errors.mobile[0] }}
                           </small>
                       </div>
                   </div>
               </div>
               <div class="row">
                   <div class="col-sm-6">
                       <div class="form-group">
                           <label for="telephone"> Telephone  <span class="telephone"></span></label>
                           <input type="number" id="telephone" placeholder="Telephone" v-model="form.telephone" class="form-control" v-bind:class="{ 'is-invalid': errors.telephone }">
                           <small class="invalid-feedback" v-if="errors.telephone">
                               {{ errors.telephone[0] }}
                           </small>
                       </div>
                   </div>
                   <div class="col-sm-6">
                       <div class="form-group">
                           <label for="dob"> Date of Birth  <span class="required">*</span></label>
                           <input type="date" id="dob" placeholder="" v-model="form.dob" class="form-control" v-bind:class="{ 'is-invalid': errors.dob }">
                           <small class="invalid-feedback" v-if="errors.dob">
                               {{ errors.dob[0] }}
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
                   <div class="col-sm-6">
                       <div class="form-group">
                           <label for="home"> Home Telephone  <span class="required"></span></label>
                           <input type="text" id="home" placeholder="Home Telephone" v-model="form.home" class="form-control" v-bind:class="{ 'is-invalid': errors.home }">
                           <small class="invalid-feedback" v-if="errors.home">
                               {{ errors.home[0] }}
                           </small>
                       </div>
                   </div>
               </div>
               <div class="row">
                   <div class="col-sm-6">
                       <div class="form-group">
                           <label for="office"> Office Phone Number <span class="required"></span></label>
                           <input type="text" id="office" placeholder="Office Phone Number" v-model="form.office" class="form-control" v-bind:class="{ 'is-invalid': errors.office }">
                           <small class="invalid-feedback" v-if="errors.office">
                               {{ errors.office[0] }}
                           </small>
                       </div>
                   </div>
               </div>
               <div class="row">
                   <div class="col-sm-12">
                       <div class="form-group">
                           <label for="marital"> Education Level <span> *</span></label>
                           <select name="education" id="education" v-model="form.education" class="form-control" v-bind:class="{ 'is-invalid': errors.education }">
                               <option value="">EDUCATION LEVEL</option>
                               <option value="highSchool">HIGH SCHOOL CERTIFICATE</option>
                               <option value="diploma">DIPLOMA</option>
                               <option value="postGraduate">POST GRADUATE</option>
                               <option value="prof">PROFESSIONAL</option>
                           </select>
                           <small class="invalid-feedback" v-if="errors.education">
                               {{ errors.education[0] }}
                           </small>
                       </div>
                   </div>
               </div>
               <div class="row">
                   <div class="col-sm-12">
                       <div class="form-group">
                           <label for="marital"> Marital Status <span> *</span></label>
                           <select id="marital" v-model="form.marital" class="form-control" v-bind:class="{ 'is-invalid': errors.marital }">
                               <option value="">MARITAL STATUS</option>
                               <option value="single">SINGLE</option>
                               <option value="married">MARRIED</option>
                               <option value="divorced">DIVORCED</option>
                               <option value="windowed">WINDOWED</option>
                           </select>
                           <small v-if="errors.marital" class="invalid-feedback">
                               {{ errors.marital[0]}}
                           </small>
                       </div>
                   </div>
                </div>
               <div class="row">
                   <div class="col-sm-4 offset-4">
                    <div class="form-group">
                           <button type="submit" class="btn btn-info btn-lg" v-if="!disabled">
                               Save customer Personal Details
                           </button>
                       </div>
                   </div>
               </div>
           </form>

       </div>

   </div>
</template>

<script>
    var _ = require('lodash');

    export default {
        props: ['clickedNext', 'currentStep'],
        data() {
            return {
                form: {
                    title: '',
                    fname:'',
                    sname:'',
                    lname: '',
                    nationality:'',
                    idNumber:'',
                    pin:'',
                    email:'',
                    mobile:'',
                    telephone:'',
                    dob:'',
                    address:'',
                    office:'',
                    home:'',
                    marital:'',
                    education:'',
                },
                disabled: false,
                errors: [],
                saved:false,

            }
        },
        methods:{

            submit(){

                let self = this

                axios.post('/customer/customer-personal-details', {
                    title: this.form.title,
                    fname: this.form.fname,
                    sname: this.form.sname,
                    lname: this.form.lname,
                    idNumber: this.form.idNumber,
                    pin: this.form.pin,
                    email: this.form.email,
                    nationality: this.form.nationality,
                    mobile: this.form.mobile,
                    telephone: this.form.telephone,
                    dob: this.form.dob,
                    address: this.form.address,
                    home: this.form.home,
                    office: this.form.office,
                    marital: this.form.marital,
                    education: this.form.education,
                })
                .then(function (response) {

                    self.user = response.data;

                    //store user in store
                    Vue.localStorage.set('userId', self.user.data.id)
                    Vue.localStorage.set('userName', self.form.sname + ' ' + self.form.fname)

                    self.saved = true

                    self.errors = []

                    self.disabled = true

                    self.$emit('can-continue', {value: true});
                })
                .catch(function (error) {

                    self.errors= error.response.data.errors

                    self.$emit('can-continue', {value: false});

                });
            },
        },
    }
</script>
<style lang="scss" scoped>

    /*inputs*/
    input, textarea, select{
        padding: 7px;
        border: 1px solid #ccc;
        border-radius: 0px;
        width: 100%;
        box-sizing: border-box;
        font-family: montserrat;
        color: #2C3E50;
        font-size: 13px;
    }
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