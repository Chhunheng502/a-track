<template>
    <div v-if="show" class="alert rounded-lg text-white">
        {{ message }}
    </div>
</template>

<style>
.alert {
    position: fixed;
    top: 90%;
    right: 10%;
    z-index: 80;
    padding: 5px 20px;
    background-color: rgb(72, 137, 227);
}
</style>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
    props: {
        message: String
    },

    data() {
        return {
            show: false
        }
    },
    
    watch: {
        'message': {
            handler() {
                if(this.message) {
                    this.show = true;
                    setTimeout(() => this.show = false, 4000)
                }
            },
                deep: true,
            },
    },
})
</script>
