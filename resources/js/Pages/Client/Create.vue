<template>
    <app-layout title="Create Client" :page="$page">
        <create-client-form></create-client-form>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import CreateClientForm from "./Partials/CreateClientForm";
import AppLayout from "../../Layouts/AppLayout";
export default defineComponent({
    name: "ClientCreate",
    components: {CreateClientForm, AppLayout}
})
</script>

<style scoped>

</style>
