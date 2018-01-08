<template>
    <div class="row">
        <div class="col-sm-12 ">
            <horizontal-stepper
                    :steps="customerSteps"
                    :top-buttons="true"
                    @completed-step="completeStep"
                    @active-step="isStepActive"
                    @stepper-finished="formEnd"

            >
            </horizontal-stepper>
        </div>
    </div>

</template>
<script>
    import HorizontalStepper from 'vue-stepper';
    import PersonalDetails from './PersonalDetails.vue';
    import NextOfKin from './NextOfKin.vue';
    import BankDetails from './BankDetails.vue';
    import ResidenceDetails from './Residence.vue';
    import WorkDetails from './WorkDetails.vue';
    import RefereeDetails from './RefereesDetails.vue';
    import FileUploads from './FileUploads.vue';
    import EndForm from './EndRegistration.vue';
    export default{
        components: {
            HorizontalStepper
        },
        data(){
            return {
                customerSteps: [
                    {
                        icon: 'alarm',
                        name: 'first',
                        title: 'Personal Details',
                        subtitle: 'customer Personal Details',
                        component: PersonalDetails,
                        completed: false

                    },
                    {
                        icon: 'explore',
                        name: 'second',
                        title: 'Next of Kin',
                        subtitle: 'customer Next of Kin Details',
                        component: NextOfKin,
                        completed: false

                    },
                    {
                        icon: 'payment',
                        name: 'third',
                        title: 'Bank Details',
                        subtitle: 'customer Bank Details',
                        component: BankDetails,
                        completed: false

                    },
                    {
                        icon: 'navigation',
                        name: 'four',
                        title: 'Residence Details',
                        subtitle: 'customer Residence Details',
                        component: ResidenceDetails,
                        completed: false

                    },
                    {
                        icon: 'place',
                        name: 'five',
                        title: 'Work Details',
                        subtitle: 'customer Work Details',
                        component: WorkDetails,
                        completed: false

                    },

                    {
                        icon: 'person',
                        name: 'six',
                        title: 'Referee Details',
                        subtitle: 'customer Referee Details',
                        component: RefereeDetails,
                        completed: false

                    },

                    {
                        icon: 'backup',
                        name: 'Uploads',
                        title: 'File Uploads',
                        subtitle: 'Account File Uploads',
                        component: FileUploads,
                        completed: false

                    },

                    {
                        icon: 'close',
                        name: 'seven',
                        title: 'End Registration',
                        subtitle: 'End of Registration',
                        component: EndForm,
                        completed: false

                    },

                ]
            }
        },
        methods: {
            // Executed when @completed-step event is triggered
            completeStep(payload) {
                this.customerSteps.forEach((step) => {
                    if (step.name === payload.name) {
                        step.completed = true;
                    }
                })
            },
            // Executed when @active-step event is triggered
            isStepActive(payload) {
                this.customerSteps.forEach((step) => {

                    if (step.name === payload.name) {

                        if(step.completed === true) {
                            step.completed = false;
                        }
                    }
                })
            },
            // Executed when @stepper-finished event is triggered
            formEnd(payload) {

                axios.post('/customer/complete-profile',{

                    id: Vue.localStorage.get('userId')

                }).then(function (response) {

                    console.log(response)

                    localStorage.removeItem('userId');
                    localStorage.removeItem('userName');
                    window.location.href = '/customer/new-customer'
                }).catch(function (error) {

                    console.log(error)
                });


            }
        }
    }

</script>
<style lang="scss">



</style>