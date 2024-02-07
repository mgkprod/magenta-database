<template>
  <div>
    <inertia-head>
      <title>Tracks » {{ $page.props.filters[$page.props.current_filter].name }}</title>
      <meta head-key="description" name="description" :content="$page.props.filters[$page.props.current_filter].description" />
    </inertia-head>

    <div v-if="$page.props.user" class="flex w-full flex-row justify-end border-b-4 border-gray-lighter bg-white p-4 dark:border-gray-darker dark:bg-black">
      <inertia-link class="mx-1 inline-flex items-center rounded bg-gray-lightest px-4 py-1 text-sm font-semibold text-gray-dark transition duration-200 ease-in-out hover:bg-gray-light focus:outline-none focus:ring-2 focus:ring-gray-500/50 active:bg-transparent dark:bg-gray-darker dark:text-gray-default dark:hover:bg-gray-dark" :href="route('songs.create')"> <i class="fas fa-plus mr-2 opacity-50" /> Add </inertia-link>
    </div>

    <div class="p-4 md:p-8">
      <div class="fade-overflow-x">
        <div class="-mx-2 mb-4 flex flex-row items-start justify-start overflow-x-auto font-semibold" scroll-region>
          <inertia-link
            v-for="(filter, key) in filters"
            :key="key"
            :href="route('songs.browse', { filter: key })"
            class="mx-2 block flex-none"
            preserve-scroll
            :class="{
              'border-b-4 border-pink-700 text-gray-dark dark:text-gray-lighter': route().current('songs.browse', {
                filter: key,
              }),
            }"
          >
            {{ filter.name }}
          </inertia-link>
          <div class="h-1 w-16 flex-none" />
        </div>
      </div>

      <p class="mb-8 text-sm"><i class="fas fa-info-circle mr-2 opacity-50" /> {{ $page.props.filters[$page.props.current_filter].description }}</p>

      <songs-table class="mb-4" :songs="songs.data" />

      <div class="flex items-center justify-center">
        <inertia-link v-if="songs.prev_page_url" preserve-scroll :href="songs.prev_page_url" class="text-gray-dark transition duration-200 ease-in-out hover:text-gray-darker dark:text-gray-default dark:hover:text-gray-lightest">
          <i class="fas fa-angle-left" />
        </inertia-link>
        <div v-else />

        <div class="mx-4 text-xs text-gray-dark dark:text-gray-default">{{ songs.current_page }} / {{ songs.last_page }}</div>

        <inertia-link v-if="songs.next_page_url" preserve-scroll :href="songs.next_page_url" class="text-gray-dark transition duration-200 ease-in-out hover:text-gray-darker dark:text-gray-default dark:hover:text-gray-lightest">
          <i class="fas fa-angle-right" />
        </inertia-link>
        <div v-else />
      </div>
    </div>
  </div>
</template>

<script>
import Layout from '@/layouts/app.vue'

export default {
  layout: Layout,

  props: ['songs', 'filters', 'current_filter'],
}
</script>
