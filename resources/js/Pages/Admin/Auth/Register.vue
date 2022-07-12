<script>
import { useForm } from '@inertiajs/inertia-vue3'
import { defineComponent } from 'vue'
import InputError from '@/Components/InputError.vue'

export default defineComponent({
    components: {
        InputError
    },
    
    props: {
        errors: Object,
    },

    data() {
        return {
            form: useForm({
                name: '',
                email: '',
                password: '',
                confirm_password: ''
            })
        }
    },

    methods: {
        register() {
            this.form.post('https://a-track.herokuapp.com/admin/register', {
                onSuccess: () => this.form.reset('password'),
            })
        }
    }
})
</script>

<template>
    <main class="bg-white max-w-lg mx-auto p-8 md:p-12 my-10 rounded-lg shadow-2xl">
        <section>
            <h3 class="font-bold text-2xl">Create New Account Now!</h3>
        </section>
        <section class="mt-10">
            <form class="flex flex-col" method="POST" action="#">
                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="username">Username</label>
                    <input
                        type="text"
                        id="username"
                        v-model="form.name"
                        class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3"
                        placeholder="Enter your username"
                    >
                    <input-error v-if="errors.name" :message="errors.name"></input-error>
                </div>
                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="email">Email</label>
                    <input
                        type="text"
                        id="email"
                        v-model="form.email"
                        class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3"
                        placeholder="Enter your email"
                    >
                    <input-error v-if="errors.email" :message="errors.email"></input-error>
                </div>
                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="password">Password</label>
                    <input 
                        type="password"
                        id="password"
                        v-model="form.password"
                        class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3"
                        placeholder="Enter your password"
                    >
                    <input-error v-if="errors.password" :message="errors.password"></input-error>
                </div>
                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="confirm_password">Confirm Password</label>
                    <input
                        type="password"
                        id="confirm_password"
                        v-model="form.confirm_password"
                        class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3"
                        placeholder="Enter your password again"
                    >
                    <input-error v-if="errors.confirm_password" :message="errors.confirm_password"></input-error>
                </div>
                <button
                    @click="register()"
                    type="button"
                    class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200"
                >
                    Create
                </button>
            </form>
        </section>
    </main>
</template>


