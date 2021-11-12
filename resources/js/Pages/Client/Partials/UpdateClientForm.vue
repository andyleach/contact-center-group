<template>
    <form @submit.prevent="submit">
        <div>
            <jet-label for="client-label" value="Client Name" />
            <jet-input id="client-label" type="text" class="mt-1 block w-full" v-model="form.label" required autofocus />
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
    name: "UpdateClientForm",
    components: {JetInput, JetLabel, JetButton},
    props: ['client'],
    data: () => ({
        form: {
            id: null,
            label: ''
        }
    }),

    mounted() {
        this.form = {
            id: this.client.id,
            label: this.client.label
        }
    },

    methods: {
        submit() {
            this.$inertia.put('/clients/' + this.form.id, this.form)
        }
    }
})
</script>

<style scoped>

</style>
