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

        <client-phone-number-section :client="$page.props.client"></client-phone-number-section>


    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import UpdateClientForm from "./Partials/UpdateClientForm";
import AppLayout from "../../Layouts/AppLayout";
import JetActionSection from '@/Jetstream/ActionSection';
import SlideOver from "../../Components/SlideOver";
import ClientPhoneNumberSection from "./Partials/ClientPhoneNumberSection";

export default defineComponent({
    name: "ClientEdit",
    components: {ClientPhoneNumberSection, UpdateClientForm, AppLayout, JetActionSection, SlideOver},
})
</script>

<style scoped>

</style>
