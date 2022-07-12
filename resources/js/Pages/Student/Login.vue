<script>
import { defineComponent } from 'vue'
import { Link, useForm } from '@inertiajs/inertia-vue3'

export default defineComponent({    
    components: {
        Link
    },

    data() {
        return {
            form: useForm({
                email: '',
                password: '',
            })
        }
    },

    methods: {
        login() {
            this.form.post('https://a-track.herokuapp.com/student/login', {
                onSuccess: () => this.form.reset('password'),
            })
        }
    }
})
</script>

<template>
    <main class="bg-white max-w-lg mx-auto p-8 md:p-12 my-10 rounded-lg shadow-2xl">
        <section>
            <h3 class="font-bold text-2xl">Authentication is required!</h3>
            <p class="text-gray-600 pt-2">Sign in to your account to validate your identity.</p>
        </section>
        <section class="mt-10">
            <form class="flex flex-col" method="POST" action="#">
                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <div class="flex flex-row">
                         <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="email">Email</label>
                         <label class="block text-red-700 text-sm font-bold mb-2 ml-3" for="email">*</label>
                    </div>
                    <input
                        type="text"
                        id="email"
                        v-model="form.email"
                        class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3"
                        placeholder="Enter your email"
                    >
                </div>
                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <div class="flex flex-row">
                         <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="email">Password</label>
                         <label class="block text-red-700 text-sm font-bold mb-2 ml-3" for="email">*</label>
                    </div>
                    <input 
                        @keyup.enter="login()"
                        type="password"
                        id="password"
                        v-model="form.password"
                        class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3"
                        placeholder="Enter your password"
                    >
                </div>
                <button
                    @click="login()"
                    type="button"
                    class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200"
                >
                    Sign In
                </button>   
                <br>
                <Link
                    href="https://a-track.herokuapp.com/student/register"
                    as="button"
                    type="button"
                    class="border-2 border-gray-300 rounded py-2 "
                >
                    <div class="inline-flex items-center mx-auto">
                        Create New Account
                    </div>
                </Link>
            </form>
        </section>
    </main>
</template>


