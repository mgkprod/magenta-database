<template>
  <div>
    <inertia-head>
      <title>{{ $page.props.album.artist }} » {{ $page.props.album.name }} ({{ $page.props.album.type }})</title>
      <!-- <meta head-key="description" name="description" content="" /> -->
      <meta head-key="og:image" property="og:image" :content="$page.props.album.image_url" />
      <meta head-key="twitter:image" name="twitter:image" :content="$page.props.album.image_url" />
    </inertia-head>

    <div v-if="$page.props.user" class="flex flex-row justify-end w-full px-4 py-4 bg-white border-b-4 dark:bg-black border-gray-lighter dark:border-gray-darker">
      <inertia-link class="inline-flex items-center px-4 py-1 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500" :href="route('albums.files.create', album)"> <i class="mr-2 opacity-50 fas fa-folder-open" /> Add file </inertia-link>
      <inertia-link class="inline-flex items-center px-4 py-1 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500" :href="route('albums.edit', album)"> <i class="mr-2 opacity-50 fas fa-edit" /> Edit </inertia-link>
      <button class="inline-flex items-center px-4 py-1 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500" @click="destroy()"><i class="mr-2 opacity-50 fas fa-trash" /> Delete</button>
    </div>

    <div class="relative flex flex-col items-start justify-start p-8 border-b-4 sm:flex-row border-gray-lighter dark:border-gray-darker">
      <div class="bg-cover-container">
        <div class="bg-cover bg-gradient-to-br from-white to-white dark:from-black dark:to-black" :style="{ '--tw-gradient-from': album.image_dominant_color }" />
      </div>

      <div class="flex-none w-64 mb-8 sm:w-48 lg:w-64 sm:mb-0 sm:mr-8">
        <vue-load-image class="shadow-xl aspect-w-1 aspect-h-1">
          <template #image>
            <img :src="album.image_url" class="object-cover w-full h-full animate__animated animate__fadeIn animate__fastest" />
          </template>
          <template #preloader>
            <div class="flex items-center justify-center opacity-50" :style="{ 'background-color': album.image_dominant_color }">
              <i class="text-black dark:text-white fas fa-spin fa-spinner" />
            </div>
          </template>
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
        <div class="text-gray-dark dark:text-gray-default">Ajouté le : {{ moment(album.created_at).format('DD/MM/YYYY') }}</div>

        <div v-if="album.details" class="w-full mt-4 whitespace-pre-wrap" v-html="markdownit.render(album.details)" />

        <div class="mt-8">
          <div class="inline-flex items-center px-4 py-2 font-semibold transition duration-200 ease-in-out bg-white bg-opacity-50 rounded cursor-pointer dark:bg-black text-gray-dark dark:text-gray-default active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500 hover:bg-opacity-70" @click="play()">
            <i class="mr-2 text-xs opacity-50 fas fa-play" />
            <span>Écouter</span>
          </div>
        </div>
      </div>
    </div>

    <div class="w-full p-4 pb-0 md:p-8">
      <songs-table class="mb-8" :songs="album.songs" />

      <template v-if="files && files.length">
        <h2 class="mb-4 text-xl font-semibold">Fichiers</h2>
        <files-table class="mb-8" :files="files" />
      </template>
    </div>
  </div>
</template>

<script>
import Layout from '@/layouts/app.vue'
import { EventBus } from '../../event-bus.js'

export default {
  layout: Layout,

  props: ['album', 'files'],

  methods: {
    destroy() {
      this.$inertia.delete(this.route('albums.destroy', this.album))
    },

    play() {
      EventBus.$emit('play:album', {
        album: this.album,
      })
    },
  },
}
</script>
