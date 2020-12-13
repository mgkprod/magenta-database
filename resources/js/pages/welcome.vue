<template>
    <div>
        <div class="absolute inset-0 bottom-auto">
            <div class="container max-w-screen-xl">
                <div class="flex flex-row items-center justify-end pt-4 -mx-2">
                    <inertia-link v-if="$page.props.user" class="flex items-center px-4 py-2 mx-1 text-sm font-semibold text-gray-500 transition duration-200 ease-in-out rounded hover:text-primary-500 hover:bg-primary-100 active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-primary-500" :href="route('home')">Home</inertia-link>
                    <template v-else>
                        <inertia-link class="flex items-center px-4 py-2 mx-1 text-sm font-semibold text-gray-500 transition duration-200 ease-in-out rounded hover:text-primary-500 hover:bg-primary-100 active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-primary-500" :href="route('login')">Login</inertia-link>
                        <inertia-link class="flex items-center px-4 py-2 mx-1 text-sm font-semibold text-gray-500 transition duration-200 ease-in-out rounded hover:text-primary-500 hover:bg-primary-100 active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-primary-500" :href="route('register')">Register</inertia-link>
                    </template>
                </div>
            </div>
        </div>
        <div class="container max-w-screen-xl">
            <div class="flex flex-col items-center justify-center h-screen">
                <h1 class="mb-8 text-6xl font-bold tracking-tight text-primary-500">{{ $page.props.app_name }}</h1>

                <div class="flex flex-row items-center mb-4 -mx-4">
                    <a class="mx-4 font-semibold text-gray-600 transition duration-200 ease-in-out hover:text-gray-400" target="_blank" href="https://vuejs.org/v2/guide/">Vue.js</a>
                    <a class="mx-4 font-semibold text-gray-600 transition duration-200 ease-in-out hover:text-gray-400" target="_blank" href="https://inertiajs.com/">Inertia.js</a>
                    <a class="mx-4 font-semibold text-gray-600 transition duration-200 ease-in-out hover:text-gray-400" target="_blank" href="https://tailwindcss.com/">Tailwind CSS</a>
                    <a class="mx-4 font-semibold text-gray-600 transition duration-200 ease-in-out hover:text-gray-400" target="_blank" href="https://laravel.com/docs">Laravel</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        //
    }
</script>
