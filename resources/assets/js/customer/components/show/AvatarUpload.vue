<template>
    <div class="row mt-4">
        <div class="col-sm-8">
            <input type="file" class="form-control" @change="uploadAvatar" id="avatar" v-bind:class="{ 'is-invalid': errors.avatar }">
            <small v-if="errors.avatar" class="invalid-feedback">
                {{ errors.avatar[0]}}
            </small>
        </div>
        <div class="col-sm-4">
            <button type="submit" @click="changeAvatar" class="btn btn-outline-secondary mt-1"><i class="icon-arrow-up-circle"></i></button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['customerId'],
        data(){
            return{
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
                    id:self.customerId,
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
        }
    }
</script>

