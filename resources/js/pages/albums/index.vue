<template>
  <div>
    <inertia-head>
      <title>Albums</title>
      <meta head-key="description" name="description" content="Tous les tracks regroupés par albums" />
    </inertia-head>

    <div class="flex flex-row justify-end w-full px-4 py-4 bg-white border-b-4 dark:bg-black border-gray-lighter dark:border-gray-darker" v-if="$page.props.user">
      <inertia-link class="inline-flex items-center px-4 py-1 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500" :href="route('albums.create')"> <i class="mr-2 opacity-50 fas fa-plus"></i> Add </inertia-link>
    </div>

    <div class="p-4 md:p-8">
      <div v-for="(albums, artist) in grouped_albums" v-bind:key="artist" class="mb-8">
        <h2 class="mb-4 text-xl font-semibold">{{ artist }}</h2>
        <albums-grid class="mb-8" :albums="albums"></albums-grid>
      </div>
    </div>
  </div>
</template>

<script>
import Layout from '@/layouts/app.vue';

export default {
  layout: Layout,

  props: ['grouped_albums'],
};
</script>
