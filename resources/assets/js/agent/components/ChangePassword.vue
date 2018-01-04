<template>
    <div class="row">
        <div class="col-sm-12" v-if="saved">
            <div class="alert alert-success text-center">
                Password saved successfully.
            </div>
        </div>
        <div class="col-sm-12">
            <form class="form-inline" @submit.prevent="submit">
                <div class="row">
                    <div class="col">
                        <input type="password" class="form-control"  placeholder="Current Password" v-model="current_password" v-bind:class="{ 'is-invalid': errors.current_password }" :disabled="saved">
                        <small class="invalid-feedback" v-if="errors.current_password">
                            {{ errors.current_password[0] }}
                        </small>
                    </div>
                    <div class="col">
                        <input type="password" class="form-control"  placeholder="New Password" v-model="password" v-bind:class="{ 'is-invalid': errors.password }" :disabled="saved">
                        <small class="invalid-feedback" v-if="errors.password">
                            {{ errors.password[0] }}
                        </small>
                    </div>
                    <div class="col">
                        <input type="password" class="form-control" placeholder="Confirm New Password" v-model="password_confirmation" v-bind:class="{ 'is-invalid': errors.password }" :disabled="saved">
                    </div>
                    <div class="col">
                        <button class="btn btn-success" type="submit" :disabled="saved"> Change Password</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['userId'],
        data(){
            return {
                current_password:'',
                password: '',
                password_confirmation: '',
                errors:[],
                saved:false,
            }
        },

        methods: {
            submit(){
                axios.post('/change-password', {
                    id:  parseInt(this.userId),
                    current_password: this.current_password,
                    password: this.password,
                    password_confirmation: this.password_confirmation
                })
                .then(response => {

                    this.errors=[]
                    this.saved = true
                })
                .catch(error => {
                    this.errors= error.response.data.errors
                });
            }
        },

    }
</script>
