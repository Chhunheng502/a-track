<script>
import { Inertia } from '@inertiajs/inertia';
import { defineComponent } from 'vue'

export default defineComponent({
    props: {
        classItems: Object,
        filters: Object
    },

    data() {
        return {
            selectedSubject: this.filters['subject'] ?? (this.classItems.data[0]['subject']),
            selectedSection: this.filters['section'] ?? this.classItems.data[0]['sections'][0],
            filteredSections: this.classItems.data[0]['sections']
        }
    },

    watch: {
        selectedSubject: function(value) {
            Inertia.get(this.$page.url, {subject: value}, {
                preserveState: true,
                replace: true
            })
        },

        selectedSection: function(value) {
            Inertia.get(this.$page.url, {section: value}, {
                preserveState: true,
                replace: true
            })
        },
    },

    methods: {
        subjectChanged(e) {
            let index = this.classItems.data.findIndex(item => item.subject == e.target.value)
            this.filteredSections = this.classItems.data[index]['sections']

            this.selectedSection = this.classItems.data[index]['sections'][0]
        },

        removeDash(words) {
            return words.replace(/-/g, ' ');
        }
    }
})
</script>

<template>
    <form class="flex space-x-4">
        <div class="flex items-center space-x-2">
            <label
                for="subjects"
                class="block mb-2 text-lg text-gray-900"
            >
                Subject
            </label>
            <select
                id="subjects"
                v-model="selectedSubject"
                @change="subjectChanged"
                class="pl-5 pr-10 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block capitalize"
            >
                <option v-for="item in classItems.data" :value="item.subject">{{ removeDash(item.subject) }}</option>
            </select>
        </div>
        <div class="flex items-center space-x-2">
            <label
                for="sections"
                class="block mb-2 text-lg text-gray-900"
            >
                Section
            </label>
            <select
                id="sections"
                v-model="selectedSection"
                class="pl-5 pr-10 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block"
            >
                <option v-for="item in filteredSections" :value="item">{{ item }}</option>
            </select>
        </div>
    </form>
</template>
