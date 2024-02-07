<template>
  <div class="flex flex-col">
    <div class="mb-2 hidden flex-row border-b border-gray-lighter p-2 sm:flex dark:border-gray-darker">
      <div class="w-8 flex-none text-center text-xs uppercase text-gray-dark md:mx-2 dark:text-gray-default" />
      <div class="mx-2 w-10 flex-none text-center text-xs uppercase text-gray-dark dark:text-gray-default" />
      <div class="mx-2 flex-auto text-left text-xs uppercase text-gray-dark dark:text-gray-default">Titre</div>
      <div class="mx-2 hidden w-32 flex-none text-left text-xs uppercase text-gray-dark lg:block dark:text-gray-default">Version</div>
      <div class="mx-2 hidden w-32 flex-none text-left text-xs uppercase text-gray-dark sm:block dark:text-gray-default">Disponibilité</div>
      <div class="mx-2 hidden w-32 flex-none text-left text-xs uppercase text-gray-dark md:block dark:text-gray-default">Première diff.</div>
    </div>

    <inertia-link v-for="song in songs" :key="song.id" class="mb-2 flex cursor-pointer flex-row items-center rounded py-3 transition-all duration-200 ease-in-out hover:bg-gray-lightest sm:px-2 dark:hover:bg-gray-darker" :class="{ 'opacity-60': !has_medias(song) }" :href="route('songs.show', song)">
      <div class="w-8 flex-none text-center text-gray-light transition-all duration-200 ease-in-out hover:text-gray-dark md:mx-2 dark:text-gray-dark dark:hover:text-gray-default" @click.prevent="play_song(song)">
        <template v-if="has_medias(song)">
          <span v-if="global_data.$curr_song_id == song.id">
            <i class="fas fa-volume-up fa-fw text-gray-dark dark:text-gray-default" />
          </span>
          <span v-else>
            <i class="fas fa-fw fa-play text-xs" />
          </span>
        </template>
      </div>
      <div class="mx-2 w-10 flex-none">
        <vue-load-image class="aspect-h-1 aspect-w-1 rounded-t">
          <template #image>
            <img :src="song.image_url" class="animate__animated animate__fadeIn animate__fastest size-full object-cover shadow-xl" />
          </template>
          <template #preloader>
            <div class="flex items-center justify-center opacity-50" :style="{ 'background-color': song.image_dominant_color }">
              <i class="fas fa-spin fa-spinner text-xs text-black dark:text-white" />
            </div>
          </template>
        </vue-load-image>
      </div>
      <div class="mx-2 flex-auto truncate">
        <div class="truncate" :class="{ 'text-pink-500': global_data.$curr_song_id == song.id }">
          {{ song.title }}
          <span v-if="is_hi_res(song)" class="ml-1 rounded bg-yellow-400 px-2 py-1 text-xs text-black dark:bg-gray-800 dark:text-yellow-400">Hi-Res</span>
          <span v-if="has_videos(song)" class="ml-1 rounded bg-red-400 px-2 py-1 text-xs text-black dark:bg-gray-800 dark:text-red-400"><i class="fas fa-video" /></span>
        </div>
        <div class="truncate text-sm text-gray-dark dark:text-gray-default">
          {{ song.artist }}
          <span v-if="song.version_name"><span class="text-gray-light dark:text-gray-dark">&bull;</span> {{ song.version_name }}</span>
        </div>
      </div>
      <div class="mx-2 hidden w-32 flex-none text-left text-gray-dark lg:block dark:text-gray-default">
        <span v-if="song.type == 'original'">Originale</span>
        <span v-if="song.type == 'clip'">Clip</span>
        <span v-if="song.type == 'remix'">Remix</span>
        <span v-if="song.type == 'extended-mix'">Extended Mix</span>
        <span v-if="song.type == 'live-rework'">Live Rework</span>
        <span v-if="song.type == 'live'">Live</span>
        <span v-if="song.type == 'rework'">Rework</span>
        <span v-if="song.type == 'radio-edit'">Radio Edit</span>
      </div>
      <div class="mx-2 hidden w-32 flex-none text-left text-gray-dark sm:block dark:text-gray-default">
        <span v-if="song.availability == 'unreleased'">Inédit</span>
        <span v-if="song.availability == 'deleted'">Supprimé</span>
        <span v-if="song.availability == 'published'">Publié</span>
      </div>
      <div class="mx-2 hidden w-32 flex-none text-left text-gray-dark md:block dark:text-gray-default">
        <span v-if="song.first_time_played_at">
          {{ moment(song.first_time_played_at).format('DD/MM/YYYY') }}
        </span>
        <span v-else-if="song.released_at">
          {{ moment(song.released_at).format('YYYY') }}
        </span>
        <span v-else> N/A </span>
      </div>
    </inertia-link>
  </div>
</template>

<script>
import { EventBus } from '../event-bus.js'
import _ from 'lodash'
import {global_data} from '../store.js'

export default {
  props: ['songs'],

  data() {
    return {
      global_data: global_data,
    }
  },

  methods: {
    play_song(song) {
      EventBus.$emit('play:song', {
        song: song,
        context: this.songs,
        empty_queue: true,
      })
    },

    has_medias(song) {
      return _.filter(song.media, function (media) {
        return media.collection_name == 'medias'
      }).length
    },

    has_videos(song) {
      return _.filter(song.media, function (media) {
        return media.collection_name == 'files' && (media.mime_type == 'video/x-matroska' || media.mime_type == 'video/webm')
      }).length
    },

    is_hi_res(song) {
      return _.filter(song.media, function (media) {
        return media.collection_name == 'medias' && media.custom_properties.codec_name == 'flac' && media.custom_properties.bits_per_raw_sample == '24'
      }).length
    },
  },
}
</script>
