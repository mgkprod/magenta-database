<template>
    <div class="flex flex-col w-full min-h-screen mx-auto bg-gray-100">
        <header class="fixed top-0 left-0 right-0 z-30 flex items-center flex-none h-16 bg-white shadow-sm">
            <div class="container flex justify-between max-w-screen-xl">
                <nav class="flex flex-row items-center justify-start w-full -mx-1">
                    <inertia-link :href="route('index')" class="inline-flex items-center mx-1 text-lg font-bold tracking-tight transition duration-200 ease-in-out text-primary-500 hover:text-primary-400">
                        <span>{{ $page.props.app_name }}</span>
                    </inertia-link>

                    <div class="ml-4" v-if="$page.props.user">
                        <inertia-link
                            class="flex items-center px-4 py-2 mx-1 text-sm font-semibold text-gray-500 transition duration-200 ease-in-out rounded hover:text-primary-500 hover:bg-primary-100 active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-primary-500"
                            :class="{ 'text-primary-500 bg-primary-100': route().current('home') }"
                            :href="route('home')"
                        >
                            <span>Home</span>
                        </inertia-link>
                    </div>

                    <div class="mx-auto"></div>

                    <template v-if="$page.props.user">
                        <button
                            class="flex items-center px-4 py-2 mx-1 text-sm font-semibold text-gray-500 transition duration-200 ease-in-out rounded hover:text-primary-500 hover:bg-primary-100 active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-primary-500"
                            @click="$inertia.post(route('logout'))"
                        >
                            <span>Logout</span>
                        </button>
                    </template>

                    <template v-else>
                        <inertia-link
                            class="flex items-center px-4 py-2 mx-1 text-sm font-semibold text-gray-500 transition duration-200 ease-in-out rounded hover:text-primary-500 hover:bg-primary-100 active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-primary-500"
                            :class="{ 'text-primary-500 bg-primary-100': route().current('login') }"
                            :href="route('login')"
                        >
                            <span>Login</span>
                        </inertia-link>

                        <inertia-link
                            class="flex items-center px-4 py-2 mx-1 text-sm font-semibold text-gray-500 transition duration-200 ease-in-out rounded hover:text-primary-500 hover:bg-primary-100 active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-primary-500"
                            :class="{ 'text-primary-500 bg-primary-100': route().current('register') }"
                            :href="route('register')"
                        >
                            <span>Register</span>
                        </inertia-link>
                    </template>
                </nav>
            </div>
        </header>

        <main class="flex flex-col flex-auto max-w-full py-8 mt-16">
            <main class="container max-w-screen-xl">
                <slot></slot>
            </main>
        </main>

        <footer class="flex items-center flex-none text-sm bg-white">
            <div class="container flex flex-row items-center justify-between h-12 max-w-screen-xl">
                <div>
                    © 2021 - <inertia-link :href="route('index')" target="_blank" class="transition duration-200 ease-in-out text-primary-600 hover:text-primary-400">{{ $page.props.app_name }}</inertia-link>
                </div>
                <div v-if="$page.props.version" class="inline-flex px-2 py-1 text-xs font-semibold leading-4 text-gray-700 bg-gray-200 rounded">
                    {{ $page.props.version }}
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
    export default {
        //
    }
</script>
