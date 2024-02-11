<template>
  <div class="p-4 md:p-8">
    <form @submit.prevent="submit">
      <form-select
        v-model="form.preset"
        class="mb-6"
        label="Conversion preset"
        :errors="$page.props.errors.preset"
        :options="[
          { id: 'mp3-320kbps', name: 'Extact audio track (mp3, 320kbps)' },
          { id: 'mp3-256kbps', name: 'Extact audio track (mp3, 256kbps)' },
          { id: 'mp3-192kbps', name: 'Extact audio track (mp3, 192kbps)' },
        ]"
        option-label="name"
        option-value="id"
      />

      <div class="flex justify-end">
        <button class="inline-flex items-center rounded bg-gray-lightest px-4 py-1 text-sm font-semibold text-gray-dark transition duration-200 ease-in-out hover:bg-gray-light focus:outline-none focus:ring-2 focus:ring-gray-500/50 active:bg-transparent dark:bg-gray-darker dark:text-gray-default dark:hover:bg-gray-dark">Start conversion</button>
      </div>
    </form>
  </div>
</template>

<script>
import Layout from '@/layouts/app.vue'
import formSelect from '../../components/form-select.vue'

export default {
  components: { formSelect },
  layout: Layout,

  props: ['file'],

  data() {
    return {
      form: {
        preset: '',
      },
    }
  },

  methods: {
    submit() {
      this.$page.props.errors = {}

      this.$inertia.post(this.route('files.convert', this.file), this.form)
    },
  },
}
</script>
