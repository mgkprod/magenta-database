<template>
  <div class="p-4 md:p-8">
    <form @submit.prevent="submit">
      <form-input v-model="form.name" class="mb-6" label="Name" :errors="$page.props.errors.name" required />

      <form-calendar v-model="form.happened_at" class="mb-6" label="Happened at" :errors="$page.props.errors.happened_at" />

      <form-textarea v-model="form.details" class="mb-6" label="Details" :errors="$page.props.errors.details" rows="10" />

      <form-file-input v-model="form.image" class="mb-6" label="Image" type="file" accept="image/*" :errors="$page.props.errors.image" />

      <div class="flex justify-end">
        <button class="inline-flex items-center rounded bg-gray-lightest px-4 py-1 text-sm font-semibold text-gray-dark transition duration-200 ease-in-out hover:bg-gray-light focus:outline-none focus:ring-2 focus:ring-gray-500/50 active:bg-transparent dark:bg-gray-darker dark:text-gray-default dark:hover:bg-gray-dark"><i class="fas fa-edit mr-2 opacity-50" /> Edit</button>
      </div>
    </form>
  </div>
</template>

<script>
import Layout from '@/layouts/app.vue'

export default {
  layout: Layout,

  props: {
    event: Object,
  },

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

  mounted() {
    this.form = { ...this.event }

    this.form.happened_at = new Date(this.event.happened_at)
  },

  methods: {
    submit() {
      this.$page.props.errors = {}

      var data = new FormData()
      data.append('_method', 'put')
      data.append('name', this.form.name || '')
      data.append('happened_at', this.form.happened_at.toJSON() || '')
      data.append('details', this.form.details || '')
      data.append('image', this.form.image || '')

      this.$inertia.post(this.route('events.update', this.event), data)
    },
  },
}
</script>
