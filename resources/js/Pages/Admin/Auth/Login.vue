<script>
import { defineComponent } from 'vue'
import { Link, useForm } from '@inertiajs/inertia-vue3'
import InputError from '@/Components/InputError.vue'

export default defineComponent({    
    components: {
        Link,
        InputError
    },

    props: {
        errors: Object,
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
            this.form.post('https://a-track.herokuapp.com/admin/login', {
                onSuccess: () => this.form.reset('password'),
            })
        }
    }
})
</script>

<template>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4'">
        <div class="grow flex items-center justify-center">
            <img src="../../../../images/user.jpg" alt="An Illustration" width="400" height="400"/>
        </div>
        <main class="bg-white grow max-w-screen-md mx-20 p-8 md:p-12  my-10 rounded-lg shadow-2xl">
            <section>
                <h3 class="font-bold text-2xl">Welcome to A-Track!</h3>
                <p class="text-gray-600 pt-2">Sign in to your account.</p>
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
                        <input-error v-if="errors.email" :message="errors.email"></input-error>
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
                        <input-error v-if="errors.password" :message="errors.password"></input-error>
                    </div>
                    <input-error v-if="errors.message" :message="errors.message"></input-error>
                    <button
                        @click="login()"
                        type="button"
                        class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200"
                    >
                        Sign In
                    </button>   
                    <br>
                    <Link
                        href="https://a-track.herokuapp.com/admin/register"
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
    </div>
</template>


