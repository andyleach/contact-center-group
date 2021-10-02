<template>
    <div>
        <div v-if="userPermissions.canAddTeamMembers">
            <jet-section-border />
        </div>

        <list-section class="mt-10 sm:mt-0">
            <template #title>
                Current Phone Numbers
            </template>

            <template #description>
                A list of all the phone numbers currently being used by the team.
            </template>

            <!-- Pending Team Member Invitation List -->
            <template #content>
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Friendly Name
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Phone Number
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="phoneNumber in team.phone_numbers" :key="phoneNumber.id">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ phoneNumber.friendly_name }}</div>
                                            <div class="text-sm text-gray-500">{{ phoneNumber.phone_number }}</div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                          <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Active
                                          </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </list-section>
    </div>

</template>

<script>

import JetSectionBorder from '@/Jetstream/SectionBorder.vue'
import ListSection from '@/Components/ListSection';

export default {

    props: ['userPermissions', 'team'],
    components: {
        ListSection,
        JetSectionBorder
    },

    data: () => ({
        currentPhoneNumber: {},
    }),

    methods: {

    }
}
</script>
