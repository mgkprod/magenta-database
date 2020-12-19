<template>
    <form class="flex flex-col overflow-hidden bg-black rounded shadow-sm dark:bg-white" @submit.prevent="submit">
        <div class="flex-grow w-full p-8">
            <h1 class="mb-8 text-2xl font-semibold text-center">Confirm password</h1>

            <p class="mb-10 text-sm text-gray-600">
                Please confirm your password before continuing.
            </p>

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

            <button class="w-full py-3 text-sm font-semibold text-black transition duration-200 ease-in-out rounded dark:text-white bg-primary-500 active:bg-transparent focus:ring-2 focus:ring-opacity-50 focus:ring-primary-500 hover:bg-primary-600 focus:outline-none focus:shadow-outline">Confirm password</button>
        </div>
    </form>
</template>

<script>
    export default {
        layout: require('../../../layouts/gate').default,

        props: {
            email: String,
            token: String,
        },

        data() {
            return {
                form: {
                    password: '',
                },
            }
        },

        methods: {
            submit() {
                this.$page.props.errors = {}

                this.$inertia.post(
                    this.route('password.confirm'), { ...this.form }
                )

                this.form.password = ''
            },
        }
    }
</script>
