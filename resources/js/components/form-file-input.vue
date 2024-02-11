<template>
  <label class="mb-6 block md:w-96">
    <span v-if="label" class="mb-2 block text-sm font-semibold text-gray-dark dark:text-gray-default" v-text="label" />

    <div :class="{ error: errors.length }">
      <input ref="file" type="file" :accept="accept" class="hidden" @change="change" />
      <div v-if="!modelValue">
        <button type="button" class="inline-flex items-center rounded bg-gray-lightest px-4 py-1 text-sm font-semibold text-gray-dark transition duration-200 ease-in-out hover:bg-gray-light focus:outline-none focus:ring-2 focus:ring-gray-500/50 active:bg-transparent dark:bg-gray-darker dark:text-gray-default dark:hover:bg-gray-dark" @click="browse"><i class="fas fa-file mr-2 opacity-50" /> Browse</button>
      </div>
      <div v-else class="flex items-center justify-between">
        <div class="flex-none truncate">
          <div class="truncate">{{ modelValue.name }} ({{ get_readable_file_size_string(modelValue.size) }})</div>
        </div>
        <button type="button" class="inline-flex items-center rounded bg-gray-lightest px-4 py-1 text-sm font-semibold text-gray-dark transition duration-200 ease-in-out hover:bg-gray-light focus:outline-none focus:ring-2 focus:ring-gray-500/50 active:bg-transparent dark:bg-gray-darker dark:text-gray-default dark:hover:bg-gray-dark" @click.stop="remove">Remove</button>
      </div>
    </div>

    <p v-if="errors.length" class="pl-1 text-xs font-semibold text-red-500" v-text="errors[0]" />
  </label>
</template>

<script>
export default {
  inheritAttrs: false,

  props: {
    modelValue: {},
    label: String,
    accept: String,
    errors: {
      type: Array,
      default: () => [],
    },
  },

  emits: ['update:modelValue'],

  watch: {
    modelValue(modelValue) {
      if (!modelValue) {
        this.$refs.file.modelValue = ''
      }
    },
  },

  methods: {
    get_readable_file_size_string(file_size_in_bytes) {
      var i = -1
      var byte_units = [' kB', ' MB', ' GB', ' TB', 'PB', 'EB', 'ZB', 'YB']
      do {
        file_size_in_bytes = file_size_in_bytes / 1024
        i++
      } while (file_size_in_bytes > 1024)

      return Math.max(file_size_in_bytes, 0.1).toFixed(1) + byte_units[i]
    },

    browse() {
      this.$refs.file.click()
    },

    change(e) {
      this.$emit('update:modelValue', e.target.files[0])
    },

    remove() {
      this.$emit('update:modelValue', null)
    },
  },
}
</script>
