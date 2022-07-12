<script>
import { defineComponent } from 'vue'
import BreezeModal from '@/Components/Modal.vue'
import { useForm } from '@inertiajs/inertia-vue3'
import Datepicker from '@vuepic/vue-datepicker'
import InputError from '@/Components/InputError.vue'

import '@vuepic/vue-datepicker/dist/main.css'

export default defineComponent({
    components: {
        BreezeModal,
        Datepicker,
        InputError
    },

    data() {
        return {
            showModal: false,
            formItems: [
                {
                    label: 'Subject',
                    placeholder: 'Enter subject' 
                },
                {
                    label: 'Section',
                    placeholder: 'Enter section' 
                },
            ],
            form: useForm({
                subject: '',
                section: '',
                sessions: [
                    {
                        weekday: '',
                        start_at: '',
                        end_at: ''
                    }
                ]
            }),
            weekday: ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"]
        }
    },

    methods: {
        create() {
            this.form.sessions = this.formatAllDates(this.form.sessions)

            this.form.post('https://a-track.herokuapp.com/admin/classes', {
                onSuccess: () => {
                    this.form.reset()
                    this.showModal = false
                }
            })
        },

        addSession() {
            this.form.sessions.push({
                weekday: '',
                start_at: '',
                end_at: ''
            })
        },

        formatDate(date) {
            if (date['hours'] != undefined && date['minutes'] != undefined) {
                if (date['minutes'] >= 10) {
                    return `${date['hours']}:${date['minutes']}`;
                } else {
                    return `${date['hours']}:0${date['minutes']}`;
                }
            }

            return '';
        },

        formatAllDates(dates) {
            let result = []
            dates.forEach(date => {
                result.push({
                    weekday: date.weekday,
                    start_at: this.formatDate(date.start_at),
                    end_at: this.formatDate(date.end_at)
                })
            });

            return result;
        },
    }
})
</script>

<template>
    <form class="flex space-x-4">
        <button
            @click="showModal = true"
            type="button"
            class="text-white bg-purple-500 hover:bg-purple-400 font-medium rounded-lg px-5 py-2.5 text-center"
        >
            <i class="fas fa-plus mr-2"></i>
            Create
        </button>
        <breeze-modal :show="showModal" :maxWidth="'lg'">
            <form class="px-5 py-4">
                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Subject</label>
                    <input
                        type="text"
                        v-model="form.subject"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Enter subject"
                        required
                    >
                    <input-error v-if="$page.props.errors.subject" :message="$page.props.errors.subject"></input-error>
                </div>
                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Section</label>
                    <input
                        type="text"
                        v-model="form.section"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Enter section"
                        required
                    >
                    <input-error v-if="$page.props.errors.section" :message="$page.props.errors.section"></input-error>
                </div>
                <div>
                    <div v-for="(session, index) in form.sessions" class="space-y-2 mb-6">
                        <label class="block text-sm font-medium text-gray-900 dark:text-gray-300">Session {{ index + 1 }}</label>
                        <div class="flex flex-row space-x-2">
                            <select
                                v-model="session.weekday"
                                class="w-full pl-5 pr-10 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md block">
                                    <option v-for="day in weekday" :value="day">{{ day }}</option>
                            </select>
                            <datepicker class="grow" v-model="session.start_at" timePicker></datepicker>
                            <datepicker class="grow" v-model="session.end_at" timePicker></datepicker>
                            <button
                                @click="addSession()"
                                v-if="index == form.sessions.length - 1"
                                type="button"
                                class="text-white bg-blue-500 rounded-md font-medium text-sm px-3 py-2.5"
                            >
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <input-error v-if="$page.props.errors[`sessions.${index}.weekday`]" :message="$page.props.errors[`sessions.${index}.weekday`]"></input-error>
                        <input-error v-if="$page.props.errors[`sessions.${index}.start_at`]" :message="$page.props.errors[`sessions.${index}.start_at`]"></input-error>
                        <input-error v-if="$page.props.errors[`sessions.${index}.end_at`]" :message="$page.props.errors[`sessions.${index}.end_at`]"></input-error>
                    </div>
                </div>
                <div class="flex justify-end space-x-2">
                    <button
                        @click="create()"
                        type="button"
                        class="text-white bg-blue-500 hover:bg-blue-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                    >
                        Submit
                    </button>
                    <button
                        @click="showModal = false"
                        type="button"
                        class="text-white bg-gray-500 hover:bg-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                    >
                        Close
                    </button>
                </div>
            </form>
        </breeze-modal>
    </form>
</template>
