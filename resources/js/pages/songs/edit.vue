<template>
  <div class="p-4 md:p-8">
    <form @submit.prevent="submit">
      <form-input v-model="form.title" class="mb-6" label="Title" :errors="$page.props.errors.title" />
      <form-input v-model="form.alt_title" class="mb-6" label="Alternative title" :errors="$page.props.errors.alt_title" />
      <form-input v-model="form.artist" class="mb-6" label="Artist" :errors="$page.props.errors.artist" />
      <form-select v-model="form.type" class="mb-6" label="Type" :errors="$page.props.errors.type" :options="types" />
      <form-select v-model="form.availability" class="mb-6" label="Availability" :errors="$page.props.errors.availability" :options="availabilities" />
      <form-calendar v-model="form.released_at" class="mb-6" label="Released at" :errors="$page.props.errors.released_at" />
      <form-calendar v-model="form.first_time_played_at" class="mb-6" label="First time played at" :errors="$page.props.errors.first_time_played_at" />
      <form-input v-model="form.variant_agg" class="mb-6" label="Variant aggregate" :errors="$page.props.errors.variant_agg" />
      <form-textarea v-model="form.details" class="mb-6" label="Details" :errors="$page.props.errors.details" rows="10" />
      <form-file-input v-model="form.image" class="mb-6" label="Image" type="file" accept="image/*" :errors="$page.props.errors.image" />
      <form-checkbox v-model="form.is_downloadable" class="mb-4" label="Downloadable?" name="is_downloadable" :errors="$page.props.errors.is_downloadable" />

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
    song: Object,
    availabilities: Object,
    types: Object,
  },

  data() {
    return {
      form: {
        title: '',
        alt_title: '',
        artist: '',
        type: '',
        availability: '',
        released_at: '',
        first_time_played_at: '',
        variant_agg: '',
        details: '',
        image: undefined,
        is_downloadable: false,
      },
    }
  },

  created() {
    this.form = { ...this.song }

    this.form.released_at = new Date(this.song.released_at)
    this.form.first_time_played_at = new Date(this.song.first_time_played_at)
  },

  methods: {
    submit() {
      this.$page.props.errors = {}

      var data = new FormData()
      data.append('_method', 'put')
      data.append('title', this.form.title || '')
      data.append('alt_title', this.form.alt_title || '')
      data.append('artist', this.form.artist || '')
      data.append('type', this.form.type || '')
      data.append('availability', this.form.availability || '')
      data.append('released_at', this.form.released_at.toJSON() || '')
      data.append('first_time_played_at', this.form.first_time_played_at.toJSON() || '')
      data.append('variant_agg', this.form.variant_agg || '')
      data.append('details', this.form.details || '')
      data.append('image', this.form.image || '')
      data.append('is_downloadable', this.form.is_downloadable || false)

      this.$inertia.post(this.route('songs.update', this.song), data)
    },
  },
}
</script>
