<script>
import { defineComponent } from 'vue'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import Datepicker from '@vuepic/vue-datepicker'
import { Inertia } from '@inertiajs/inertia'

export default defineComponent({
    components: {
        DashboardLayout,
        Datepicker
    },

    props: {
        classItems: Object,
        qrCode: String,
        qrExpiredDate: String
    },

    data() {
        return {
            filteredSections: this.classItems.data[0]?.sections,
            form: {
                subject: this.classItems.data[0]?.subject,
                section: this.classItems.data[0]?.sections[0],
                duration: ''
            },
        }
    },

    methods: {
        subjectChanged(e) {
            let index = this.classItems.data.findIndex(item => item.subject == e.target.value)
            this.filteredSections = this.classItems.data[index]['sections']

            this.form.section = this.classItems.data[index]['sections'][0]
        },

        generate() {
            Inertia.post('https://a-track.herokuapp.com/admin/qr-code', this.form)
        },

        removeDash(words) {
            return words.replace(/-/g, ' ');
        }
    }
})
</script>

<template>
    <dashboard-layout>
        <div v-if="classItems.data[0]" class="p-3">
            <div class="p-3 border-b">
                <h1 class="font-bold text-black">Generate Qr Code</h1>
            </div>
            <div class="p-5 mx-5 md:mx-40">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 md:gap-40">
                    <div class="space-y-2">
                        <form>
                            <div class="mb-6">
                                <label for="subjects" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Choose Subject</label>
                                <select
                                    id="subjects"
                                    v-model="form.subject"
                                    @change="subjectChanged"
                                    class="w-full px-2 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block capitalize">
                                        <option v-for="item in classItems.data" :value="item.subject">{{ removeDash(item.subject) }}</option>
                                </select>
                            </div>
                            <div class="mb-6">
                                <label for="sections" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Choose Section</label>
                                <select
                                    id="sections"
                                    v-model="form.section"
                                    class="w-full px-2 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block">
                                        <option v-for="item in filteredSections" :value="item">{{ item }}</option>
                                </select>
                            </div>
                            <div class="mb-6">
                                <label for="class" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Set Duration (minutes)</label>
                                <input
                                    type="number"
                                    min = "0"
                                    v-model="form.duration"
                                    class="w-full px-2 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block"
                                >
                            </div>
                            <button
                                @click="generate()"
                                type="button"
                                :disabled="qrExpiredDate"
                                class="text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                                :class="[qrExpiredDate ? 'bg-gray-300' : 'bg-purple-500 hover:bg-gray-400']"
                            >
                                Generate Now
                            </button> <br>
                        </form>
                        <div v-if="qrExpiredDate">
                            <p class="font-bold text-red-600">
                                This QR Code is valid until {{ qrExpiredDate }}
                            </p>
                        </div>
                        <div v-else>
                            <p class="text-sm text-gray-600">
                                Please note that there is no option to specify the session of each class. You are assumed to
                                generate QR code when you're in the class session.
                            </p>
                        </div>
                    </div>
                    <div>
                        <img
                            v-if="qrCode"
                            :src="qrCode"
                            alt="qr-code"
                        >
                        <span v-else class="text-gray-400">
                            Qr Code will be generated here...
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="p-3">
            Please create class to generate QR code !!!
        </div>
    </dashboard-layout>
</template>
