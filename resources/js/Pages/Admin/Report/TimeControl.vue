<script>
import { Inertia } from '@inertiajs/inertia';
import { defineComponent } from 'vue'

export default defineComponent({
    props: {
        filters: Object
    },

    data() {
        return {
            selectedWeek: this.filters['week'] ?? 'all'
        }
    },

    watch: {
        selectedWeek: function(value) {
            Inertia.get(this.$page.url, {week: value}, {
                replace: true
            })
        },
    },
})
</script>

<template>
    <select
        id="weeks"
        v-model="selectedWeek"
        class="pl-5 pr-10 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block capitalize"
    >
        <option value="all">All</option>
        <option v-for="(n, index) in 15" :value="(index + 1)">{{ 'Week ' + (index + 1) }}</option>
    </select>
</template>
