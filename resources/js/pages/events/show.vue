<template>
  <div>
    <inertia-head>
      <title>{{ $page.props.event.name }}</title>
      <!-- <meta head-key="description" name="description" content="" /> -->
      <meta head-key="og:image" property="og:image" :content="$page.props.event.image_url" />
      <meta head-key="twitter:image" name="twitter:image" :content="$page.props.event.image_url" />
    </inertia-head>

    <div v-if="$page.props.user" class="flex w-full flex-row justify-end border-b-4 border-gray-lighter bg-white p-4 dark:border-gray-darker dark:bg-black">
      <inertia-link class="mx-1 inline-flex items-center rounded bg-gray-lightest px-4 py-1 text-sm font-semibold text-gray-dark transition duration-200 ease-in-out hover:bg-gray-light focus:outline-none focus:ring-2 focus:ring-gray-500/50 active:bg-transparent dark:bg-gray-darker dark:text-gray-default dark:hover:bg-gray-dark" :href="route('events.files.create', event)"> <i class="fas fa-folder-open mr-2 opacity-50" /> Add file </inertia-link>
      <inertia-link class="mx-1 inline-flex items-center rounded bg-gray-lightest px-4 py-1 text-sm font-semibold text-gray-dark transition duration-200 ease-in-out hover:bg-gray-light focus:outline-none focus:ring-2 focus:ring-gray-500/50 active:bg-transparent dark:bg-gray-darker dark:text-gray-default dark:hover:bg-gray-dark" :href="route('events.edit', event)"> <i class="fas fa-edit mr-2 opacity-50" /> Edit </inertia-link>
      <button class="mx-1 inline-flex items-center rounded bg-gray-lightest px-4 py-1 text-sm font-semibold text-gray-dark transition duration-200 ease-in-out hover:bg-gray-light focus:outline-none focus:ring-2 focus:ring-gray-500/50 active:bg-transparent dark:bg-gray-darker dark:text-gray-default dark:hover:bg-gray-dark" @click="destroy()"><i class="fas fa-trash mr-2 opacity-50" /> Delete</button>
    </div>

    <div class="relative flex flex-col items-start justify-start border-b-4 border-gray-lighter p-8 sm:flex-row dark:border-gray-darker">
      <div class="bg-cover-container">
        <div class="bg-gradient-to-br from-white to-white bg-cover dark:from-black dark:to-black" :style="{ '--tw-gradient-from': event.image_dominant_color }" />
      </div>

      <div class="mb-8 w-72 flex-none sm:mb-0 sm:mr-8 sm:w-48 lg:w-72">
        <vue-load-image class="aspect-h-9 aspect-w-16 shadow-xl">
          <template #image>
            <img :src="event.image_url" class="animate__animated animate__fadeIn animate__fastest size-full object-cover" />
          </template>
          <template #preloader>
            <div class="flex items-center justify-center opacity-50" :style="{ 'background-color': event.image_dominant_color }">
              <i class="fas fa-spin fa-spinner text-black dark:text-white" />
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

        <div v-if="event.details" class="mt-4 w-full whitespace-pre-wrap" v-html="markdownit.render(event.details)" />

        <div class="mt-8">
          <div class="inline-flex cursor-pointer items-center rounded bg-white/50 px-4 py-2 font-semibold text-gray-dark transition duration-200 ease-in-out hover:bg-white/70 focus:outline-none focus:ring-2 focus:ring-gray-500/50 active:bg-transparent dark:bg-black/50 dark:text-gray-default dark:hover:bg-black/70" @click="play()">
            <i class="fas fa-play mr-2 text-xs opacity-50" />
            <span>Écouter</span>
          </div>
        </div>
      </div>
    </div>

    <div class="w-full p-4 pb-0 md:p-8">
      <songs-table class="mb-8" :songs="event.songs" />

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

  props: ['event', 'files'],

  methods: {
    destroy() {
      this.$inertia.delete(this.route('events.destroy', this.event))
    },

    play() {
      EventBus.$emit('play:event', {
        event: this.event,
      })
    },
  },
}
</script>
