<template>
    <div class="bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200 mt-8">
        <div class="px-4 py-5 sm:px-6">
            <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                <div class="ml-4 mt-2">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Client Phone Numbers
                    </h3>
                </div>
                <div class="ml-4 mt-2 flex-shrink-0">
                    <jet-button @click="this.purchasePhoneNumberModalOpen = true">Purchase Number</jet-button>
                </div>
            </div>
        </div>
        <div class="">
            <client-phone-number-list :phoneNumbers="client.client_phone_numbers"></client-phone-number-list>
        </div>
    </div>

    <slide-over :open="purchasePhoneNumberModalOpen" v-on:slideOverClosed="this.purchasePhoneNumberModalOpen = false">
        <template v-slot:title>
            Purchase Phone Number
        </template>
        <template v-slot:description>
            Search for and purchase a phone number that will be associated with this client.  Purchased
            phone numbers will be attached to the client's sub-account.
        </template>

        <purchase-phone-number-form @selectedPhoneNumberForPurchase="purchasePhoneNumber" />
    </slide-over>
</template>

<script>
import SlideOver from "../../../Components/SlideOver";
import ClientPhoneNumberList from './ClientPhoneNumberList'
import JetInput from '@/Jetstream/Input';
import JetLabel from '@/Jetstream/Label';
import JetButton   from '@/Jetstream/Button';
import PurchasePhoneNumberForm from "./PurchasePhoneNumberForm";
export default {
    name: "ClientPhoneNumberSection",
    props: ['client'],
    components: {PurchasePhoneNumberForm, ClientPhoneNumberList, SlideOver, JetButton, JetInput, JetLabel},

    data: () => ({
        clientPhoneNumbers: [],
        purchasePhoneNumberModalOpen: false,
    }),

    mounted() {
        this.clientPhoneNumbers = this.client.clientPhoneNumbers;
    },

    methods: {

        /**
         *
         * @param phoneNumber
         */
        purchasePhoneNumber(phoneNumber) {
            console.log(phoneNumber);
            /*axios.post('/clients/'+this.client.id +'/purchase-phone-number', {
                phoneNumber: phoneNumber
            })*/
        }
    }
}

</script>

<style scoped>

</style>
