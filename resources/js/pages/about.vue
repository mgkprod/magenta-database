<template>
  <div class="relative h-full">
    <inertia-head>
      <title>Bienvenue</title>
    </inertia-head>

    <div class="fixed inset-0 overflow-hidden">
      <div class="z-0 scale-150">
        <div class="flex w-screen flex-wrap items-start justify-start opacity-20 lg:-rotate-12 dark:opacity-30">
          <div v-for="(album, k) in albums" :key="k" class="w-1/3 p-1 sm:w-2/12 lg:w-1/12">
            <div class="justify-left flex cursor-pointer flex-col rounded bg-gray-lightest shadow-md transition duration-200 ease-in-out dark:bg-gray-darker">
              <vue-load-image class="aspect-h-1 aspect-w-1 rounded-t">
                <template #image>
                  <img :src="album.image_url" class="animate__animated animate__fadeIn animate__fastest size-full rounded-t object-cover" />
                </template>
                <template #preloader>
                  <div class="flex items-center justify-center rounded-t opacity-50" :style="{ 'background-color': album.image_dominant_color }">
                    <i class="fas fa-spin fa-spinner text-black dark:text-white" />
                  </div>
                </template>
              </vue-load-image>
            </div>
          </div>
        </div>
      </div>
      <div class="fixed inset-0 z-0 bg-gradient-to-tl from-transparent to-white dark:to-gray-darkest" />
    </div>

    <div class="relative p-4 md:p-8">
      <div v-html="content" />

      <p class="mb-8 text-xs text-gray-dark dark:text-gray-default">
        Développé avec <span class="text-pink-500">❤️</span> par <a href="https://mgk.dev" target="_blank" class="text-gray-dark transition duration-200 ease-in-out hover:text-gray-darker dark:text-gray-default dark:hover:text-gray-lighter">Simon R.</a><br />
        <br />
        Les contenus référencés et hébergés appartiennent à leurs auteurs respectifs.<br />
        &copy;
        <a href="https://mgk.dev" target="_blank" class="text-gray-dark transition duration-200 ease-in-out hover:text-gray-darker dark:text-gray-default dark:hover:text-gray-lighter">MGK</a>
        - {{ $page.props.version }}<br />
      </p>
    </div>
  </div>
</template>

<script>
import Layout from '@/layouts/app.vue'

export default {
  layout: Layout,

  props: ['albums', 'content'],
}
</script>
