<template>
  <div>
    <inertia-head>
      <title>Albums</title>
      <meta head-key="description" name="description" content="Tous les tracks regroupés par albums" />
    </inertia-head>

    <div v-if="$page.props.user" class="flex w-full flex-row justify-end border-b-4 border-gray-lighter bg-white p-4 dark:border-gray-darker dark:bg-black">
      <inertia-link class="mx-1 inline-flex items-center rounded bg-gray-lightest px-4 py-1 text-sm font-semibold text-gray-dark transition duration-200 ease-in-out hover:bg-gray-light focus:outline-none focus:ring-2 focus:ring-gray-500/50 active:bg-transparent dark:bg-gray-darker dark:text-gray-default dark:hover:bg-gray-dark" :href="route('albums.create')"> <i class="fas fa-plus mr-2 opacity-50" /> Add </inertia-link>
    </div>

    <div class="p-4 md:p-8">
      <div v-for="(albums, artist) in grouped_albums" :key="artist" class="mb-8">
        <h2 class="mb-4 text-xl font-semibold">{{ artist }}</h2>
        <albums-grid class="mb-8" :albums="albums" />
      </div>
    </div>
  </div>
</template>

<script>
import Layout from '@/layouts/app.vue'

export default {
  layout: Layout,

  props: ['grouped_albums'],
}
</script>
