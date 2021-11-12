<template>
    <div class="bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200 mt-8">
        <div class="px-4 py-5 sm:px-6">

        </div>
        <div class="">

        </div>
    </div>


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
