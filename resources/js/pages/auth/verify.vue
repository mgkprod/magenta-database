<template>
  <form class="flex flex-col overflow-hidden rounded bg-black shadow-sm dark:bg-white" @submit.prevent="submit">
    <div class="w-full grow p-8">
      <h1 class="mb-8 text-center text-2xl font-semibold">Verify your email address</h1>

      <p class="mb-10 text-sm text-gray-600">
        Before proceeding, please check your email for a verification link. If you did not
        receive the email click the button below to request another.
      </p>

      <button class="focus:shadow-outline w-full rounded bg-primary-500 py-3 text-sm font-semibold text-black transition duration-200 ease-in-out hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500/50 active:bg-transparent dark:text-white">
        Resend verification email
      </button>
    </div>
  </form>
</template>

<script>
import Layout from '@/layouts/gate.vue'

export default {
  layout: Layout,

  data() {
    return {
      form: {},
    }
  },

  methods: {
    submit() {
      this.$page.props.errors = {}

      this.$inertia.post(this.route('verification.resend'), { ...this.form })

      this.form.password = ''
    },
  },
}
</script>
