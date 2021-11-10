<template>
    <app-layout title="Profile" :page="$page">
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
                                <Link :href="route('clients.create')"
                                      class="relative inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >Create Client</Link>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <client-list :clients="$page.props.clients.data" />
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>


<script>
import AppLayout from "../../Layouts/AppLayout";
import ClientStatistics from "./Partials/ClientStatistics"
import ClientList from "./Partials/ClientList";
import { Link } from '@inertiajs/inertia-vue3'

export default {
    name: "ClientIndex",
    components: {AppLayout, ClientStatistics, ClientList, Link}
}
</script>

<style scoped>

</style>
