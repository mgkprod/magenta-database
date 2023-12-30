<template>
  <div class="p-4 md:p-8">
    <form @submit.prevent="submit">
      <form-input class="mb-6" label="Name" v-model="form.name" :errors="$page.props.errors.name" required />

      <form-input class="mb-6" label="Artist" v-model="form.artist" :errors="$page.props.errors.artist" required />

      <form-input class="mb-6" label="Released at" v-model="form.released_at" :errors="$page.props.errors.released_at" />

      <form-select class="mb-6" label="Availability" v-model="form.availability" :errors="$page.props.errors.availability" :options="availabilities" />

      <form-select class="mb-6" label="Type" v-model="form.type" :errors="$page.props.errors.type" :options="types" />

      <form-textarea class="mb-6" label="Details" v-model="form.details" :errors="$page.props.errors.details" rows="10" />

      <form-file-input class="mb-6" label="Image" type="file" v-model="form.image" accept="image/*" :errors="$page.props.errors.image" />

      <div class="flex justify-end">
        <button class="inline-flex items-center px-4 py-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500"><i class="mr-2 opacity-50 fas fa-plus"></i> Add</button>
      </div>
    </form>
  </div>
</template>

<script>
import Layout from '@/layouts/app.vue';

export default {
  layout: Layout,

  props: {
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
        image: undefined,
      },
    };
  },

  methods: {
    submit() {
      this.$page.props.errors = {};

      var data = new FormData();
      data.append('name', this.form.name || '');
      data.append('artist', this.form.artist || '');
      data.append('released_at', this.form.released_at || '');
      data.append('availability', this.form.availability || '');
      data.append('type', this.form.type || '');
      data.append('details', this.form.details || '');
      data.append('image', this.form.image || '');

      this.$inertia.post(this.route('albums.store'), data);
    },
  },
};
</script>
