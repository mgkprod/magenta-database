<template>
  <form class="flex flex-col overflow-hidden rounded bg-black shadow-sm dark:bg-white" @submit.prevent="submit">
    <div class="w-full grow p-8">
      <h1 class="mb-8 text-center text-2xl font-semibold">Confirm password</h1>

      <p class="mb-10 text-sm text-gray-600">Please confirm your password before continuing.</p>

      <form-input v-model="form.password" class="mb-2" label="Password" placeholder="Your Password" type="password" :errors="$page.props.errors.password" required autocomplete="current-password" />

      <div class="mb-8 text-right">
        <inertia-link class="text-sm text-gray-600 hover:text-gray-800" :href="route('password.request')">Forgot password?</inertia-link>
      </div>

      <button class="focus:shadow-outline w-full rounded bg-primary-500 py-3 text-sm font-semibold text-black transition duration-200 ease-in-out hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500/50 active:bg-transparent dark:text-white">Confirm password</button>
    </div>
  </form>
</template>

<script>
import Layout from '@/layouts/gate.vue'

export default {
  layout: Layout,

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

      this.$inertia.post(this.route('password.confirm'), { ...this.form })

      this.form.password = ''
    },
  },
}
</script>
