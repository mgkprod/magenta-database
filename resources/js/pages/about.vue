<template>
  <div class="relative h-full">
    <inertia-head>
      <title>Bienvenue</title>
    </inertia-head>

    <div class="fixed inset-0 overflow-hidden">
      <div class="z-0 transform scale-150">
        <div class="flex flex-wrap items-start justify-start w-screen transform lg:-rotate-12 opacity-20 dark:opacity-30">
          <div v-for="(album, k) in albums" v-bind:key="k" class="w-1/3 p-1 sm:w-2/12 lg:w-1/12">
            <div class="flex flex-col transition duration-200 ease-in-out transform rounded shadow-md cursor-pointer justify-left bg-gray-lightest dark:bg-gray-darker">
              <vue-load-image class="rounded-t aspect-w-1 aspect-h-1">
                <img slot="image" :src="album.image_url" class="object-cover w-full h-full rounded-t animate__animated animate__fadeIn animate__fastest" />
                <div class="flex items-center justify-center rounded-t opacity-50" :style="{ 'background-color': album.image_dominant_color }" slot="preloader">
                  <i class="text-black dark:text-white fas fa-spin fa-spinner"></i>
                </div>
              </vue-load-image>
            </div>
          </div>
        </div>
      </div>
      <div class="fixed inset-0 z-0 bg-gradient-to-tl from-transparent to-white dark:to-gray-darkest"></div>
    </div>

    <div class="relative p-4 md:p-8">
      <div v-html="content" />

      <p class="mb-8 text-xs text-gray-dark dark:text-gray-default">
        Développé avec <span class="text-pink-500">❤️</span> par <a href="https://mgk.dev" target="_blank" class="transition duration-200 ease-in-out text-gray-dark dark:text-gray-default hover:text-gray-darker dark:hover:text-gray-lighter">Simon R.</a><br />
        <br />
        Les contenus référencés et hébergés appartiennent à leurs auteurs respectifs.<br />
        &copy;
        <a href="https://mgk.dev" target="_blank" class="transition duration-200 ease-in-out text-gray-dark dark:text-gray-default hover:text-gray-darker dark:hover:text-gray-lighter">MGK</a>
        - {{ $page.props.version }}<br />
      </p>
    </div>
  </div>
</template>

<script>
import Layout from '@/layouts/app.vue';

export default {
  layout: Layout,

  props: ['albums', 'content'],
};
</script>
