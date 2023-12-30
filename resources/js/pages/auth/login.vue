<template>
  <form class="flex flex-col overflow-hidden bg-white dark:bg-black" @submit.prevent="submit">
    <div class="flex-grow w-full p-8">
      <form-input class="mb-6" label="Email" v-model="form.email" :errors="$page.props.errors.email" required autofocus autocomplete="email" />

      <form-input class="mb-2" label="Password" type="password" v-model="form.password" :errors="$page.props.errors.password" required autocomplete="current-password" />

      <div class="mb-8"></div>

      <button class="w-full py-3 text-sm font-semibold text-black transition duration-200 ease-in-out rounded dark:text-white bg-primary-500 active:bg-transparent focus:ring-2 focus:ring-opacity-50 focus:ring-primary-500 hover:bg-primary-600 focus:outline-none focus:shadow-outline">Sign in</button>
    </div>
  </form>
</template>

<script>
import Layout from '@/layouts/app.vue';

export default {
  layout: Layout,

  data() {
    return {
      form: {
        email: '',
        password: '',
        remember: false,
      },
    };
  },

  methods: {
    submit() {
      this.$page.props.errors = {};

      this.$inertia.post(this.route('login'), { ...this.form });

      this.form.password = '';
    },
  },
};
</script>
