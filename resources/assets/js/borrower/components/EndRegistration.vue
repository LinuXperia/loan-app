<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <h1 class="display-3 text-center">{{ userName }} Registered</h1>
                    <p class="lead text-center">Registration Successful. Go to loans module to issue a loan. </p>
                </div>
            </div>
        </div>
    </div>

</template>
<script>

    export default{
        props: ['clickedNext', 'currentStep'],
        data(){
            return{
                userName: Vue.localStorage.get('userName'),
                userId: Vue.localStorage.get('userId')
            }
        },

        mounted(){
            this.$emit('can-continue', {value: true});
        }
    }

</script>
<style>

</style>