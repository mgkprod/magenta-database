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
      <h2 class="mb-4 text-xl font-semibold">Bienvenue</h2>

      <p class="mb-8">
        Ce site est une base de données communautaire qui référence les tracks connues du groupe MAGENTA et de leurs projets liés.<br />
        L'objectif est de garder une trace des différentes réinterprétations musicales et des tracks non publiées.<br />
        <br />
        Le site est alimenté par les contributions des membres du Discord. N'hésitez pas à
        <a href="https://bit.ly/magentadiscord" target="_blank" class="transition duration-200 ease-in-out text-gray-dark dark:text-gray-default hover:text-gray-darker dark:hover:text-gray-lighter">nous rejoindre</a>
        !<br />
      </p>

      <div class="mb-8">
        <div class="mb-2">Retrouvez MAGENTA sur les réseaux :</div>

        <ul class="grid grid-cols-1 gap-1">
          <li>
            <a href="https://www.facebook.com/magentamusique/" class="inline-flex items-center px-4 py-2 text-xs font-semibold transition duration-200 ease-in-out bg-white bg-opacity-50 rounded cursor-pointer dark:bg-black text-gray-dark dark:text-gray-default active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500 hover:bg-opacity-70" target="_blank"><i class="mr-2 opacity-50 fab fa-fw fa-facebook"></i> Facebook</a>
          </li>
          <li>
            <a href="https://www.youtube.com/channel/UCDJL7wvwArdhfydZR-XFtgw" class="inline-flex items-center px-4 py-2 text-xs font-semibold transition duration-200 ease-in-out bg-white bg-opacity-50 rounded cursor-pointer dark:bg-black text-gray-dark dark:text-gray-default active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500 hover:bg-opacity-70" target="_blank"><i class="mr-2 opacity-50 fab fa-fw fa-youtube"></i> YouTube</a>
          </li>
          <li>
            <a href="https://www.instagram.com/magenta.club/" class="inline-flex items-center px-4 py-2 text-xs font-semibold transition duration-200 ease-in-out bg-white bg-opacity-50 rounded cursor-pointer dark:bg-black text-gray-dark dark:text-gray-default active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500 hover:bg-opacity-70" target="_blank"><i class="mr-2 opacity-50 fab fa-fw fa-instagram"></i> Instagram</a>
          </li>
          <li>
            <a href="https://open.spotify.com/artist/5du1Lf0YKbak13Ym58jKsA" class="inline-flex items-center px-4 py-2 text-xs font-semibold transition duration-200 ease-in-out bg-white bg-opacity-50 rounded cursor-pointer dark:bg-black text-gray-dark dark:text-gray-default active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500 hover:bg-opacity-70" target="_blank"><i class="mr-2 opacity-50 fab fa-fw fa-spotify"></i> Spotify</a>
          </li>
          <li>
            <a href="https://music.apple.com/fr/artist/magenta/1482405700" class="inline-flex items-center px-4 py-2 text-xs font-semibold transition duration-200 ease-in-out bg-white bg-opacity-50 rounded cursor-pointer dark:bg-black text-gray-dark dark:text-gray-default active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500 hover:bg-opacity-70" target="_blank"><i class="mr-2 opacity-50 fab fa-fw fa-apple"></i> Apple Music</a>
          </li>
          <li>
            <a href="https://mtl.fm/magenta?fbclid=IwAR3uKDD5RqFPbpl0ziM3xub62vQQ8OC3oHWHg2-dkz_iQqwyXWbFyuHV9Aw#!/index" class="inline-flex items-center px-4 py-2 text-xs font-semibold transition duration-200 ease-in-out bg-white bg-opacity-50 rounded cursor-pointer dark:bg-black text-gray-dark dark:text-gray-default active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500 hover:bg-opacity-70" target="_blank"><i class="mr-2 opacity-50 fas fa-fw fa-phone"></i> WhatsApp</a>
          </li>
        </ul>
      </div>

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
export default {
  layout: require('../layouts/app').default,

  props: ['albums'],
};
</script>
