<template>
  <div class="p-4 md:p-8">
    <form @submit.prevent="submit">
      <form-input v-model="form.name" class="mb-6" label="Name" :errors="$page.props.errors.name" required />

      <form-calendar v-model="form.happened_at" class="mb-6" label="Happened at" :errors="$page.props.errors.happened_at" />

      <form-textarea v-model="form.details" class="mb-6" label="Details" :errors="$page.props.errors.details" rows="10" />

      <form-file-input v-model="form.image" class="mb-6" label="Image" type="file" accept="image/*" :errors="$page.props.errors.image" />

      <div class="flex justify-end">
        <button class="inline-flex items-center px-4 py-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500"><i class="mr-2 opacity-50 fas fa-plus" /> Add</button>
      </div>
    </form>
  </div>
</template>

<script>
import Layout from '@/layouts/app.vue'

export default {
  layout: Layout,

  data() {
    return {
      form: {
        name: '',
        happened_at: '',
        details: '',
        image: undefined,
      },
    }
  },

  methods: {
    submit() {
      this.$page.props.errors = {}

      var data = new FormData()
      data.append('name', this.form.name || '')
      data.append('happened_at', this.form.happened_at.toJSON() || '')
      data.append('details', this.form.details || '')
      data.append('image', this.form.image || '')

      this.$inertia.post(this.route('events.store'), data)
    },
  },
}
</script>
