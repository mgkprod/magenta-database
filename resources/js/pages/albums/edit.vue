<template>
  <div class="p-4 md:p-8">
    <form @submit.prevent="submit">
      <form-input v-model="form.name" class="mb-6" label="Name" :errors="$page.props.errors.name" required />

      <form-input v-model="form.artist" class="mb-6" label="Artist" :errors="$page.props.errors.artist" required />

      <form-calendar v-model="form.released_at" class="mb-6" label="Released at" :errors="$page.props.errors.released_at" />

      <form-select v-model="form.availability" class="mb-6" label="Availability" :errors="$page.props.errors.availability" :options="availabilities" />

      <form-select v-model="form.type" class="mb-6" label="Type" :errors="$page.props.errors.type" :options="types" />

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
    album: Object,
    types: Object,
    availabilities: Object,
  },

  data() {
    return {
      form: {
        name: '',
        artist: '',
        released_at: '',
        availability: '',
        type: '',
        details: '',
        image: null,
      },
    }
  },

  created() {
    this.form = { ...this.album }

    this.form.released_at = new Date(this.album.released_at)
  },

  methods: {
    submit() {
      this.$page.props.errors = {}

      var data = new FormData()
      data.append('_method', 'put')
      data.append('name', this.form.name || '')
      data.append('artist', this.form.artist || '')
      data.append('released_at', this.form.released_at.toJSON() || '')
      data.append('availability', this.form.availability || '')
      data.append('type', this.form.type || '')
      data.append('details', this.form.details || '')
      data.append('image', this.form.image || '')

      this.$inertia.post(this.route('albums.update', this.album), data)
    },
  },
}
</script>
