<template>
  <div class="flex flex-col">
    <div class="flex-row hidden px-2 py-2 mb-2 border-b sm:flex border-gray-lighter dark:border-gray-darker">
      <div class="flex-none w-8 text-xs text-center uppercase md:mx-2 text-gray-dark dark:text-gray-default"></div>
      <div class="flex-none w-10 mx-2 text-xs text-center uppercase text-gray-dark dark:text-gray-default"></div>
      <div class="flex-auto mx-2 text-xs text-left uppercase text-gray-dark dark:text-gray-default">Titre</div>
      <div
        class="flex-none hidden w-32 mx-2 text-xs text-left uppercase lg:block text-gray-dark dark:text-gray-default"
      >
        Version
      </div>
      <div
        class="flex-none hidden w-32 mx-2 text-xs text-left uppercase sm:block text-gray-dark dark:text-gray-default"
      >
        Disponibilité
      </div>
      <div
        class="flex-none hidden w-32 mx-2 text-xs text-left uppercase md:block text-gray-dark dark:text-gray-default"
      >
        Première diff.
      </div>
    </div>
    <div
      v-for="song in songs"
      v-bind:key="song.id"
      class="flex flex-row items-center py-3 mb-2 transition-all duration-200 ease-in-out rounded cursor-pointer sm:px-2 hover:bg-gray-lightest dark:hover:bg-gray-darker"
      @click="$inertia.get(route('songs.show', song))"
    >
      <div
        class="flex-none w-8 text-center transition-all duration-200 ease-in-out md:mx-2 text-gray-light dark:text-gray-dark hover:text-gray-dark dark:hover:text-gray-default"
        @click.stop="play_song(song)"
      >
        <span v-if="$curr_song_id == song.id">
          <i class="text-gray-dark dark:text-gray-default fas fa-volume-up fa-fw"></i>
        </span>
        <span v-else>
          <i class="text-xs fas fa-fw fa-play"></i>
        </span>
      </div>
      <div class="flex-none w-10 mx-2">
        <!-- <vue-load-image class="rounded-t aspect-w-1 aspect-h-1">
          <img
            slot="image"
            :src="song.image_url"
            class="object-cover w-full h-full shadow-xl animate__animated animate__fadeIn animate__fastest"
          />
          <div
            class="flex items-center justify-center opacity-50"
            :style="{ 'background-color': song.image_dominant_color }"
            slot="preloader"
          >
            <i class="text-xs text-black dark:text-white fas fa-spin fa-spinner"></i>
          </div>
        </vue-load-image> -->
      </div>
      <div class="flex-auto mx-2 truncate">
        <div class="truncate" :class="{ 'text-pink-500': $curr_song_id == song.id }">{{ song.title }}</div>
        <div class="text-sm truncate text-gray-dark dark:text-gray-default">
          {{ song.artist }}
          <span v-if="song.version_name"
            ><span class="text-gray-light dark:text-gray-dark">&bull;</span> {{ song.version_name }}</span
          >
        </div>
      </div>
      <div class="flex-none hidden w-32 mx-2 text-left lg:block text-gray-dark dark:text-gray-default">
        <span v-if="song.type == 'original'">Originale</span>
        <span v-if="song.type == 'clip'">Clip</span>
        <span v-if="song.type == 'remix'">Remix</span>
        <span v-if="song.type == 'extended-mix'">Extended Mix</span>
        <span v-if="song.type == 'live-rework'">Live Rework</span>
        <span v-if="song.type == 'live'">Live</span>
        <span v-if="song.type == 'rework'">Rework</span>
        <span v-if="song.type == 'radio-edit'">Radio Edit</span>
      </div>
      <div class="flex-none hidden w-32 mx-2 text-left sm:block text-gray-dark dark:text-gray-default">
        <span v-if="song.availability == 'unreleased'">Inédit</span>
        <span v-if="song.availability == 'deleted'">Supprimé</span>
        <span v-if="song.availability == 'published'">Publié</span>
      </div>
      <div class="flex-none hidden w-32 mx-2 text-left md:block text-gray-dark dark:text-gray-default">
        <span v-if="song.first_time_played_at">
          {{ moment(song.first_time_played_at).format('L') }}
        </span>
        <span v-else-if="song.released_at">
          {{ moment(song.released_at).format('YYYY') }}
        </span>
        <span v-else> N/A </span>
      </div>
    </div>
  </div>
</template>

<script>
import { EventBus } from '../event-bus.js';
// import VueLoadImage from 'vue-load-image';

export default {
  props: ['songs'],

  components: {
    // VueLoadImage,
  },

  methods: {
    play_song(song) {
      EventBus.$emit('play:song', {
        song: song,
        context: this.songs,
        empty_queue: true,
      });
    },
  },
};
</script>
