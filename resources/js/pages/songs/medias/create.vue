<template>
  <div class="p-4 md:p-8">
    <form @submit.prevent="submit">
      <form-input class="mb-6" label="Source" v-model="form.source" :errors="$page.props.errors.source" />

      <form-file-input class="mb-6" label="Audio" type="file" v-model="form.audio" accept="audio/*" :errors="$page.props.errors.audio" />

      <div class="flex justify-end">
        <button class="inline-flex items-center px-4 py-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500"><i class="mr-2 opacity-50 fas fa-plus"></i> Upload</button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  layout: require('../../../layouts/app').default,

  props: {
    song: Object,
  },

  data() {
    return {
      form: {
        source: '',
        audio: undefined,
      },
    };
  },

  methods: {
    submit() {
      this.$page.props.errors = {};

      var data = new FormData();
      data.append('source', this.form.source || '');
      data.append('audio', this.form.audio || '');

      this.$inertia.post(this.route('songs.medias.store', this.song), data);
    },
  },
};
</script>
