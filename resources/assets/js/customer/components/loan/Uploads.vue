<template>
    <div>
        <div class="row mt-4"  >
            <div class="col-sm-12">
                <h5 class="text-center">Loan File Uploads</h5>
            </div>
        </div>
        <div class="row mt-4"  >
            <div class="col-sm-4">
                <select v-model="upload" class="form-control" v-bind:class="{ 'is-invalid': errors.upload }">
                    <option value="logbook">LOG BOOK IMAGE</option>
                </select>
                <small class="invalid-feedback" v-if="errors.upload">
                    {{ errors.upload[0] }}
                </small>
            </div>
            <div class="col-sm-4">
                <input type="file" @change="onFileChange" id="image" class="form-control" v-bind:class="{ 'is-invalid': errors.image }">
                <small class="invalid-feedback" v-if="errors.image">
                    {{ errors.image[0] }}
                </small>
            </div>

            <div class="col-sm-2">
                <button class="btn btn-success btn-block" @click="submit">Upload</button>
            </div>
            <div class="col-sm-2">
                <div class="upload-complete"v-if="saved">
                    <i class="fa fa-thumbs-up "></i>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

    export default{
        props: ['loan'],
        data(){
            return{
                saved: false,
                errors:[],
                disabled: false,
                image:null,
                upload:'logbook'
            }
        },
        methods: {
            onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                var image = new Image();
                var reader = new FileReader();
                var vm = this;

                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            submit(){
                let self = this

                axios.post('/loans/loan-uploads', {
                    id : self.loan,
                    upload:self.upload,
                    image: self.image
                })
                .then(function (response) {

                    self.saved = true
                    self.errors = []
                    self.image = null;

                    document.getElementById("image").value = "";

                    self.$emit('can-continue', {value: true});

                })
                .catch(function (error) {

                    self.errors = error.response.data.errors

                    self.$emit('can-continue', {value: false});

                });
            }
        }
    }
</script>
<style scoped lang="scss">
    .mt-4{
        margin-top:4%;
    }
    .upload-complete  i{

        margin-top: -4px;
        font-size: 35px;
        border: 1px solid;
        border-radius: 50%;
        padding: 5px 7px;
        color: #4dbd74;
    }

</style>