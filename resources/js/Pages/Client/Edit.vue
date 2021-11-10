<template>
    <app-layout title="Edit Client" :page="$page">
        <update-client-form :client="$page.props.client"></update-client-form>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import UpdateClientForm from "./Partials/UpdateClientForm";
import AppLayout from "../../Layouts/AppLayout";
export default defineComponent({
    name: "ClientEdit",
    components: {UpdateClientForm, AppLayout},

    data: () => ({
        pageTitle: '',
    }),
})
</script>

<style scoped>

</style>
