<script>
import { defineComponent } from 'vue'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import ClassControl from './Control.vue'
import ClassCard from './Card.vue'
import FlashMessage from '@/Components/FlashMessage.vue'

export default defineComponent({
    components: {
        DashboardLayout,
        ClassControl,
        ClassCard,
        FlashMessage
    },

    props: {
        errors: Object,
        classItems: Array
    },
})
</script>

<template>
    <dashboard-layout>
        <div class="p-3">
            <flash-message :message="errors.message"></flash-message>
            <div class="flex justify-between p-3 border-b">
                <h1 class="font-bold text-black">View Classes</h1>
                <class-control></class-control>
            </div>
            <div class="p-5 grid grid-cols-2 lg:grid-cols-4 gap-4">
                <class-card v-for="item in classItems" :classItem="item"></class-card>
            </div>
        </div>
    </dashboard-layout>
</template>