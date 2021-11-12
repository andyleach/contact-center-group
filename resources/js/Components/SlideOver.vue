<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="fixed inset-0 overflow-hidden" @close="closePanel">
            <div class="absolute inset-0 overflow-hidden">
                <DialogOverlay class="absolute inset-0" />

                <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex sm:pl-16">
                    <TransitionChild as="template" enter="transform transition ease-in-out duration-500 sm:duration-700" enter-from="translate-x-full" enter-to="translate-x-0" leave="transform transition ease-in-out duration-500 sm:duration-700" leave-from="translate-x-0" leave-to="translate-x-full">
                        <div class="w-screen max-w-2xl">
                            <form class="h-full flex flex-col bg-white shadow-xl overflow-y-scroll">
                                <div class="flex-1">
                                    <!-- Header -->
                                    <div class="px-4 py-6 bg-indigo-700 sm:px-6">
                                        <div class="flex items-start justify-between space-x-3">
                                            <div class="space-y-1">
                                                <DialogTitle class="text-lg font-medium text-white">
                                                    <slot name="title" />
                                                </DialogTitle>
                                                <p class="text-sm text-indigo-300">
                                                    <slot name="description" />
                                                </p>
                                            </div>
                                            <div class="h-7 flex items-center">
                                                <button type="button" class="text-gray-400 hover:text-gray-500" @click="closePanel">
                                                    <span class="sr-only">Close panel</span>
                                                    <XIcon class="h-6 w-6" aria-hidden="true" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Divider container -->
                                    <div class="py-6 px-6">
                                        <slot></slot>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import {Dialog, DialogOverlay, DialogTitle, TransitionChild, TransitionRoot} from "@headlessui/vue";
import {LinkIcon, PlusSmIcon, QuestionMarkCircleIcon} from "@heroicons/vue/solid";
import {XIcon} from "@heroicons/vue/outline";

export default {
    name: "SlideOver",

    props: ['open'],
    components: {
        Dialog,
        DialogOverlay,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        LinkIcon,
        PlusSmIcon,
        QuestionMarkCircleIcon,
        XIcon,
    },

    methods: {
        closePanel() {
            this.$emit('slideOverClosed')
        }
    }
}
</script>

<style scoped>

</style>
