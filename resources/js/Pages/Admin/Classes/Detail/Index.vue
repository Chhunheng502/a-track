<script>
import { defineComponent } from 'vue'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import ClassDetailControl from './Control.vue'
import ClassDetailTable from './Table.vue'

export default defineComponent({
    components: {
        DashboardLayout,
        ClassDetailControl,
        ClassDetailTable,
    },

    props: {
        classItem: {
            type: Object
        },
        invitationLink: {
            type: String
        }
    },

    methods: {
        removeDash(words) {
            return words.replace(/-/g, ' ');
        },
    }
})
</script>

<template>
    <dashboard-layout>
        <div class="p-3">
            <div class="flex justify-between p-3 border-b">
                <h1 class="font-bold text-black capitalize">{{ removeDash(classItem.subject) }} Section {{ classItem.section }}</h1>
                <class-detail-control :classItem="classItem" :link="invitationLink"></class-detail-control>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-6 gap-20 p-5">
                <class-detail-table class="order-2 md:order-1 md:col-span-4" :registrations="classItem.registrations"></class-detail-table>
                <div class="order-1 md:order-2">
                    <h3 class="font-bold">Sessions</h3>
                    <ul class="list-item list-disc">
                        <li v-for="session in classItem.sessions">{{ session.weekday + ', ' + session.start_at + ' - ' + session.end_at }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </dashboard-layout>
</template>

