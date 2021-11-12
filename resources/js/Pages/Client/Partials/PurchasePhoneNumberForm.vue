<template>
    <form @submit.prevent="searchAvailablePhoneNumbers">
        <div>
            <jet-label for="client-phone-number" value="Search Area Code" />
            <jet-input id="client-phone-number" type="tel" class="mt-1 block w-full" v-model="searchAvailablePhoneNumbersForm.areaCode" required autofocus />
        </div>

        <div class="flex items-center justify-end mt-4">
            <jet-button class="ml-4" :class="{ 'opacity-25': searchAvailablePhoneNumbersForm.processing }" :disabled="searchAvailablePhoneNumbersForm.processing">
                Search
            </jet-button>
        </div>
    </form>

    <hr class="mt-8" v-if="availablePhoneNumbers.length > 0">

    <div>
        <div class="flow-root mt-6">
            <ul role="list" class="-my-5 divide-y divide-gray-200">
                <li v-for="availablePhoneNumber in availablePhoneNumbers" class="py-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">
                                {{ availablePhoneNumber.phoneNumber }}
                            </p>
                            <p class="text-sm text-gray-500 truncate">
                                {{ availablePhoneNumber.locality }} {{ availablePhoneNumber.region }} {{ availablePhoneNumber.country }}
                            </p>
                        </div>
                        <div>
                            <a @click="selectPhoneNumberForPurchase(availablePhoneNumber.phoneNumber)" class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50">
                                Buy
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import JetInput from '@/Jetstream/Input';
import JetLabel from '@/Jetstream/Label';
import JetButton   from '@/Jetstream/Button';

export default {
    name: "PurchasePhoneNumberSlideOver",
    components: {JetButton, JetInput, JetLabel},
    emits: ['selectedPhoneNumberForPurchase'],
    data: () => ({
        purchasePhoneNumberModalOpen: false,
        searchAvailablePhoneNumbersForm: {
            areaCode: '',
        },
        availablePhoneNumbers: []
    }),

    methods: {
        searchAvailablePhoneNumbers() {
            axios.get(route('twilio.search-local-numbers'), {
                params: {
                    areaCode: this.searchAvailablePhoneNumbersForm.areaCode
                }
            }).then(response => {
                this.availablePhoneNumbers = response.data.data
            })
        },

        /**
         *
         * @param phoneNumber
         */
        selectPhoneNumberForPurchase(phoneNumber) {
            this.$emit('selectedPhoneNumberForPurchase', phoneNumber);
        }
    }
}
</script>

<style scoped>

</style>
