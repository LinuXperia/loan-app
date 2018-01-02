<template>
    <div>
        <div class="row mt-4"  >
            <div class="col-sm-12">
                <h5 class="text-center">Loan File Uploads</h5>
            </div>
        </div>
        <div class="row mt-4"  >
            <div class="col-sm-3">
                <label for="">Detail One <span class="badge badge-danger">*</span></label>
            </div>
            <div class="col-sm-7">
                <input type="file" v-on:change="onFileChange" class="form-control">
            </div>
            <div class="col-sm-2">
                <button class="btn btn-success btn-block" @click="upload">Upload</button>
            </div>
        </div>
    </div>
</template>
<script>

    export default{
        props: ['loan'],
        data(){
            return{
                image: '',
                errors:[]
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
            upload(){
                console.log(this.image)
                /*axios.post('/loans/upload',{
                    image: this.image,
                    loan_id: this.loan
                }).
                then(response => {
                    console.log(response)
                }).catch(error => {
                    console.log(error)
                });*/
            }
        }
    }
</script>
<style scoped lang="scss">
    .mt-4{
        margin-top:4%;
    }

</style>