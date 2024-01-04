<template>
  <div>
    <inertia-head>
      <title>{{ $page.props.song.artist }} » {{ $page.props.song.display_title }}</title>
      <!-- <meta head-key="description" name="description" content="" /> -->
      <meta head-key="og:image" property="og:image" :content="$page.props.song.image_url" />
      <meta head-key="twitter:image" name="twitter:image" :content="$page.props.song.image_url" />
    </inertia-head>

    <div v-if="$page.props.user" class="flex flex-row justify-end w-full px-4 py-4 bg-white border-b-4 dark:bg-black border-gray-lighter dark:border-gray-darker">
      <inertia-link class="inline-flex items-center px-4 py-1 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500" :href="route('songs.edit', song)"> <i class="mr-2 opacity-50 fas fa-edit" /> Edit </inertia-link>
      <inertia-link class="inline-flex items-center px-4 py-1 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500" :href="route('songs.edit-relations', song)"> <i class="mr-2 opacity-50 fas fa-link" /> Relations </inertia-link>
      <inertia-link class="inline-flex items-center px-4 py-1 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500" :href="route('songs.files.create', song)"> <i class="mr-2 opacity-50 fas fa-folder-open" /> Add file </inertia-link>
      <inertia-link class="inline-flex items-center px-4 py-1 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500" :href="route('songs.medias.create', song)"> <i class="mr-2 opacity-50 fas fa-compact-disc" /> Add media </inertia-link>
      <button class="inline-flex items-center px-4 py-1 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500" @click="destroy()"><i class="mr-2 opacity-50 fas fa-trash" /> Delete</button>
    </div>

    <div class="relative flex flex-col items-start justify-start p-8 border-b-4 sm:flex-row border-gray-lighter dark:border-gray-darker">
      <div class="bg-cover-container">
        <div class="bg-cover bg-gradient-to-br from-white to-white dark:from-black dark:to-black" :style="{ '--tw-gradient-from': song.image_dominant_color }" />
      </div>

      <div class="flex-none w-64 mb-8 sm:w-48 lg:w-64 sm:mb-0 sm:mr-8">
        <vue-load-image class="shadow-xl aspect-w-1 aspect-h-1">
          <template #image>
            <img :src="song.image_url" class="object-cover w-full h-full animate__animated animate__fadeIn animate__fastest" />
          </template>
          <template #preloader>
            <div class="flex items-center justify-center opacity-50" :style="{ 'background-color': song.image_dominant_color }">
              <i class="text-black dark:text-white fas fa-spin fa-spinner" />
            </div>
          </template>
        </vue-load-image>
      </div>

      <div>
        <div class="mb-2 text-xs uppercase text-gray-dark dark:text-gray-default">Track</div>
        <h1 class="mb-4 text-4xl font-semibold">
          {{ song.title }}
          <div class="text-xl">{{ song.artist }}</div>
        </h1>
        <div v-if="song.alt_title" class="text-gray-dark dark:text-gray-default">Titre alternatif : {{ song.alt_title }}</div>
        <div class="text-gray-dark dark:text-gray-default">
          Version :
          <span v-if="song.type == 'original'">Originale</span>
          <span v-if="song.type == 'clip'">Clip</span>
          <span v-if="song.type == 'remix'">Remix</span>
          <span v-if="song.type == 'extended-mix'">Extended Mix</span>
          <span v-if="song.type == 'live-rework'">Live Rework</span>
          <span v-if="song.type == 'live'">Live</span>
          <span v-if="song.type == 'radio-edit'">Radio Edit</span>
          <span v-if="song.type == 'rework'">Rework</span>
        </div>
        <div class="text-gray-dark dark:text-gray-default">
          Disponibilité :
          <span v-if="song.availability == 'unreleased'">Inédit</span>
          <span v-if="song.availability == 'deleted'">Supprimé</span>
          <span v-if="song.availability == 'published'">Publié</span>
        </div>
        <div v-if="song.first_time_played_at" class="text-gray-dark dark:text-gray-default">Première diffusion le : {{ moment(song.first_time_played_at).format('DD/MM/YYYY') }}</div>
        <div v-if="song.released_at" class="text-gray-dark dark:text-gray-default">
          Année de sortie :
          <span v-if="song.released_at">{{ moment(song.released_at).format('YYYY') }}</span>
          <span v-else>N/A</span>
        </div>
        <div class="text-gray-dark dark:text-gray-default">Ajouté le : {{ moment(song.created_at).format('DD/MM/YYYY') }}</div>

        <div v-if="song.details" class="w-full mt-4 whitespace-pre-wrap" v-html="markdownit.render(song.details)" />

        <div v-if="medias.length" class="mt-8">
          <div class="inline-flex items-center px-4 py-2 font-semibold transition duration-200 ease-in-out bg-white bg-opacity-50 rounded cursor-pointer dark:bg-black text-gray-dark dark:text-gray-default active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500 hover:bg-opacity-70" @click="play()">
            <i class="mr-2 text-xs opacity-50 fas fa-play" />
            <span>Écouter</span>
          </div>
        </div>
      </div>
    </div>

    <div class="w-full p-4 pb-0 md:p-8">
      <div v-if="medias.length" class="flex flex-col mb-8">
        <div class="flex flex-row px-2 py-2 mb-2 border-b border-gray-lighter dark:border-gray-darker">
          <div class="flex-none w-8 text-xs text-center uppercase md:mx-2 text-gray-dark dark:text-gray-default" />
          <div class="flex-auto mx-2 text-xs text-left uppercase truncate text-gray-dark dark:text-gray-default">Info</div>
          <div class="flex-none hidden w-24 mx-2 text-xs text-left uppercase sm:block lg:w-36 text-gray-dark dark:text-gray-default">Source</div>
          <div class="flex-none w-16 mx-2 text-xs text-left uppercase text-gray-dark dark:text-gray-default">Durée</div>
          <div class="flex-none hidden w-20 mx-2 text-xs text-left uppercase sm:block text-gray-dark dark:text-gray-default">Taille</div>
          <div class="flex-none hidden w-32 mx-2 text-xs text-left uppercase lg:block text-gray-dark dark:text-gray-default">Ajouté</div>
          <div class="flex-none w-32 text-xs text-right uppercase md:mx-2 text-gray-dark dark:text-gray-default" />
        </div>

        <div v-for="media in medias" :key="media.id" class="flex flex-row items-center px-2 py-3 mb-2 transition-all duration-200 ease-in-out rounded hover:bg-gray-lightest dark:hover:bg-gray-darker">
          <div class="flex-none w-8 text-center transition-all duration-200 ease-in-out md:mx-2 text-gray-light dark:text-gray-dark hover:text-gray-dark dark:hover:text-gray-default" @click="play_media(media)">
            <span v-if="global_data.$curr_media_id == media.id">
              <i class="text-gray-dark dark:text-gray-default fas fa-volume-up fa-fw" />
            </span>
            <span v-else>
              <i class="text-xs fas fa-fw fa-play" />
            </span>
          </div>
          <div class="flex-auto mx-2 text-left truncate">
            {{ media.custom_properties.codec_name }}
            <div class="text-xs">
              <span v-if="media.custom_properties.bit_rate">{{ Math.round(media.custom_properties.bit_rate / 1000) }} kbps</span>
              <span v-else-if="media.custom_properties.bits_per_raw_sample">{{ media.custom_properties.bits_per_raw_sample }} bits</span>
              <span v-else-if="media.custom_properties.bits_per_sample">{{ media.custom_properties.bits_per_sample }} bits</span>
              <span class="text-gray-light dark:text-gray-dark">&bull;</span>
              {{ media.custom_properties.sample_rate / 1000 }} kHz
              <template v-if="$page.props.user">
                <span class="text-gray-light dark:text-gray-dark">&bull;</span>
                {{ media.score }}
              </template>
            </div>
          </div>
          <div class="flex-none hidden w-24 mx-2 text-left truncate sm:block lg:w-36 text-gray-dark dark:text-gray-default">
            <span v-if="media.custom_properties.source == 'youtube'"><i class="mr-1 opacity-50 fa-fw fab fa-youtube" /> YouTube</span>
            <span v-else-if="media.custom_properties.source == 'apple music'"><i class="mr-1 opacity-50 fa-fw fab fa-apple" /> Apple Music</span>
            <span v-else-if="media.custom_properties.source == 'cd'"><i class="mr-1 opacity-50 fa-fw fas fa-compact-disc" /> CD</span>
            <span v-else-if="media.custom_properties.source == 'deezer'"><i class="mr-1 opacity-50 fa-fw fab fa-deezer" /> Deezer</span>
            <span v-else-if="media.custom_properties.source == 'qobuz'"><i class="mr-1 opacity-50 fa-fw fas fa-compact-disc" /> Qobuz</span>
            <span v-else-if="media.custom_properties.source == 'soundcloud'"><i class="mr-1 opacity-50 fa-fw fab fa-soundcloud" /> SoundCloud</span>
            <span v-else-if="media.custom_properties.source == 'spotify'"><i class="mr-1 opacity-50 fa-fw fab fa-spotify" /> Spotify</span>
            <span v-else-if="media.custom_properties.source == 'converted'"><i class="mr-1 opacity-50 fa-fw fas fa-compress-alt" /> <abbr class="underline decoration-dotted" title="Fichier compressé à partir d'une source de meilleure qualité">Compressé</abbr></span>
            <span v-else-if="media.custom_properties.source == 'extracted'"><i class="mr-1 opacity-50 fa-fw fas fa-expand-alt" /> <abbr class="underline decoration-dotted" title="Fichier extrait à partir d'une source vidéo présente dans les fichiers">Piste audio</abbr></span>
            <span v-else-if="media.custom_properties.source" class="capitalize">{{ media.custom_properties.source }}</span>
            <span v-else>N/A</span>
          </div>
          <div class="flex-none w-16 mx-2 text-left text-gray-dark dark:text-gray-default">
            {{ moment.duration(media.custom_properties.duration, 'seconds').format('mm:ss', { trim: false }) }}
          </div>
          <div class="flex-none hidden w-20 mx-2 text-left sm:block text-gray-dark dark:text-gray-default">
            {{ get_readable_file_size_string(media.size) }}
          </div>
          <div class="flex-none hidden w-32 mx-2 text-left lg:block text-gray-dark dark:text-gray-default">
            {{ moment(media.created_at).format('DD/MM/YYYY') }}
          </div>
          <div class="flex-none w-32 text-right md:mx-2 text-gray-light dark:text-gray-dark">
            <a v-if="song.is_downloadable" class="transition-all duration-200 ease-in-out hover:text-gray-dark dark:hover:text-gray-default" :href="media.url" target="_blank">
              <i class="text-xs fas fa-arrow-down" />
            </a>
            <inertia-link v-if="$page.props.user && media.custom_properties.codec_name == 'flac'" class="ml-2 transition-all duration-200 ease-in-out hover:text-gray-dark dark:hover:text-gray-default" :href="route('files.showConvertForm', { file: media })">
              <i class="text-xs fas fa-sync" />
            </inertia-link>
            <button v-if="$page.props.user" class="ml-2 transition-all duration-200 ease-in-out hover:text-gray-dark dark:hover:text-gray-default" @click="destroy_media(media)">
              <i class="text-xs fas fa-trash" />
            </button>
          </div>
        </div>
      </div>

      <template v-if="files && files.length">
        <h2 class="mb-4 text-xl font-semibold">Fichiers</h2>
        <files-table class="mb-8" :files="files" />
      </template>

      <template v-if="variants.length">
        <h2 class="mb-4 text-xl font-semibold">Variantes</h2>
        <songs-table class="mb-8" :songs="variants" />
      </template>

      <template v-if="song.events.length">
        <h2 class="mb-4 text-xl font-semibold">Diffusions</h2>
        <events-grid class="mb-8" :events="song.events" />
      </template>

      <template v-if="song.albums.length">
        <h2 class="mb-4 text-xl font-semibold">Présent dans</h2>
        <albums-grid class="mb-8" :albums="song.albums" />
      </template>
    </div>
  </div>
</template>

<script>
import Layout from '@/layouts/app.vue'
import { EventBus } from '../../event-bus.js'
import { global_data } from '../../store.js'

export default {
  layout: Layout,

  props: ['song', 'medias', 'files', 'variants'],

  data() {
    return {
      global_data: global_data,
    }
  },

  methods: {
    destroy() {
      this.$inertia.delete(this.route('songs.destroy', this.song))
    },

    destroy_media(media) {
      this.$inertia.delete(this.route('songs.medias.destroy', { song: this.song, media }))
    },

    play() {
      EventBus.$emit('play:song', {
        song: this.song,
        empty_queue: true,
      })
    },

    play_media(media) {
      EventBus.$emit('play:media', {
        song: this.song,
        media: media,
      })
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
