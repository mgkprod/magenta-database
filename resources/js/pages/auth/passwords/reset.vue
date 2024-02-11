<template>
  <form class="flex flex-col overflow-hidden rounded bg-black shadow-sm dark:bg-white" @submit.prevent="submit">
    <div class="w-full grow p-8">
      <h1 class="mb-8 text-center text-2xl font-semibold">Reset password</h1>

      <form-input
        v-model="form.email"
        class="mb-6"
        label="Email"
        placeholder="Your Email Address"
        :errors="$page.props.errors.email"
        required
        autocomplete="email"
      />

      <form-input
        v-model="form.password"
        class="mb-6"
        label="Password"
        placeholder="Your Password"
        type="password"
        :errors="$page.props.errors.password"
        autocomplete="new-password"
        autofocus
        required
      />

      <form-input
        v-model="form.password_confirmation"
        class="mb-8"
        label="Confirm Password"
        placeholder="Confirm Your Password"
        type="password"
        :errors="$page.props.errors.password_confirmation"
        autocomplete="new-password"
        required
      />

      <button
        class="focus:shadow-outline w-full rounded bg-primary-500 py-3 text-sm font-semibold text-black transition duration-200 ease-in-out hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500/50 active:bg-transparent dark:text-white"
      >
        Reset password
      </button>
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
        token: this.token,
        email: this.email,
        password: '',
        password_confirmation: '',
      },
    }
  },

  methods: {
    submit() {
      this.$page.props.errors = {}

      this.$inertia.post(this.route('password.update'), { ...this.form })

      this.form.password = ''
      this.form.password_confirmation = ''
    },
  },
}
</script>
