<template>
  <form class="flex flex-col overflow-hidden bg-white dark:bg-black" @submit.prevent="submit">
    <div class="w-full grow p-8">
      <form-input v-model="form.email" class="mb-6" label="Email" :errors="$page.props.errors.email" required autofocus autocomplete="email" />

      <form-input v-model="form.password" class="mb-2" label="Password" type="password" :errors="$page.props.errors.password" required autocomplete="current-password" />

      <div class="mb-8" />

      <button class="focus:shadow-outline w-full rounded bg-primary-500 py-3 text-sm font-semibold text-black transition duration-200 ease-in-out hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500/50 active:bg-transparent dark:text-white">Sign in</button>
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

      this.$inertia.post(this.route('login'), { ...this.form })

      this.form.password = ''
    },
  },
}
</script>
