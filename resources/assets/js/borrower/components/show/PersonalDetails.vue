<template>
    <div class="card-body">

        <div class="row">
            <div class="form-group col-sm-4">
                <label for="surname">Surname</label>
                <input type="text" class="form-control" id="surname" disabled v-model="data.sname">
            </div>
            <div class="form-group col-sm-4">
                <label for="fname">First Name</label>
                <input type="text" class="form-control" id="fname" disabled v-model="data.fname">
            </div>
            <div class="form-group col-sm-4">
                <label for="lname">Last Name</label>
                <input type="text" class="form-control" id="lname" disabled v-model="data.lname">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-4">
                <label for="nationality">Nationality</label>
                <input type="text" class="form-control" id="nationality" disabled v-model="data.nationality">
            </div>
            <div class="form-group col-sm-4">
                <label for="idNumber">ID No. / Passport No.</label>
                <input type="text" class="form-control" id="idNumber" disabled v-model="data.idNumber">
            </div>
            <div class="form-group col-sm-4">
                <label for="pin">Pin</label>
                <input type="text" class="form-control" id="pin" disabled v-model="data.pin">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-4">
                <label for="mobile">Mobile</label>
                <input type="number" class="form-control" id="mobile" disabled v-model="data.mobile">
            </div>
            <div class="form-group col-sm-4">
                <label for="telephone">Telephone</label>
                <input type="number" class="form-control" id="telephone" disabled v-model="data.telephone">
            </div>
            <div class="form-group col-sm-4">
                <label for="dob">Date of Birth</label>
                <input type="date" class="form-control" id="dob" disabled v-model="data.dob">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-4">
                <label for="address">Physical Address</label>
                <input type="text" class="form-control" id="address" disabled v-model="data.address">
            </div>
            <div class="form-group col-sm-4">
                <label for="office">Office Telephone</label>
                <input type="number" class="form-control" id="office" disabled v-model="data.office">
            </div>
            <div class="form-group col-sm-4">
                <label for="home">Home Telephone</label>
                <input type="number" class="form-control" id="home" disabled v-model="data.home">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-6">
                <label for="marital">Marital Status</label>
                <select id="marital" name="marital" class="form-control" disabled v-model="data.marital">
                    <option value=""> </option>
                </select>
            </div>
            <div class="form-group col-sm-6">
                <label for="education">Education Level</label>
                <select id="education" name="education" class="form-control" v-model="data.education">
                    <option value="{{ data.education }}" selected="selected"> {{ data.education }}</option>
                </select>
            </div>
        </div>
    </div>

</template>

<script>
    export default{
        props: ['personalDetails'],

        data(){
            return {
                data: '',
                form: {
                    sname: ''
                }
            }
        },
        methods: {
            convetToJson(){
                this.data = JSON.parse(this.personalDetails)
            }

        },
        mounted(){

            this.convetToJson();

        }
    }
</script>