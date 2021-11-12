<template>
    <app-layout title="Edit Client" :page="$page">
        <jet-action-section class="pt-10">
            <template #title>
                Client Configuration
            </template>

            <template #description>
                Update the client's base configuration within our application
            </template>

            <template #content>
                <update-client-form :client="$page.props.client"></update-client-form>
            </template>
        </jet-action-section>

        <jet-section-border />

        <jet-action-section>
            <template #title>
                Client Configuration
            </template>

            <template #description>
                Update the client's base configuration within our application
            </template>

            <template #content>
                <div class="-ml-4 -mt-2 flex mb-4 items-center justify-between flex-wrap sm:flex-nowrap">
                    <div class="ml-4 mt-2">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Client Phone Numbers
                        </h3>
                    </div>
                    <div class="ml-4 mt-2 flex-shrink-0">
                        <jet-button @click="this.purchasePhoneNumberModalOpen = true">Purchase Number</jet-button>
                    </div>
                </div>
                <client-phone-number-list :phoneNumbers="this.clientPhoneNumbers"></client-phone-number-list>
            </template>
        </jet-action-section>


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

    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import UpdateClientForm from "./Partials/UpdateClientForm";
import AppLayout from "../../Layouts/AppLayout";
import JetActionSection from '@/Jetstream/ActionSection';
import SlideOver from "../../Components/SlideOver";
import ClientPhoneNumberSection from "./Partials/ClientPhoneNumberSection";
import JetSectionBorder from '@/Jetstream/SectionBorder'
import JetButton from '@/Jetstream/Button';
import ClientPhoneNumberList from "./Partials/ClientPhoneNumberList";
import PurchasePhoneNumberForm from "./Partials/PurchasePhoneNumberForm";
import { usePage } from '@inertiajs/inertia-vue3'

export default defineComponent({
    name: "ClientEdit",
    components: {ClientPhoneNumberSection, UpdateClientForm, AppLayout, JetActionSection, SlideOver, JetSectionBorder, JetButton, ClientPhoneNumberList, PurchasePhoneNumberForm },
    data: () => ({
        clientPhoneNumbers: [],
        purchasePhoneNumberModalOpen: false,
    }),

    mounted() {
        this.clientPhoneNumbers = usePage().props.value.client.client_phone_numbers;
    },

    methods: {

        /**
         *
         * @param phoneNumber
         */
        purchasePhoneNumber(phoneNumber) {
            axios.post('/client-phone-numbers', {
                client_id: usePage().props.value.client.id,
                phoneNumber: phoneNumber
            }).then(response => {
                console.log(response);
            })
        }
    }
})
</script>

<style scoped>

</style>
