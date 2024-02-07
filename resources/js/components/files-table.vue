<template>
  <div class="flex flex-col">
    <div class="mb-2 flex flex-row border-b border-gray-lighter p-2 dark:border-gray-darker">
      <div class="mx-2 flex-auto truncate text-left text-xs uppercase text-gray-dark dark:text-gray-default">Nom</div>
      <div class="fles-none mx-2 w-20 text-left text-xs uppercase text-gray-dark dark:text-gray-default">Taille</div>
      <div class="fles-none mx-2 hidden w-32 text-left text-xs uppercase text-gray-dark md:block dark:text-gray-default">Ajouté</div>
      <div class="fles-none w-32 text-right text-xs uppercase text-gray-dark md:mx-2 dark:text-gray-default" />
    </div>

    <div v-for="file in files" :key="file.id" class="mb-2 flex flex-row items-center rounded px-2 py-3 transition-all duration-200 ease-in-out hover:bg-gray-lightest dark:hover:bg-gray-darker">
      <div class="mx-2 flex-auto truncate text-left">
        <span v-if="file.custom_properties.name">{{ file.custom_properties.name }}</span>
        <span v-else>{{ file.name }}</span>
      </div>
      <div class="mx-2 w-20 flex-none text-left text-gray-dark dark:text-gray-default">
        {{ get_readable_file_size_string(file.size) }}
      </div>
      <div class="mx-2 hidden w-32 flex-none text-left text-gray-dark md:block dark:text-gray-default">
        {{ moment(file.created_at).format('DD/MM/YYYY') }}
      </div>
      <div class="w-32 flex-none text-right text-gray-light md:mx-2 dark:text-gray-dark">
        <a class="transition-all duration-200 ease-in-out hover:text-gray-dark dark:hover:text-gray-default" :href="file.url" target="_blank">
          <i class="fas fa-arrow-down text-xs" />
        </a>
        <inertia-link v-if="$page.props.user" class="ml-2 transition-all duration-200 ease-in-out hover:text-gray-dark dark:hover:text-gray-default" :href="route('files.showConvertForm', file)">
          <i class="fas fa-sync text-xs" />
        </inertia-link>
        <button v-if="$page.props.user" class="ml-2 transition-all duration-200 ease-in-out hover:text-gray-dark dark:hover:text-gray-default" @click="destroy(file)">
          <i class="fas fa-trash text-xs" />
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['files'],

  methods: {
    destroy(file) {
      this.$inertia.delete(this.route('files.destroy', { file }))
    },

    get_readable_file_size_string(file_size_in_bytes) {
      var i = -1
      var byte_units = [' kB', ' MB', ' GB', ' TB', 'PB', 'EB', 'ZB', 'YB']
      do {
        file_size_in_bytes = file_size_in_bytes / 1024
        i++
      } while (file_size_in_bytes > 1024)

      return Math.max(file_size_in_bytes, 0.1).toFixed(1) + byte_units[i]
    },
  },
}
</script>
