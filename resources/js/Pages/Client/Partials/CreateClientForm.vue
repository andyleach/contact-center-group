<template>
    <form @submit.prevent="submit">
        <div>
            <jet-label for="client-label" value="Client Name" />
            <jet-input id="client-label" type="text" class="mt-1 block w-full" v-model="form.label" required autofocus />
        </div>

        <div class="flex items-center justify-end mt-4">
            <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Create Client
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
    name: "CreateClientForm",
    components: {JetInput, JetLabel, JetButton},
    data: () => ({
        form: {
            label: ''
        }
    }),

    methods: {
        submit() {
            this.$inertia.post('/clients', this.form)
        }
    }
})
</script>

<style scoped>

</style>
