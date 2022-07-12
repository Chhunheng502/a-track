<script>
import { defineComponent } from 'vue'
import { Link } from '@inertiajs/inertia-vue3'

export default defineComponent({
    components: {
        Link,
    },

    props: {
        classItem: Object
    },

    computed: {
        getLink() {
            return this.classItem.subject + '/' + this.classItem.section
        }
    },

    methods: {
        removeDash(words) {
            return words.replace(/-/g, ' ');
        }
    }
})
</script>

<template>
    <div class="max-w-xs bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
        <Link :href="'https://a-track.herokuapp.com/admin/classes/' + getLink">
            <img class="rounded-t-lg" :src="classItem.thumbnail" alt="thumbnail">
        </Link>
        <div class="p-5">
            <Link :href="'https://a-track.herokuapp.com/admin/classes/' + getLink">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-purple-500 dark:text-white capitalize">{{ removeDash(classItem.subject) }}</h5>
            </Link>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Section {{ classItem.section }}</p>
        </div>
    </div>
</template>

