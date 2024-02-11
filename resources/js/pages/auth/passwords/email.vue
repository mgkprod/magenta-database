<template>
  <form class="flex flex-col overflow-hidden rounded bg-black shadow-sm dark:bg-white" @submit.prevent="submit">
    <div class="w-full grow p-8">
      <h1 class="mb-8 text-center text-2xl font-semibold">Reset password</h1>

      <h3 v-if="success" class="mb-8 rounded bg-green-100 px-4 py-3 text-sm text-green-800">We have e-mailed your password reset link!</h3>

      <form-input v-model="form.email" class="mb-8" label="Email" placeholder="Your Email Address" :errors="$page.props.errors.email" required autofocus autocomplete="email" />

      <button class="focus:shadow-outline w-full rounded bg-primary-500 py-3 text-sm font-semibold text-black transition duration-200 ease-in-out hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500/50 active:bg-transparent dark:text-white">Send password reset link</button>
    </div>
    <div class="w-full bg-gray-50 px-5 py-4 text-center text-sm">
      Remembered your password?
      <inertia-link :href="route('login')" class="text-primary-500 transition duration-200 ease-in-out hover:text-primary-400">Sign in</inertia-link>
    </div>
  </form>
</template>

<script>
import Layout from '@/layouts/gate.vue'

export default {
  layout: Layout,

  data() {
    return {
      form: {
        email: '',
      },

      success: false,
    }
  },

  methods: {
    async submit() {
      this.success = false
      this.$page.props.errors = {}

      await this.$inertia.post(this.route('password.email'), { ...this.form })

      if (!this.$page.props.errors.email) {
        this.form = {}
        this.success = true
      }
    },
  },
}
</script>
