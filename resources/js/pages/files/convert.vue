<template>
  <div class="p-4 md:p-8">
    <form @submit.prevent="submit">
      <form-select
        class="mb-6"
        label="Conversion preset"
        v-model="form.preset"
        :errors="$page.props.errors.preset"
        :options="{
          'mp3-320kbps': 'Extact audio track (mp3, 320kbps)',
          'mp3-256kbps': 'Extact audio track (mp3, 256kbps)',
          'mp3-192kbps': 'Extact audio track (mp3, 192kbps)',
        }"
      />

      <div class="flex justify-end">
        <button class="inline-flex items-center px-4 py-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500">Start conversion</button>
      </div>
    </form>
  </div>
</template>

<script>
import formSelect from '../../components/form-select.vue';
export default {
  components: { formSelect },
  layout: require('../../layouts/app').default,

  props: ['file'],

  data() {
    return {
      form: {
        preset: '',
      },
    };
  },

  methods: {
    submit() {
      this.$page.props.errors = {};

      this.$inertia.post(this.route('files.convert', this.file), this.form);
    },
  },
};
</script>
