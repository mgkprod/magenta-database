<template>
    <form class="flex flex-col overflow-hidden bg-white rounded shadow-sm" @submit.prevent="submit">
        <div class="flex-grow w-full p-8">
            <h1 class="mb-8 text-2xl font-semibold text-center">Sign in to your account</h1>

            <form-input class="mb-6"
                    label="Email"
                    placeholder="Your Email Address"
                    v-model="form.email"
                    :errors="$page.props.errors.email"
                    required
                    autofocus
                    autocomplete="email" />

            <form-input class="mb-2"
                    label="Password"
                    placeholder="Your Password"
                    type="password"
                    v-model="form.password"
                    :errors="$page.props.errors.password"
                    required
                    autocomplete="current-password" />

            <div class="mb-8 text-right">
                <inertia-link class="text-sm text-gray-600 hover:text-gray-800" :href="route('password.request')">Forgot password?</inertia-link>
            </div>

            <button class="w-full py-3 text-sm font-semibold text-white transition duration-200 ease-in-out rounded bg-primary-500 active:bg-transparent focus:ring-2 focus:ring-opacity-50 focus:ring-primary-500 hover:bg-primary-600 focus:outline-none focus:shadow-outline">Sign in</button>
        </div>

        <div class="w-full px-5 py-4 text-sm text-center bg-gray-50">
            Don’t have an account yet? <inertia-link :href="route('register')" class="transition duration-200 ease-in-out text-primary-500 hover:text-primary-400">Sign up</inertia-link>
        </div>
    </form>
</template>

<script>
    export default {
        layout: require('../../layouts/gate').default,

        data() {
            return {
                form: {
                    email: '',
                    password: '',
                    remember: false,
                }
            }
        },

        methods: {
            submit() {
                this.$page.props.errors = {}

                this.$inertia.post(
                    this.route('login'), { ...this.form }
                )

                this.form.password = ''
            }
        }
    }
</script>
