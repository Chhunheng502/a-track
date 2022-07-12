<script>
import { defineComponent } from 'vue'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import ReportTimeControl from './TimeControl.vue'
import ReportClassControl from './ClassControl.vue'
import ReportTable from './Table.vue'

export default defineComponent({
    components: {
        DashboardLayout,
        ReportTimeControl,
        ReportClassControl,
        ReportTable,
    },

    props: {
        classItems: Object,
        attendanceData: Object,
        filters: Object
    },
})
</script>

<template>
    <dashboard-layout>
        <div v-if="classItems.data[0]" class="p-3">
            <div class="flex justify-between p-3 border-b">
                <div class="flex items-center space-x-2">
                    <h1 class="font-bold text-black">Attendance Report</h1>
                    <report-time-control :filters="filters"></report-time-control>
                </div>
                <div class="flex justify-between items-center space-x-4">
                    <report-class-control :classItems="classItems" :filters="filters"></report-class-control>
                    <button
                        @click="$refs.reportTable.tableToCSV()"
                        type="button"
                        class="text-white bg-purple-500 hover:bg-purple-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                    >
                        <i class="fas fa-file-export mr-2"></i>
                        Export CSV
                    </button>
                </div>
            </div>
            <div class="p-5">
                <report-table :attendanceData="attendanceData" ref="reportTable"></report-table>
            </div>
        </div>
        <div v-else class="p-3">
            Please create class to view report !!!
        </div>
    </dashboard-layout>
</template>