<template>
  <form class="flex flex-col overflow-hidden bg-black rounded shadow-sm dark:bg-white" @submit.prevent="submit">
    <div class="flex-grow w-full p-8">
      <h1 class="mb-8 text-2xl font-semibold text-center">Reset password</h1>

      <h3 v-if="success" class="px-4 py-3 mb-8 text-sm text-green-800 bg-green-100 rounded">We have e-mailed your password reset link!</h3>

      <form-input class="mb-8" label="Email" placeholder="Your Email Address" v-model="form.email" :errors="$page.props.errors.email" required autofocus autocomplete="email" />

      <button class="w-full py-3 text-sm font-semibold text-black transition duration-200 ease-in-out rounded dark:text-white bg-primary-500 active:bg-transparent focus:ring-2 focus:ring-opacity-50 focus:ring-primary-500 hover:bg-primary-600 focus:outline-none focus:shadow-outline">Send password reset link</button>
    </div>
    <div class="w-full px-5 py-4 text-sm text-center bg-gray-50">
      Remembered your password?
      <inertia-link :href="route('login')" class="transition duration-200 ease-in-out text-primary-500 hover:text-primary-400">Sign in</inertia-link>
    </div>
  </form>
</template>

<script>
import Layout from '@/layouts/gate.vue';

export default {
  layout: Layout,

  data() {
    return {
      form: {
        email: '',
      },
      success: false,
    };
  },

  methods: {
    async submit() {
      this.success = false;
      this.$page.props.errors = {};

      await this.$inertia.post(this.route('password.email'), { ...this.form });

      if (!this.$page.props.errors.email) {
        this.form = {};
        this.success = true;
      }
    },
  },
};
</script>
