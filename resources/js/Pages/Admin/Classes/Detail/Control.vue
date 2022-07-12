<script>
import { defineComponent } from 'vue'
import BreezeModal from '@/Components/Modal.vue'
import { useForm } from '@inertiajs/inertia-vue3'

export default defineComponent({
    components: {
        BreezeModal
    },

    props: {
        classItem: {
            type: Object
        },
        link: {
            type: String
        }
    },

    data() {
        return {
            showModal: false,
            form: useForm({
                email: '',
                subject: this.classItem.subject,
                section: this.classItem.section
            })
        }
    },

    methods: {
        sendInvitation() {
            this.form.post('https://a-track.herokuapp.com/classes/inv/mail', {
                onSuccess: () => this.showModal = false,
            })
        },

        myFunction() {
            var copyText = document.getElementById("myInput");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyText.value);
            
            var tooltip = document.getElementById("myTooltip");
            tooltip.innerHTML = "Copied";
        },

        outFunc() {
            var tooltip = document.getElementById("myTooltip");
            tooltip.innerHTML = "Copy";
        }
    },
})
</script>

<template>
    <form class="flex space-x-4">
        <button
            @click="showModal = true"
            type="button"
            class="text-white bg-purple-500 hover:bg-gray-400 font-medium rounded-lg px-5 py-2.5 text-center"
        >
            <i class="fas fa-envelope mr-2"></i>
            Invite Students
        </button>
        <breeze-modal :show="showModal" :maxWidth="'lg'">
            <form class="px-5 py-4 mt-4 space-y-2">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Copy Link</label>
                    <div class="relative w-full">
                        <input
                            type="text"
                            class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-lg border-l-gray-100 border-l-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                            id="myInput"
                            :value="link"
                            disabled
                        >
                        <div class="tooltip">
                            <button
                                @click="myFunction()"
                                @mouseout="outFunc()"
                                type="button"
                                class="absolute top-0 right-0 p-2.5 text-sm rounded-tr-lg rounded-br-lg font-medium text-white bg-gray-500 hover:bg-gray-400"
                            >
                                <span class="tooltiptext" id="myTooltip">Copy</span>
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end space-x-2">
                    <button
                        @click="showModal = false"
                        type="submit"
                        class="text-white bg-gray-500 hover:bg-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                    >
                        Close
                    </button>
                </div>
            </form>
        </breeze-modal>
    </form>
</template>

<style>
.tooltip {
  display: inline-block;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 60px;
  background-color: #555;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px;
  position: absolute;
  z-index: 1;
  bottom: 150%;
  left: 50%;
  margin-left: -75px;
  opacity: 0;
  transition: opacity 0.3s;
}

.tooltip .tooltiptext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
}
</style>
