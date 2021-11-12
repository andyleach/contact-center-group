<template>
    <form @submit.prevent="submit">
        <div>
            <jet-label for="client-phone-number" value="Phone Number" />
            <jet-input id="client-phone-number" type="tel" class="mt-1 block w-full" v-model="form.phone_number" required autofocus />
        </div>

        <div>
            <jet-label for="phone-number-call-handling" value="Call Handling" />
            <div>
                <label for="phone-number-call-handling" class="block text-sm font-medium text-gray-700">Location</label>
                <select id="phone-number-call-handling" name="phone-number-call-handling" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option>United States</option>
                    <option v-for="callHandlingType in callHandlingTypes" :value="callHandlingType.label">
                        {{ callHandlingType.label }}
                    </option>
                </select>
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Update
            </jet-button>
        </div>
    </form>
</template>

<script>
import { defineComponent } from 'vue'
import JetInput from '@/Jetstream/Input';
import JetLabel from '@/Jetstream/Label';
import JetButton   from '@/Jetstream/Button';

export default defineComponent({
    name: "ClientPhoneNumberForm",
    components: {JetInput, JetLabel, JetButton},
    props: ['phoneNumber'],
    data: () => ({
        form: {
            id: null,
            phone_number: '',
            call_handling: 'Route To Agent',
        },
        callHandlingTypes: [
            { label: 'Route To Agent', description: 'Inbound calls will be routed to the agent.'},
            { label: 'Multi-Dialer', description: 'Inbound calls will be routed to the multi-dialer and will be forwarded to all eligible participants'}
        ],
    }),

    mounted() {
        this.form = {
            id: this.phoneNumber.id,
            client_id: this.phoneNumber.client_id,
            phone_number: this.phoneNumber.phone_number,
            forward_number: this.phoneNumber.forward_number,
            call_handling: this.phoneNumber.call_handling
        }
    },
});
</script>

<style scoped>

</style>

