<template>
    <div class="card-body text-center">
        <div class="col-sm-6 offset-3">
            <div class="alert alert-danger text-center" v-if="errors">
               <span v-if="errors.approved">{{ errors.approved[0]}}</span>
            </div>
            <div class="alert alert-success text-center" v-if="success">
                <span v-if="success.approved">{{ success.approved[0]}}</span>
            </div>
        </div>

        <div class="row" v-if="customer.approved === null">
            <div class="col-sm-4 offset-1">
                <button class="btn btn-outline-success btn-block mb-4" @click="approve('active')" >APPROVE CUSTOMER ACCOUNT</button>
            </div>
            <div class="col-sm-4 offset-1">
                <button class="btn btn-danger btn-block" @click="approve('declined')">DECLINE CUSTOMER ACCOUNT</button>
            </div>
        </div>
        <div class="row" v-if="customer.approved !== null">
            <div class="col-sm-6"  v-if="!blacklist">
                <button class="btn btn-outline-success btn-block mb-4" v-if="!active" @click="activate('active')"> ACTIVATE CUSTOMER ACCOUNT</button>
                <button class="btn btn-danger btn-block" v-if="active" @click="activate('dormant')">CUSTOMER ACCOUNT DORMANT</button>
            </div>
            <div class="col-sm-6" :class=" blacklist ? 'offset-3' : ''">
                <button class="btn btn-danger btn-block mb-4" v-if="!blacklist" @click="blacklisted('blacklisted')"><i class="icon-plus"></i> BLACKLIST CUSTOMER ACCOUNT </button>
                <button class="btn btn-success btn-block" v-if="blacklist" @click="blacklisted('active')"><i class="icon-minus"></i> REMOVE CUSTOMER ACCOUNT FROM BLACKLIST </button>
            </div>
        </div>

    </div>
</template>

<script>
    export default{
        props: ['customerDetails'],
        data(){
            return {
                customer:'',
                approved: null,
                errors:null,
                success: null,
                active: null,
                blacklist: null,
            }
        },
        methods: {
            convertToJson(){
                this.customer = JSON.parse(this.customerDetails);
            },

            setStatus(){

                this.active = this.customer.status === 'active' && this.customer.approved == true ? true : false
                this.blacklist = this.customer.status === 'blacklisted' ? true : false

            },
            approve(status){

                let message = status === 'active' ? "Approve Customer" : "Decline Customer"

                let r = confirm('Do you want to ' + message  + '?');

                if(r === true){
                    axios.put('/customer/change-approve-status', {
                        id: this.customer.id,
                        status: status,
                    })
                    .then(response => {

                        this.customer.active = response.data.status
                        this.customer.approved = response.data.status

                        this.errors = null

                        this.success = response.data.success
                    })
                    .catch(error => {

                        this.success = null
                        this.errors = error.response.data.errors
                    })
                }


            },

            activate(status){
                let message = status === 'active' ? "Activate Customer" : "Deactivate Customer"

                let r = confirm('Do you want to ' + message  + '?');

                if(r === true){
                    axios.put('/customer/change-active-status', {
                        id: this.customer.id,
                        status: status,
                    })
                        .then(response => {

                            this.active = status === 'active' ? true : false

                            this.errors = null

                            this.success = response.data.success
                        })
                        .catch(error => {

                            this.success = null
                            this.errors = error.response.data.errors
                        })
                }
            },
            blacklisted(status){

                let message = status === 'blacklisted' ? "Blacklist customer" : "Remove customer From Blacklist"

                let r = confirm('Do you want to ' + message  + '?');

                if(r === true){
                    axios.put('/customer/blacklist-customer', {
                        id: this.customer.id,
                        status: status,
                    })
                        .then(response => {

                            this.blacklist = status === 'blacklisted' ? true : false

                            this.active = status === 'active' ? true : false

                            this.errors = null

                            this.success = response.data.success
                        })
                        .catch(error => {

                            this.success = null
                            this.errors = error.response.data.errors
                        })
                }
            }
        },
        mounted(){
           this.convertToJson()

            this.setStatus()
        }

    }
</script>

<style>
    .mb-4{
        margin-bottom: 0.5rem !important;
    }
</style>