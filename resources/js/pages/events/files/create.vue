<template>
  <div class="p-4 md:p-8">
    <form @submit.prevent="submit">
      <form-input v-model="form.name" class="mb-6" label="Name" :errors="$page.props.errors.name" />

      <form-file-input ref="file" v-model="form.file" class="mb-6" label="File" type="file" accept="file/*" :errors="$page.props.errors.file" />

      <div class="flex justify-end">
        <button class="inline-flex items-center rounded bg-gray-lightest px-4 py-1 text-sm font-semibold text-gray-dark transition duration-200 ease-in-out hover:bg-gray-light focus:outline-none focus:ring-2 focus:ring-gray-500/50 active:bg-transparent dark:bg-gray-darker dark:text-gray-default dark:hover:bg-gray-dark">
          <i class="fas fa-plus mr-2 opacity-50" /> Chunked upload
          <span class="ml-1">({{ upload.progress }} %)</span>
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import Layout from '@/layouts/app.vue'

export default {
  layout: Layout,

  props: ['event', 'handle'],

  data() {
    return {
      form: {
        name: '',
        file: undefined,
      },

      upload: {
        reader: undefined,
        file: undefined,
        slice_size: 50000 * 1024,
        progress: 0,
      },
    }
  },

  methods: {
    submit() {
      this.$page.props.errors = {}
      this.start_upload()
    },

    start_upload() {
      this.upload.reader = new FileReader()
      this.upload.file = this.$refs.file.$el.querySelector('input').files[0]

      if (this.upload.file) this.upload_chunk(0)
    },

    upload_chunk(start) {
      let next_slice = start + (this.upload.slice_size + 1)
      let blob = this.upload.file.slice(start, next_slice)

      this.upload.reader.onloadend = (e) => {
        if (e.target.readyState !== FileReader.DONE) {
          return
        }

        this.axios
          .post(route('files.store.chunk'), {
            handle: this.handle,
            file_data: e.target.result,
          })
          .then(() => {
            let size_done = start + this.upload.slice_size
            this.upload.progress = Math.floor((size_done / this.upload.file.size) * 100)

            if (next_slice < this.upload.file.size) {
              this.upload_chunk(next_slice)
            } else {
              this.complete()
            }
          })
      }

      this.upload.reader.readAsDataURL(blob)
    },

    complete() {
      this.$inertia.post(this.route('events.files.store', this.event), {
        handle: this.handle,
        name: this.form.name,
        file_name: this.upload.file.name,
        file_size: this.upload.file.size,
        file_type: this.upload.file.type,
      })
    },
  },
}
</script>
