<script>
import { defineComponent } from 'vue'
import { Link } from '@inertiajs/inertia-vue3'
import BreezeDropdown from '@/Components/Dropdown.vue'
import BreezeDropdownLink from '@/Components/DropdownLink.vue'
import { Inertia } from '@inertiajs/inertia'

export default defineComponent({
    components: {
        Link,
        BreezeDropdown,
        BreezeDropdownLink
    },

    data() {
        return {
            sidebarItems: [
                // {
                //     name: 'Home',
                //     link: '/home',
                //     icon: 'fa-home',
                // },
                {
                    name: 'Classes',
                    link: '/classes',
                    icon: 'fa-graduation-cap',
                },
                {
                    name: 'Report',
                    link: '/report',
                    icon: 'fa-chart-pie',
                },
                {
                    name: 'QR Code',
                    link: '/qr-code',
                    icon: 'fa-qrcode',
                },
                {
                    name: 'Log out',
                    link: '/logout',
                    icon: 'fa-sign-out',
                }
            ],
        }
    },

    methods: {
        updateSearchResults(e) {
            Inertia.get(this.$page.url, {search: e.target.value}, {
                preserveState: true,
                replace: true
            })
        }
    }
})
</script>

<template>
    <body class="flex min-w-min min-h-screen bg-gray-100 font-sans">
        <div id="sidebar" class="h-screen w-16 menu bg-black text-white px-4 flex items-center nunito fixed shadow">
            <ul class="list-reset ">
                <li
                    v-for="item in sidebarItems"
                    class="my-2 md:my-0"
                >
                    <Link
                        :href="'https://a-track.herokuapp.com/admin' + item.link"
                        :method="item.link == '/logout' ? 'post' : 'get'"
                        class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-indigo-400 cursor-pointer"
                    >
                        <i class="fas fa-fw mr-3" :class="[item.icon, $page.url == ('/admin' + item.link) ? 'text-indigo-400' : '']"></i>
                        <span class="w-full inline-block pb-1 md:pb-0 text-sm">{{ item.name }}</span>
                    </Link>
                </li>
            </ul>
        </div>
        <div class="flex flex-row flex-wrap flex-1 flex-grow content-start pl-16">
            <div class="h-40 lg:h-20 w-full flex flex-wrap">
                <nav class="bg-gray-100 w-auto flex-1 border-b-1 border-gray-300 order-1 lg:order-2">
                    <div class="flex h-full justify-around items-center">
                        <div class="relative w-full max-w-3xl px-6">
                            <div class="absolute h-10 mt-1 left-0 top-0 flex items-center pl-10">
                                <svg class="h-4 w-4 fill-current text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"></path>
                                </svg>
                            </div>
                            <input
                                id="search-toggle"
                                type="search"
                                placeholder="Search"
                                class="block w-full bg-gray-200 focus:outline-none focus:bg-white focus:shadow-md text-gray-700 font-bold rounded-full pl-12 pr-4 py-3"
                                @keydown.enter="updateSearchResults"
                            >
                        </div>
                        <div class="relative inline-block pr-6">
                            <div class="relative text-sm">
                                <breeze-dropdown>
                                    <template #trigger>
                                        <button
                                            class="flex items-center focus:outline-none mr-3"
                                        >
                                            <img class="w-8 h-8 rounded-full mr-4" :src="$page.props.auth.user.photo_url" alt="Avatar of User"> <span class="hidden md:inline-block">{{ $page.props.auth.user.name }} </span>
                                            <svg class="pl-2 h-2" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129">
                                                <g>
                                                    <path d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z"></path>
                                                </g>
                                            </svg>
                                        </button>
                                    </template>

                                    <template #content>
                                        <ul class="list-reset">
                                            <!-- <li><breeze-dropdown-link href="#" class="px-4 py-2 block text-gray-900 hover:bg-indigo-400 hover:text-white no-underline hover:no-underline">My account</breeze-dropdown-link></li>
                                            <li><breeze-dropdown-link href="#" class="px-4 py-2 block text-gray-900 hover:bg-indigo-400 hover:text-white no-underline hover:no-underline">Notifications</breeze-dropdown-link></li>
                                            <li><breeze-dropdown-link href="#" class="px-4 py-2 block text-gray-900 hover:bg-indigo-400 hover:text-white no-underline hover:no-underline">Setting</breeze-dropdown-link></li>
                                            <li>
                                                <hr class="border-t mx-2 border-gray-400">
                                            </li> -->
                                            <li>
                                                <Link
                                                    href="https://a-track.herokuapp.com/admin/logout"
                                                    as="button"
                                                    type="button"
                                                    method="post"
                                                    class="w-full px-4 py-2 block text-left text-gray-900 hover:bg-indigo-400 hover:text-white no-underline hover:no-underline"
                                                >
                                                    Log out
                                                </Link>
                                            </li>
                                        </ul>
                                    </template>
                                </breeze-dropdown>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="w-full p-6">
                <slot></slot>
            </div>
        </div>
    </body>
</template>

<style>
.nunito {
    font-family: 'nunito', font-sans;
}

.border-b-1 {
    border-bottom-width: 1px;
}

.border-l-1 {
    border-left-width: 1px;
}

hover\:border-none:hover {
    border-style: none;
}

#sidebar {
    transition: ease-in-out all .3s;
    z-index: 9999;
}

#sidebar span {
    opacity: 0;
    position: absolute;
    transition: ease-in-out all .1s;
}

#sidebar:hover {
    width: 150px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    /*shadow-2xl*/
}

#sidebar:hover span {
    opacity: 1;
}
</style>