<script>
import { Inertia } from '@inertiajs/inertia'
import { defineComponent } from 'vue'

export default defineComponent({
    props: {
        registrations: Array
    },

    data() {
        return {
            thItems: [
                {
                    name: 'Name'
                },
                {
                    name: 'Email'
                },
                {
                    name: 'Registration Date'
                }
            ]
        }
    },

    methods: {
        remove(registration) {
            Inertia.delete(`https://a-track.herokuapp.com/admin/registrations/${registration.id}`, {
                onSuccess: () => console.log('success')
            })
        }
    }
})
</script>

<template>
    <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
        <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th
                            v-for="item in thItems"
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                        >
                            {{ item.name }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="registration in registrations"
                    >
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-10 h-10">
                                    <img class="w-full h-full rounded-full"
                                        :src="registration.student.photo_url"
                                        alt="" />
                                </div>
                                    <div class="ml-3">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                            {{ registration.student.name }}
                                        </p>
                                    </div>
                                </div>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ registration.student.email }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">
                                {{ registration.created_at }}
                            </p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <span
                                @click="remove(registration)"
                                class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight cursor-pointer"
                            >
                                <span aria-hidden
                                    class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                            <span class="relative">Remove</span>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- <div
                class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between          ">
                <span class="text-xs xs:text-sm text-gray-900">
                    Showing 1 to 4 of 50 Entries
                </span>
                <div class="inline-flex mt-2 xs:mt-0">
                    <button
                        class="text-sm text-indigo-50 transition duration-150 hover:bg-gray-400 bg-gray-500 font-semibold py-2 px-4 rounded-l">
                        Prev
                    </button>
                    &nbsp; &nbsp;
                    <button
                        class="text-sm text-indigo-50 transition duration-150 hover:bg-gray-400 bg-gray-500 font-semibold py-2 px-4 rounded-r">
                        Next
                    </button>
                </div>
            </div> -->
        </div>
    </div>
</template>