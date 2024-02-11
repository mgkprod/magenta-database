<template>
  <div>
    <inertia-head>
      <title>{{ $page.props.song.artist }} » {{ $page.props.song.display_title }}</title>
      <!-- <meta head-key="description" name="description" content="" /> -->
      <meta head-key="og:image" property="og:image" :content="$page.props.song.image_url" />
      <meta head-key="twitter:image" name="twitter:image" :content="$page.props.song.image_url" />
    </inertia-head>

    <div v-if="$page.props.user" class="flex w-full flex-row justify-end border-b-4 border-gray-lighter bg-white p-4 dark:border-gray-darker dark:bg-black">
      <inertia-link class="mx-1 inline-flex items-center rounded bg-gray-lightest px-4 py-1 text-sm font-semibold text-gray-dark transition duration-200 ease-in-out hover:bg-gray-light focus:outline-none focus:ring-2 focus:ring-gray-500/50 active:bg-transparent dark:bg-gray-darker dark:text-gray-default dark:hover:bg-gray-dark" :href="route('songs.edit', song)"> <i class="fas fa-edit mr-2 opacity-50" /> Edit </inertia-link>
      <inertia-link class="mx-1 inline-flex items-center rounded bg-gray-lightest px-4 py-1 text-sm font-semibold text-gray-dark transition duration-200 ease-in-out hover:bg-gray-light focus:outline-none focus:ring-2 focus:ring-gray-500/50 active:bg-transparent dark:bg-gray-darker dark:text-gray-default dark:hover:bg-gray-dark" :href="route('songs.edit-relations', song)"> <i class="fas fa-link mr-2 opacity-50" /> Relations </inertia-link>
      <inertia-link class="mx-1 inline-flex items-center rounded bg-gray-lightest px-4 py-1 text-sm font-semibold text-gray-dark transition duration-200 ease-in-out hover:bg-gray-light focus:outline-none focus:ring-2 focus:ring-gray-500/50 active:bg-transparent dark:bg-gray-darker dark:text-gray-default dark:hover:bg-gray-dark" :href="route('songs.files.create', song)"> <i class="fas fa-folder-open mr-2 opacity-50" /> Add file </inertia-link>
      <inertia-link class="mx-1 inline-flex items-center rounded bg-gray-lightest px-4 py-1 text-sm font-semibold text-gray-dark transition duration-200 ease-in-out hover:bg-gray-light focus:outline-none focus:ring-2 focus:ring-gray-500/50 active:bg-transparent dark:bg-gray-darker dark:text-gray-default dark:hover:bg-gray-dark" :href="route('songs.medias.create', song)"> <i class="fas fa-compact-disc mr-2 opacity-50" /> Add media </inertia-link>
      <button class="mx-1 inline-flex items-center rounded bg-gray-lightest px-4 py-1 text-sm font-semibold text-gray-dark transition duration-200 ease-in-out hover:bg-gray-light focus:outline-none focus:ring-2 focus:ring-gray-500/50 active:bg-transparent dark:bg-gray-darker dark:text-gray-default dark:hover:bg-gray-dark" @click="destroy()"><i class="fas fa-trash mr-2 opacity-50" /> Delete</button>
    </div>

    <div class="relative flex flex-col items-start justify-start border-b-4 border-gray-lighter p-8 sm:flex-row dark:border-gray-darker">
      <div class="bg-cover-container">
        <div class="bg-gradient-to-br from-white to-white bg-cover dark:from-black dark:to-black" :style="{ '--tw-gradient-from': song.image_dominant_color }" />
      </div>

      <div class="mb-8 w-64 flex-none sm:mb-0 sm:mr-8 sm:w-48 lg:w-64">
        <vue-load-image class="aspect-h-1 aspect-w-1 shadow-xl">
          <template #image>
            <img :src="song.image_url" class="animate__animated animate__fadeIn animate__fastest size-full object-cover" />
          </template>
          <template #preloader>
            <div class="flex items-center justify-center opacity-50" :style="{ 'background-color': song.image_dominant_color }">
              <i class="fas fa-spin fa-spinner text-black dark:text-white" />
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

        <div v-if="song.details" class="mt-4 w-full whitespace-pre-wrap" v-html="markdownit.render(song.details)" />

        <div v-if="medias.length" class="mt-8">
          <div class="inline-flex cursor-pointer items-center rounded bg-white/50 px-4 py-2 font-semibold text-gray-dark transition duration-200 ease-in-out hover:bg-white/70 focus:outline-none focus:ring-2 focus:ring-gray-500/50 active:bg-transparent dark:bg-black/50 dark:text-gray-default" @click="play()">
            <i class="fas fa-play mr-2 text-xs opacity-50" />
            <span>Écouter</span>
          </div>
        </div>
      </div>
    </div>

    <div class="w-full p-4 pb-0 md:p-8">
      <div v-if="medias.length" class="mb-8 flex flex-col">
        <div class="mb-2 flex flex-row border-b border-gray-lighter p-2 dark:border-gray-darker">
          <div class="w-8 flex-none text-center text-xs uppercase text-gray-dark md:mx-2 dark:text-gray-default" />
          <div class="mx-2 flex-auto truncate text-left text-xs uppercase text-gray-dark dark:text-gray-default">Info</div>
          <div class="mx-2 hidden w-24 flex-none text-left text-xs uppercase text-gray-dark sm:block lg:w-36 dark:text-gray-default">Source</div>
          <div class="mx-2 w-16 flex-none text-left text-xs uppercase text-gray-dark dark:text-gray-default">Durée</div>
          <div class="mx-2 hidden w-20 flex-none text-left text-xs uppercase text-gray-dark sm:block dark:text-gray-default">Taille</div>
          <div class="mx-2 hidden w-32 flex-none text-left text-xs uppercase text-gray-dark lg:block dark:text-gray-default">Ajouté</div>
          <div class="w-32 flex-none text-right text-xs uppercase text-gray-dark md:mx-2 dark:text-gray-default" />
        </div>

        <div v-for="media in medias" :key="media.id" class="mb-2 flex flex-row items-center rounded px-2 py-3 transition-all duration-200 ease-in-out hover:bg-gray-lightest dark:hover:bg-gray-darker">
          <div class="w-8 flex-none text-center text-gray-light transition-all duration-200 ease-in-out hover:text-gray-dark md:mx-2 dark:text-gray-dark dark:hover:text-gray-default" @click="play_media(media)">
            <span v-if="global_data.$curr_media_id == media.id">
              <i class="fas fa-volume-up fa-fw text-gray-dark dark:text-gray-default" />
            </span>
            <span v-else>
              <i class="fas fa-fw fa-play text-xs" />
            </span>
          </div>
          <div class="mx-2 flex-auto truncate text-left">
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
          <div class="mx-2 hidden w-24 flex-none truncate text-left text-gray-dark sm:block lg:w-36 dark:text-gray-default">
            <span v-if="media.custom_properties.source == 'youtube'"><i class="fa-fw fab fa-youtube mr-1 opacity-50" /> YouTube</span>
            <span v-else-if="media.custom_properties.source == 'apple music'"><i class="fa-fw fab fa-apple mr-1 opacity-50" /> Apple Music</span>
            <span v-else-if="media.custom_properties.source == 'cd'"><i class="fa-fw fas fa-compact-disc mr-1 opacity-50" /> CD</span>
            <span v-else-if="media.custom_properties.source == 'deezer'"><i class="fa-fw fab fa-deezer mr-1 opacity-50" /> Deezer</span>
            <span v-else-if="media.custom_properties.source == 'qobuz'"><i class="fa-fw fas fa-compact-disc mr-1 opacity-50" /> Qobuz</span>
            <span v-else-if="media.custom_properties.source == 'soundcloud'"><i class="fa-fw fab fa-soundcloud mr-1 opacity-50" /> SoundCloud</span>
            <span v-else-if="media.custom_properties.source == 'spotify'"><i class="fa-fw fab fa-spotify mr-1 opacity-50" /> Spotify</span>
            <span v-else-if="media.custom_properties.source == 'converted'"><i class="fa-fw fas fa-compress-alt mr-1 opacity-50" /> <abbr class="underline decoration-dotted" title="Fichier compressé à partir d'une source de meilleure qualité">Compressé</abbr></span>
            <span v-else-if="media.custom_properties.source == 'extracted'"><i class="fa-fw fas fa-expand-alt mr-1 opacity-50" /> <abbr class="underline decoration-dotted" title="Fichier extrait à partir d'une source vidéo présente dans les fichiers">Piste audio</abbr></span>
            <span v-else-if="media.custom_properties.source" class="capitalize">{{ media.custom_properties.source }}</span>
            <span v-else>N/A</span>
          </div>
          <div class="mx-2 w-16 flex-none text-left text-gray-dark dark:text-gray-default">
            {{ moment.duration(media.custom_properties.duration, 'seconds').format('mm:ss', { trim: false }) }}
          </div>
          <div class="mx-2 hidden w-20 flex-none text-left text-gray-dark sm:block dark:text-gray-default">
            {{ get_readable_file_size_string(media.size) }}
          </div>
          <div class="mx-2 hidden w-32 flex-none text-left text-gray-dark lg:block dark:text-gray-default">
            {{ moment(media.created_at).format('DD/MM/YYYY') }}
          </div>
          <div class="w-32 flex-none text-right text-gray-light md:mx-2 dark:text-gray-dark">
            <a v-if="song.is_downloadable" class="transition-all duration-200 ease-in-out hover:text-gray-dark dark:hover:text-gray-default" :href="media.url" target="_blank">
              <i class="fas fa-arrow-down text-xs" />
            </a>
            <inertia-link v-if="$page.props.user && media.custom_properties.codec_name == 'flac'" class="ml-2 transition-all duration-200 ease-in-out hover:text-gray-dark dark:hover:text-gray-default" :href="route('files.showConvertForm', { file: media })">
              <i class="fas fa-sync text-xs" />
            </inertia-link>
            <button v-if="$page.props.user" class="ml-2 transition-all duration-200 ease-in-out hover:text-gray-dark dark:hover:text-gray-default" @click="destroy_media(media)">
              <i class="fas fa-trash text-xs" />
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
