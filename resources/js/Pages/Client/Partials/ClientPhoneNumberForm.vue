<template>
    <form @submit.prevent="submit">
        <div>
            <jet-label for="client-phone-number" value="Phone Number" />
            <jet-input id="client-phone-number" type="tel" class="mt-1 block w-full" v-model="form.phone_number" required autofocus />
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
    name: "PurchaseClientPhoneNumberForm.vue",
    components: {JetInput, JetLabel, JetButton},
    props: ['phoneNumber'],
    data: () => ({
        form: {
            id: null,
            phone_number: '',
            forward_number: '',
            call_handling: 'Route To Agent',
        }
    }),

    mounted() {
        this.form = {
            id: this.client.id,
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

