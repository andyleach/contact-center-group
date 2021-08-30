<template>
    <jet-form-section @submitted="createLeadDisposition">
        <template #title>
            Lead Dispositions
        </template>

        <template #description>
            Create a new lead disposition.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="label" value="Disposition Name" />
                <jet-input id="label" type="text" class="mt-1 block w-full" v-model="form.label" autofocus />
                <jet-label for="description" value="Disposition Description" />
                <jet-input id="description" type="text" class="mt-1 block w-full" v-model="form.description" autofocus />
                <jet-input-error :message="form.errors.name" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Create
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
import JetButton from '@/Jetstream/Button.vue'
import JetFormSection from '@/Jetstream/FormSection.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'

export default {
    components: {
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
    },

    data() {
        return {
            form: this.$inertia.form({
                label: '',
                description: '',
            })
        }
    },

    methods: {
        createLeadDisposition() {
            this.form.post(route('lead-dispositions.store'), {
                errorBag: 'createLeadDisposition',
                preserveScroll: true
            });
        },
    },
}
</script>
