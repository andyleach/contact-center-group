<template>
    <div class="bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200 mt-8">
        <div class="px-4 py-5 sm:px-6">

        </div>
        <div class="">

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


}

</script>

<style scoped>

</style>
