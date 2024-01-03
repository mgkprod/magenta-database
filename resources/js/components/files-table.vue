<template>
  <div class="flex flex-col">
    <div class="flex flex-row px-2 py-2 mb-2 border-b border-gray-lighter dark:border-gray-darker">
      <div class="flex-auto mx-2 text-xs text-left uppercase truncate text-gray-dark dark:text-gray-default">Nom</div>
      <div class="w-20 mx-2 text-xs text-left uppercase fles-none text-gray-dark dark:text-gray-default">Taille</div>
      <div class="hidden w-32 mx-2 text-xs text-left uppercase md:block fles-none text-gray-dark dark:text-gray-default">Ajouté</div>
      <div class="w-32 text-xs text-right uppercase md:mx-2 fles-none text-gray-dark dark:text-gray-default"></div>
    </div>

    <div v-for="file in files" v-bind:key="file.id" class="flex flex-row items-center px-2 py-3 mb-2 transition-all duration-200 ease-in-out rounded hover:bg-gray-lightest dark:hover:bg-gray-darker">
      <div class="flex-auto mx-2 text-left truncate">
        <span v-if="file.custom_properties.name">{{ file.custom_properties.name }}</span>
        <span v-else>{{ file.name }}</span>
      </div>
      <div class="flex-none w-20 mx-2 text-left text-gray-dark dark:text-gray-default">
        {{ get_readable_file_size_string(file.size) }}
      </div>
      <div class="flex-none hidden w-32 mx-2 text-left md:block text-gray-dark dark:text-gray-default">
        {{ moment(file.created_at).format('DD/MM/YYYY') }}
      </div>
      <div class="flex-none w-32 text-right md:mx-2 text-gray-light dark:text-gray-dark">
        <a class="transition-all duration-200 ease-in-out hover:text-gray-dark dark:hover:text-gray-default" :href="file.url" target="_blank">
          <i class="text-xs fas fa-arrow-down"></i>
        </a>
        <inertia-link v-if="$page.props.user" class="ml-2 transition-all duration-200 ease-in-out hover:text-gray-dark dark:hover:text-gray-default" :href="route('files.showConvertForm', file)">
          <i class="text-xs fas fa-sync"></i>
        </inertia-link>
        <button v-if="$page.props.user" class="ml-2 transition-all duration-200 ease-in-out hover:text-gray-dark dark:hover:text-gray-default" @click="destroy(file)">
          <i class="text-xs fas fa-trash"></i>
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
      this.$inertia.delete(this.route('files.destroy', { file }));
    },
    get_readable_file_size_string(file_size_in_bytes) {
      var i = -1;
      var byte_units = [' kB', ' MB', ' GB', ' TB', 'PB', 'EB', 'ZB', 'YB'];
      do {
        file_size_in_bytes = file_size_in_bytes / 1024;
        i++;
      } while (file_size_in_bytes > 1024);

      return Math.max(file_size_in_bytes, 0.1).toFixed(1) + byte_units[i];
    },
  },
};
</script>
