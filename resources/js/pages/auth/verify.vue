<template>
    <form class="flex flex-col overflow-hidden bg-black rounded shadow-sm dark:bg-white" @submit.prevent="submit">
        <div class="flex-grow w-full p-8">
            <h1 class="mb-8 text-2xl font-semibold text-center">Verify your email address</h1>

            <p class="mb-10 text-sm text-gray-600">
                Before proceeding, please check your email for a verification link. If you did not receive the email click the button below to request another.
            </p>

            <button class="w-full py-3 text-sm font-semibold text-black transition duration-200 ease-in-out rounded dark:text-white bg-primary-500 active:bg-transparent focus:ring-2 focus:ring-opacity-50 focus:ring-primary-500 hover:bg-primary-600 focus:outline-none focus:shadow-outline">Resend verification email</button>
        </div>
    </form>
</template>

<script>
    export default {
        layout: require('../../layouts/gate').default,

        data() {
            return {
                form: {}
            }
        },

        methods: {
            submit() {
                this.$page.props.errors = {}

                this.$inertia.post(
                    this.route('verification.resend'), { ...this.form }
                )

                this.form.password = ''
            }
        }
    }
</script>
