<template>
    <div class="card-body">
        <div class="row" v-if="saved">
            <div class=" col-sm-8 offset-2 alert alert-success text-center" role="alert" >
                Personal Details Saved.
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8 offset-2">
                <div class="alert alert-success text-center" v-if="data.status === 'active' && data.approved !== null ">
                   <strong><i class="icon-check"></i></strong> Account Is <strong>Active</strong>!
                </div>
                <div class="alert alert-info text-center" v-if="data.approved === null">
                    <strong><i class="icon-clock"></i></strong> Account Is Waiting <strong>Approval</strong> by Admin
                </div>
                <div class="alert alert-warning text-center" v-if="data.status === 'declined'">
                   <strong><i class="icon-minus"></i></strong> Account <strong>Declined </strong>by Admin!
                </div>
                <div class="alert alert-dark text-center" v-if="data.status === 'dormant'">
                    <strong><i class="icon-exclamation"></i></strong> Account is <strong>Dormant </strong>!
                </div>
                <div class="alert alert-danger text-center" v-if="data.status === 'blacklisted'">
                    <strong><i class="icon-close"></i></strong> Account <strong>Blacklisted </strong>by Admin!
                </div>
            </div>
        </div>
        <hr>
        <form @submit.prevent="submit">
            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" :disabled="disabled" v-model="data.title" v-bind:class="{ 'is-invalid': errors.title }">
                    <small v-if="errors.title" class="invalid-feedback">
                        {{ errors.title[0]}}
                    </small>
                </div>
                <div class="form-group col-sm-6">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" :disabled="disabled" v-model="data.email" v-bind:class="{ 'is-invalid': errors.email }">
                    <small v-if="errors.email" class="invalid-feedback">
                        {{ errors.email[0]}}
                    </small>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="surname">Surname</label>
                    <input type="text" class="form-control" id="surname" :disabled="disabled" v-model="data.sname" v-bind:class="{ 'is-invalid': errors.sname }">
                    <small v-if="errors.sname" class="invalid-feedback">
                        {{ errors.sname[0]}}
                    </small>
                </div>
                <div class="form-group col-sm-4">
                    <label for="fname">First Name</label>
                    <input type="text" class="form-control" id="fname" :disabled="disabled" v-model="data.fname" v-bind:class="{ 'is-invalid': errors.fname }">
                    <small v-if="errors.fname" class="invalid-feedback">
                        {{ errors.fname[0]}}
                    </small>
                </div>
                <div class="form-group col-sm-4">
                    <label for="lname">Last Name</label>
                    <input type="text" class="form-control" id="lname" :disabled="disabled" v-model="data.lname" v-bind:class="{ 'is-invalid': errors.lname }">
                    <small v-if="errors.lname" class="invalid-feedback">
                        {{ errors.lname[0]}}
                    </small>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="nationality">Nationality</label>
                    <input type="text" class="form-control" id="nationality" :disabled="disabled" v-model="data.nationality" v-bind:class="{ 'is-invalid': errors.nationality }">
                    <small v-if="errors.nationality" class="invalid-feedback">
                        {{ errors.nationality[0]}}
                    </small>
                </div>
                <div class="form-group col-sm-4">
                    <label for="idNumber">ID No. / Passport No.</label>
                    <input type="text" class="form-control" id="idNumber" :disabled="disabled" v-model="data.idNumber" v-bind:class="{ 'is-invalid': errors.idNumber }">
                    <small v-if="errors.idNumber" class="invalid-feedback">
                        {{ errors.idNumber[0]}}
                    </small>
                </div>
                <div class="form-group col-sm-4">
                    <label for="pin">Pin</label>
                    <input type="text" class="form-control" id="pin" :disabled="disabled" v-model="data.pin" v-bind:class="{ 'is-invalid': errors.pin }">
                    <small v-if="errors.pin" class="invalid-feedback">
                        {{ errors.pin[0]}}
                    </small>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="mobile">Mobile</label>
                    <input type="number" class="form-control" id="mobile" :disabled="disabled" v-model="data.mobile" v-bind:class="{ 'is-invalid': errors.mobile }">
                    <small v-if="errors.mobile" class="invalid-feedback">
                        {{ errors.mobile[0]}}
                    </small>
                </div>
                <div class="form-group col-sm-4">
                    <label for="telephone">Telephone</label>
                    <input type="number" class="form-control" id="telephone" :disabled="disabled" v-model="data.telephone" v-bind:class="{ 'is-invalid': errors.telephone }">
                    <small v-if="errors.telephone" class="invalid-feedback">
                        {{ errors.telephone[0]}}
                    </small>
                </div>
                <div class="form-group col-sm-4">
                    <label for="dob">Date of Birth</label>
                    <input type="date" class="form-control" id="dob" :disabled="disabled" v-model="data.dob" v-bind:class="{ 'is-invalid': errors.dob }">
                    <small v-if="errors.dob" class="invalid-feedback">
                        {{ errors.dob[0]}}
                    </small>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="address">Physical Address</label>
                    <input type="text" class="form-control" id="address" :disabled="disabled" v-model="data.address" v-bind:class="{ 'is-invalid': errors.address }">
                    <small v-if="errors.address" class="invalid-feedback">
                        {{ errors.address[0]}}
                    </small>
                </div>
                <div class="form-group col-sm-4">
                    <label for="office">Office Telephone</label>
                    <input type="number" class="form-control" id="office" :disabled="disabled" v-model="data.office" v-bind:class="{ 'is-invalid': errors.office }">
                    <small v-if="errors.office" class="invalid-feedback">
                        {{ errors.office[0]}}
                    </small>
                </div>
                <div class="form-group col-sm-4">
                    <label for="home">Home Telephone</label>
                    <input type="number" class="form-control" id="home" :disabled="disabled" v-model="data.home" v-bind:class="{ 'is-invalid': errors.home }">
                    <small v-if="errors.home" class="invalid-feedback">
                        {{ errors.home[0]}}
                    </small>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="marital">Marital Status</label>
                    <input type="text" class="form-control" id="marital" :disabled="disabled" v-model="data.marital" v-bind:class="{ 'is-invalid': errors.marital }">
                    <small v-if="errors.marital" class="invalid-feedback">
                        {{ errors.marital[0]}}
                    </small>
                </div>
                <div class="form-group col-sm-6">
                    <label for="education">Education</label>
                    <input type="text" class="form-control" id="education" :disabled="disabled" v-model="data.education" v-bind:class="{ 'is-invalid': errors.education }">
                    <small v-if="errors.education" class="invalid-feedback">
                        {{ errors.education[0]}}
                    </small>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 offset-3">
                    <button type="submit" class="btn btn-outline-success btn-block" v-if="!disabled" @click="editForm"> Save Personal Details</button>
                </div>
            </div>
        </form>



        <div class="row">
            <div class="col-sm-6 offset-3">
                <button class="btn btn-outline-info btn-block" v-if="disabled" @click="editForm"> Edit Personal Details</button>
            </div>
        </div>
    </div>

</template>

<script>
    import * as helper from '../../../helpers'
    export default{
        props: ['personalDetails', 'avatarImg'],

        data(){
            return {
                data: '',
                disabled: true,
                errors:[],
                saved: false,
                avatar: ''
            }
        },
        methods: {
            uploadAvatar(e){
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {

                var reader = new FileReader();

                reader.onload = (e) => {
                    this.avatar = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            changeAvatar(){

                let self = this

                axios.post('/customer/upload-avatar', {
                    id:self.data.user_id,
                    avatar: self.avatar
                })
                .then(function (response) {

                    self.saved = true
                    self.errors = []

                    document.getElementById("avatar").value = "";

                })
                .catch(function (error) {

                    self.errors = error.response.data.errors

                });
            },
            convetToJson(){
                this.data = JSON.parse(this.personalDetails)
            },

            editForm(){
                if(this.disabled == true){
                    this.disabled = false
                }

            },
            submit(){
                let self = this

                axios.put('/customer/update-customer-personal-details', {
                    id:this.data.user_id,
                    title: this.data.title,
                    fname: this.data.fname,
                    sname: this.data.sname,
                    lname: this.data.lname,
                    idNumber: this.data.idNumber,
                    pin: this.data.pin,
                    email: this.data.email,
                    nationality: this.data.nationality,
                    mobile: this.data.mobile,
                    telephone: this.data.telephone,
                    dob: this.data.dob,
                    address: this.data.address,
                    home: this.data.home,
                    office: this.data.office,
                    marital: this.data.marital,
                    education: this.data.education,
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
            }

        },
        mounted(){

            this.convetToJson();
        }
    }
</script>
<style scoped>
    .img-thumbnail {
        max-width: 65%;
    }
</style>