<script>
import { defineComponent } from 'vue'

export default defineComponent({
    props: {
        success: {
            type: Boolean,
            default: true
        }
    }
})
</script>

<template>
    <div class="center-screen">
        <div class="relative flex flex-col sm:flex-row sm:items-center bg-white shadow rounded-md py-5 pl-6 pr-8 sm:pr-6">
            <div class="flex flex-row items-center border-b sm:border-b-0 w-full sm:w-auto pb-4 sm:pb-0">
                <div :class="[success ? 'text-green-500' : 'text-red-500']">
                    <svg class="w-6 sm:w-5 h-6 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="font-medium ml-3">{{ success ? 'Success' : 'Failed' }} Registration.</div>
            </div>
            <div class="tracking-wide text-gray-500 mt-4 sm:mt-0 sm:ml-4">Your Registration was {{ success ? 'Successful' : 'not Successful' }}. {{ success ? 'You can use our service!' : 'Please try again!' }}</div>
        </div>
    </div>
</template>

<style>
.center-screen {
    position: absolute;
    top: 30%;
    left: 50%;
    margin-right: -50%;
    transform: translate(-50%, -50%);
}
</style>