<template>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Phone Number
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Call Handling Type
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="phoneNumber in phoneNumbers" :key="phoneNumber.id">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <strong>{{ phoneNumber.label }}</strong><br>
                                {{ phoneNumber.phone_number }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ phoneNumber.status_label }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ phoneNumber.call_handling }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="#" @click="openPhoneNumberConfigurationModal(phoneNumber)">Edit</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <slide-over :open="editPhoneNumberConfigurationModalOpen" v-on:slideOverClosed="closePhoneNumberConfigurationModal">
        <template v-slot:title>
            Edit Phone Number
        </template>
        <template v-slot:description>
            Handles configuration for how a phone number will be used within our system.
        </template>

        <client-phone-number-form :phoneNumber="currentPhoneNumber" v-if="null !== currentPhoneNumber"/>
    </slide-over>
</template>

<script>
import SlideOver from "../../../Components/SlideOver";
import ClientPhoneNumberForm from "./ClientPhoneNumberForm";
export default {
    name: "ClientPhoneNumberList.vue",
    props: ['phoneNumbers'],
    components: { SlideOver, ClientPhoneNumberForm },

    data: () => ({
        currentPhoneNumber: null,
        editPhoneNumberConfigurationModalOpen: false,
    }),

    methods: {
        openPhoneNumberConfigurationModal(phoneNumber) {
            this.currentPhoneNumber = phoneNumber;
            this.editPhoneNumberConfigurationModalOpen = true;
        },

        closePhoneNumberConfigurationModal() {
            this.currentPhoneNumber = null;
            this.editPhoneNumberConfigurationModalOpen = false;
        }
    }
}
</script>

<style scoped>

</style>
