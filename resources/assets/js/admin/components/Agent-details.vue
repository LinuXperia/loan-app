<template>

    <div class="row">
        <div class="col-sm-12">

            <form  class="form-horizontal">
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="name">Agent Name</label>
                    <div class="col-md-9">
                        <input type="text" id="name" name="name" class="form-control"  :value="agent.name" disabled>

                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="email">Email Address</label>
                    <div class="col-md-9">
                        <input type="email" id="email" name="email" class="form-control"  :value="agent.email" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="phone">Phone Number</label>
                    <div class="col-md-9">
                        <input type="text" id="phone" name="phone" class="form-control"  :value="agent.details.phone ? agent.details.phone : ''" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="address">Address</label>
                    <div class="col-md-9">
                        <input type="text" id="address" name="address" class="form-control"  :value="agent.details.address ? agent.details.address : ''" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="country">Country </label>
                    <div class="col-md-9">
                        <input type="text" id="country" name="country" class="form-control"  :value="agent.details.country ? agent.details.country : ''" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="registered_by_name">Registered By</label>
                    <div class="col-md-9">
                        <input type="text" id="registered_by_name" name="registered_by_name" class="form-control"  :value="agent.registered_by_name" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="status">Account Status</label>
                    <div class="col-md-9">
                        <input type="text" id="status" name="status" class="form-control"  :value="agent.status" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="comment">Comment</label>
                    <div class="col-md-9">
                        <textarea id="comment" name="comment" class="form-control"  :value="agent.details.comment ? agent.details.comment : ''" disabled></textarea>
                    </div>
                </div>

            </form>

            <div class="row">
                <div class="col-sm-3 text-center"></div>
                <div class="col-sm-6 text-center">
                   <button class="btn btn-danger" v-if="agent.status === 'active'" @click="changeStatus">Deactivate Agent</button>
                   <button class="btn btn-success" v-if="agent.status === 'inactive'" @click="changeStatus">Activate Agent</button>
                   <button class="btn btn-info">Print Details</button>
                </div>
                <div class="col-sm-3 text-center" v-if="statusChanged">
                    <div class="alert alert-success">
                        {{ message }}
                    </div>
                </div>
                <div class="col-sm-3 text-center" v-if="errors.status">
                    <div class="alert alert-success">
                        {{ errors.status[0] }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        props: ['agentDetails'],
        data(){
            return{
                agent: '',
                message: '',
                errors: [],
                statusChanged:false
            }
        },

        methods: {
            convertToJson(){

                this.agent = JSON.parse(this.agentDetails)
            },

            changeStatus(){

                if(this.agent.status === 'active'){
                    //deactivate account

                    let r = confirm('Do you want to deactivate Agent Account?')

                    if(r === true){
                        axios.put('/admin/change-status',{
                            id: this.agent.id,
                            status: 'inactive'
                        })
                        .then(response => {
                            this.statusChanged = true
                            this.agent.status = 'inactive'
                            this.message = response.data.message
                        })
                        .catch(error => {
                            this.errors = error.response.data.errors
                        });
                    }else {
                        return false;
                    }

                }else if(this.agent.status === 'inactive'){
                    //activate account
                    let r = confirm('Do you want to activate Agent Account?')

                    if(r === true){
                        axios.put('/admin/change-status',{
                            id: this.agent.id,
                            status: 'active'
                        })
                        .then(response => {
                            this.statusChanged = true
                            this.agent.status = 'active'
                            this.message = response.data.message
                        })
                        .catch(error => {
                            this.errors = error.response.data.errors
                        });
                    }else {
                        return false;
                    }


                }
            }
        },
        mounted(){
            this.convertToJson();
        }
    }
</script>