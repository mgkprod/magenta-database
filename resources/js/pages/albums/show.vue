<template>
  <div>
    <inertia-head>
      <title>{{ $page.props.album.name }}</title>
      <!-- <meta head-key="description" name="description" content="" /> -->
      <meta head-key="og:image" property="og:image" :content="$page.props.album.image_url" />
      <meta head-key="twitter:image" name="twitter:image" :content="$page.props.album.image_url" />
    </inertia-head>

    <div class="flex flex-row justify-end w-full px-4 py-4 bg-white border-b-4 dark:bg-black border-gray-lighter dark:border-gray-darker" v-if="$page.props.user">
      <inertia-link class="inline-flex items-center px-4 py-1 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500" :href="route('albums.files.create', album)"> <i class="mr-2 opacity-50 fas fa-folder-open"></i> Add file </inertia-link>
      <inertia-link class="inline-flex items-center px-4 py-1 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500" :href="route('albums.edit', album)"> <i class="mr-2 opacity-50 fas fa-edit"></i> Edit </inertia-link>
      <button class="inline-flex items-center px-4 py-1 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500" @click="destroy()"><i class="mr-2 opacity-50 fas fa-trash"></i> Delete</button>
    </div>

    <div class="relative flex flex-col items-start justify-start p-8 border-b-4 sm:flex-row border-gray-lighter dark:border-gray-darker">
      <div class="bg-cover-container">
        <div class="bg-cover bg-gradient-to-br from-white to-white dark:from-black dark:to-black" :style="{ '--tw-gradient-from': album.image_dominant_color }"></div>
      </div>

      <div class="flex-none w-64 mb-8 sm:w-48 lg:w-64 sm:mb-0 sm:mr-8">
        <vue-load-image class="shadow-xl aspect-w-1 aspect-h-1">
          <img slot="image" :src="album.image_url" class="object-cover w-full h-full animate__animated animate__fadeIn animate__fastest" />
          <div class="flex items-center justify-center opacity-50" :style="{ 'background-color': album.image_dominant_color }" slot="preloader">
            <i class="text-black dark:text-white fas fa-spin fa-spinner"></i>
          </div>
        </vue-load-image>
      </div>

      <div>
        <div class="mb-2 text-xs uppercase text-gray-dark dark:text-gray-default">{{ album.type }}</div>
        <h1 class="mb-4 text-4xl font-semibold">
          {{ album.name }}
          <div class="text-xl">{{ album.artist }}</div>
        </h1>
        <div class="text-gray-dark dark:text-gray-default">
          Disponibilité :
          <span v-if="album.availability == 'published'">Publié</span>
          <span v-if="album.availability == 'unreleased'">Inédit</span>
          <span v-if="album.availability == 'deleted'">Supprimé</span>
        </div>
        <div class="text-gray-dark dark:text-gray-default">
          Année de sortie :
          <span v-if="album.released_at">{{ moment(album.released_at).format('YYYY') }}</span>
          <span v-else>N/A</span>
        </div>
        <div class="text-gray-dark dark:text-gray-default">Ajouté le : {{ moment(album.created_at).format('L') }}</div>

        <div class="w-full mt-4 whitespace-pre-wrap" v-if="album.details">
          <vue-simple-markdown :source="album.details"></vue-simple-markdown>
        </div>

        <div class="mt-8">
          <div class="inline-flex items-center px-4 py-2 font-semibold transition duration-200 ease-in-out bg-white bg-opacity-50 rounded cursor-pointer dark:bg-black text-gray-dark dark:text-gray-default active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500 hover:bg-opacity-70" @click="play()">
            <i class="mr-2 text-xs opacity-50 fas fa-play"></i>
            <span>Écouter</span>
          </div>
        </div>
      </div>
    </div>

    <div class="w-full p-4 pb-0 md:p-8">
      <songs-table class="mb-8" :songs="album.songs"></songs-table>

      <template v-if="files && files.length">
        <h2 class="mb-4 text-xl font-semibold">Fichiers</h2>
        <files-table class="mb-8" :files="files"></files-table>
      </template>
    </div>
  </div>
</template>

<script>
import { EventBus } from '../../event-bus.js';

export default {
  layout: require('../../layouts/app').default,

  props: ['album', 'files'],

  methods: {
    destroy() {
      this.$inertia.delete(this.route('albums.destroy', this.album));
    },
    play() {
      EventBus.$emit('play:album', {
        album: this.album,
      });
    },
  },
};
</script>
