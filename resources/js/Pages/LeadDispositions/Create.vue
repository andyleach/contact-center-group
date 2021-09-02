<template>
    <app-layout title="Create Lead Disposition">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Lead Disposition
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <CreateLeadDispositionForm />
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import CreateLeadDispositionForm from "./Partials/CreateLeadDispositionForm";

export default {
    components: {
        AppLayout,
        CreateLeadDispositionForm,
    },
}
</script>
