<template>
  <div>
    <inertia-head>
      <title>{{ $page.props.album.artist }} » {{ $page.props.album.name }} ({{ $page.props.album.type }})</title>
      <!-- <meta head-key="description" name="description" content="" /> -->
      <meta head-key="og:image" property="og:image" :content="$page.props.album.image_url" />
      <meta head-key="twitter:image" name="twitter:image" :content="$page.props.album.image_url" />
    </inertia-head>

    <div v-if="$page.props.user" class="flex w-full flex-row justify-end border-b-4 border-gray-lighter bg-white p-4 dark:border-gray-darker dark:bg-black">
      <inertia-link class="mx-1 inline-flex items-center rounded bg-gray-lightest px-4 py-1 text-sm font-semibold text-gray-dark transition duration-200 ease-in-out hover:bg-gray-light focus:outline-none focus:ring-2 focus:ring-gray-500/50 active:bg-transparent dark:bg-gray-darker dark:text-gray-default dark:hover:bg-gray-dark" :href="route('albums.files.create', album)"> <i class="fas fa-folder-open mr-2 opacity-50" /> Add file </inertia-link>
      <inertia-link class="mx-1 inline-flex items-center rounded bg-gray-lightest px-4 py-1 text-sm font-semibold text-gray-dark transition duration-200 ease-in-out hover:bg-gray-light focus:outline-none focus:ring-2 focus:ring-gray-500/50 active:bg-transparent dark:bg-gray-darker dark:text-gray-default dark:hover:bg-gray-dark" :href="route('albums.edit', album)"> <i class="fas fa-edit mr-2 opacity-50" /> Edit </inertia-link>
      <button class="mx-1 inline-flex items-center rounded bg-gray-lightest px-4 py-1 text-sm font-semibold text-gray-dark transition duration-200 ease-in-out hover:bg-gray-light focus:outline-none focus:ring-2 focus:ring-gray-500/50 active:bg-transparent dark:bg-gray-darker dark:text-gray-default dark:hover:bg-gray-dark" @click="destroy()"><i class="fas fa-trash mr-2 opacity-50" /> Delete</button>
      <a class="mx-1 inline-flex items-center rounded bg-gray-lightest px-4 py-1 text-sm font-semibold text-gray-dark transition duration-200 ease-in-out hover:bg-gray-light focus:outline-none focus:ring-2 focus:ring-gray-500/50 active:bg-transparent dark:bg-gray-darker dark:text-gray-default dark:hover:bg-gray-dark" :href="route('albums.export', album)" target="_blank"><i class="fas fa-download mr-2 opacity-50" /> Export</a>
    </div>

    <div class="relative flex flex-col items-start justify-start border-b-4 border-gray-lighter p-8 sm:flex-row dark:border-gray-darker">
      <div class="bg-cover-container">
        <div class="bg-gradient-to-br from-white to-white bg-cover dark:from-black dark:to-black" :style="{ '--tw-gradient-from': album.image_dominant_color }" />
      </div>

      <div class="mb-8 w-64 flex-none sm:mb-0 sm:mr-8 sm:w-48 lg:w-64">
        <vue-load-image class="aspect-h-1 aspect-w-1 shadow-xl">
          <template #image>
            <img :src="album.image_url" class="animate__animated animate__fadeIn animate__fastest size-full object-cover" />
          </template>
          <template #preloader>
            <div class="flex items-center justify-center opacity-50" :style="{ 'background-color': album.image_dominant_color }">
              <i class="fas fa-spin fa-spinner text-black dark:text-white" />
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

        <div v-if="album.details" class="mt-4 w-full whitespace-pre-wrap" v-html="markdownit.render(album.details)" />

        <div class="mt-8">
          <div class="inline-flex cursor-pointer items-center rounded bg-white/50 px-4 py-2 font-semibold text-gray-dark transition duration-200 ease-in-out hover:bg-white/70 focus:outline-none focus:ring-2 focus:ring-gray-500/50 active:bg-transparent dark:bg-black/50 dark:text-gray-default dark:hover:bg-black/70" @click="play()">
            <i class="fas fa-play mr-2 text-xs opacity-50" />
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
