<template>
  <form class="flex flex-col overflow-hidden bg-black rounded shadow-sm dark:bg-white" @submit.prevent="submit">
    <div class="flex-grow w-full p-8">
      <h1 class="mb-8 text-2xl font-semibold text-center">Create a new account</h1>

      <form-input v-model="form.name" class="mb-6" label="Name" placeholder="Your Name" :errors="$page.props.errors.name" autocomplete="name" required autofocus />

      <form-input v-model="form.email" class="mb-6" label="Email" placeholder="Your Email Address" :errors="$page.props.errors.email" autocomplete="email" required />

      <form-input v-model="form.password" class="mb-6" label="Password" placeholder="Your Password" type="password" :errors="$page.props.errors.password" autocomplete="new-password" required />

      <form-input v-model="form.password_confirmation" class="mb-8" label="Confirm Password" placeholder="Confirm Your Password" type="password" :errors="$page.props.errors.password_confirmation" autocomplete="new-password" required />

      <button class="w-full py-3 text-sm font-semibold text-black transition duration-200 ease-in-out rounded dark:text-white bg-primary-500 active:bg-transparent focus:ring-2 focus:ring-opacity-50 focus:ring-primary-500 hover:bg-primary-600 focus:outline-none focus:shadow-outline">Sign up</button>
    </div>
    <div class="w-full px-5 py-4 text-sm text-center bg-gray-50">
      Already have an account?
      <inertia-link :href="route('login')" class="transition duration-200 ease-in-out text-primary-500 hover:text-primary-400">Sign in</inertia-link>
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
        password: '',
        remember: false,
      },
    }
  },

  methods: {
    submit() {
      this.$page.props.errors = {}

      this.$inertia.post(this.route('register'), { ...this.form })

      this.form.password = ''
      this.form.password_confirmation = ''
    },
  },
}
</script>
