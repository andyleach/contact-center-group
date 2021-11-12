<template>
    <app-layout title="Clients" :page="$page">
        <div>
            <div class="max-w-7xl mx-auto py-10">
                <client-statistics/>

                <div class="bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200 mt-8">
                    <div class="px-4 py-5 sm:px-6">
                        <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                            <div class="ml-4 mt-2">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Clients
                                </h3>
                            </div>
                            <div class="ml-4 mt-2 flex-shrink-0">
                                <jet-button @click="openClientFormModal">Create Client</jet-button>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <client-list :clients="$page.props.clients.data" />
                    </div>
                </div>
            </div>
        </div>

        <slide-over :open="clientFormOpen" v-on:slideOverClosed="clientFormModalClosed">
            <template v-slot:title>
                Create Client
            </template>
            <template v-slot:description>
                Used to create a new client for whom we do billable work.
            </template>

            <create-client-form></create-client-form>
        </slide-over>
    </app-layout>
</template>


<script>
import AppLayout from "../../Layouts/AppLayout";
import ClientStatistics from "./Partials/ClientStatistics"
import ClientList from "./Partials/ClientList";
import { Link } from '@inertiajs/inertia-vue3'
import JetButton from "@/Jetstream/Button"
import CreateClientForm from "./Partials/CreateClientForm";
import SlideOver from "../../Components/SlideOver";
export default {
    name: "ClientIndex",
    components: {CreateClientForm, AppLayout, ClientStatistics, ClientList, Link, SlideOver, JetButton},
    data: () => ({
        clientFormOpen: false
    }),

    methods: {
        openClientFormModal() {
            this.clientFormOpen = true;
        },
        clientFormModalClosed() {
            console.log('emitted');
            this.clientFormOpen = false;
        }
    }
}
</script>

<style scoped>

</style>
