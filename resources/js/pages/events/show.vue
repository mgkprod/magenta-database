<template>
  <div>
    <inertia-head>
      <title>{{ $page.props.event.name }}</title>
      <!-- <meta head-key="description" name="description" content="" /> -->
      <meta head-key="og:image" property="og:image" :content="$page.props.event.image_url" />
      <meta head-key="twitter:image" name="twitter:image" :content="$page.props.event.image_url" />
    </inertia-head>

    <div class="flex flex-row justify-end w-full px-4 py-4 bg-white border-b-4 dark:bg-black border-gray-lighter dark:border-gray-darker" v-if="$page.props.user">
      <inertia-link class="inline-flex items-center px-4 py-1 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500" :href="route('events.files.create', event)"> <i class="mr-2 opacity-50 fas fa-folder-open"></i> Add file </inertia-link>
      <inertia-link class="inline-flex items-center px-4 py-1 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500" :href="route('events.edit', event)"> <i class="mr-2 opacity-50 fas fa-edit"></i> Edit </inertia-link>
      <button class="inline-flex items-center px-4 py-1 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500" @click="destroy()"><i class="mr-2 opacity-50 fas fa-trash"></i> Delete</button>
    </div>

    <div class="relative flex flex-col items-start justify-start p-8 border-b-4 sm:flex-row border-gray-lighter dark:border-gray-darker">
      <div class="bg-cover-container">
        <div class="bg-cover bg-gradient-to-br from-white to-white dark:from-black dark:to-black" :style="{ '--tw-gradient-from': event.image_dominant_color }"></div>
      </div>

      <div class="flex-none mb-8 w-72 sm:w-48 lg:w-72 sm:mb-0 sm:mr-8">
        <vue-load-image class="shadow-xl aspect-w-16 aspect-h-9">
          <template v-slot:image>
            <img :src="event.image_url" class="object-cover w-full h-full animate__animated animate__fadeIn animate__fastest" />
          </template>
          <template v-slot:preloader>
            <div class="flex items-center justify-center opacity-50" :style="{ 'background-color': event.image_dominant_color }">
              <i class="text-black dark:text-white fas fa-spin fa-spinner"></i>
            </div>
          </template>
        </vue-load-image>
      </div>

      <div>
        <div class="mb-2 text-xs uppercase text-gray-dark dark:text-gray-default">Event</div>
        <h1 class="mb-4 text-4xl font-semibold">{{ event.name }}</h1>
        <div class="text-gray-dark dark:text-gray-default">
          Date :
          <span v-if="event.happened_at">{{ moment(event.happened_at).format('DD/MM/YYYY') }}</span>
          <span v-else>N/A</span>
        </div>
        <div class="text-gray-dark dark:text-gray-default">Ajouté le : {{ moment(event.created_at).format('DD/MM/YYYY') }}</div>

        <div class="w-full mt-4 whitespace-pre-wrap" v-if="event.details" v-html="markdownit.render(event.details)"></div>

        <div class="mt-8">
          <div class="inline-flex items-center px-4 py-2 font-semibold transition duration-200 ease-in-out bg-white bg-opacity-50 rounded cursor-pointer dark:bg-black text-gray-dark dark:text-gray-default active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500 hover:bg-opacity-70" @click="play()">
            <i class="mr-2 text-xs opacity-50 fas fa-play"></i>
            <span>Écouter</span>
          </div>
        </div>
      </div>
    </div>

    <div class="w-full p-4 pb-0 md:p-8">
      <songs-table class="mb-8" :songs="event.songs"></songs-table>

      <template v-if="files && files.length">
        <h2 class="mb-4 text-xl font-semibold">Fichiers</h2>
        <files-table class="mb-8" :files="files"></files-table>
      </template>
    </div>
  </div>
</template>

<script>
import Layout from '@/layouts/app.vue';
import { EventBus } from '../../event-bus.js';

export default {
  layout: Layout,

  props: ['event', 'files'],

  methods: {
    destroy() {
      this.$inertia.delete(this.route('events.destroy', this.event));
    },
    play() {
      EventBus.$emit('play:event', {
        event: this.event,
      });
    },
  },
};
</script>
