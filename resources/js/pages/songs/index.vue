<template>
  <div>
    <inertia-head>
      <title>Tracks</title>
      <meta head-key="description" name="description" content="Tous les tracks disponibles" />
    </inertia-head>

    <div class="flex flex-row justify-end w-full px-4 py-4 bg-white border-b-4 dark:bg-black border-gray-lighter dark:border-gray-darker" v-if="$page.props.user">
      <inertia-link class="inline-flex items-center px-4 py-1 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500" :href="route('songs.create')"> <i class="mr-2 opacity-50 fas fa-plus"></i> Add </inertia-link>
    </div>

    <div class="p-4 md:p-8">
      <div class="fade-overflow-x">
        <div class="flex flex-row items-start justify-start mb-4 overflow-x-auto font-semibold" scroll-region>
          <inertia-link
            :href="route('songs.index', { filter: undefined })"
            class="flex-none block mr-2"
            preserve-scroll
            :class="{
              'border-b-4 border-pink-700 text-gray-dark dark:text-gray-lighter': route().current('songs.index', {
                filter: undefined,
              }),
            }"
          >
            Tous
          </inertia-link>
          <inertia-link
            :href="route('songs.index', { filter: 'published' })"
            class="flex-none block mx-2"
            preserve-scroll
            :class="{
              'border-b-4 border-pink-700 text-gray-dark dark:text-gray-lighter': route().current('songs.index', {
                filter: 'published',
              }),
            }"
          >
            Publiés
          </inertia-link>
          <inertia-link
            :href="route('songs.index', { filter: 'published-lost' })"
            class="flex-none block mx-2"
            preserve-scroll
            :class="{
              'border-b-4 border-pink-700 text-gray-dark dark:text-gray-lighter': route().current('songs.index', {
                filter: 'published-lost',
              }),
            }"
          >
            Publiés sans album
          </inertia-link>
          <inertia-link
            :href="route('songs.index', { filter: 'unreleased' })"
            class="flex-none block mx-2"
            preserve-scroll
            :class="{
              'border-b-4 border-pink-700 text-gray-dark dark:text-gray-lighter': route().current('songs.index', {
                filter: 'unreleased',
              }),
            }"
          >
            Inédits
          </inertia-link>
          <inertia-link
            :href="route('songs.index', { filter: 'really-unreleased' })"
            class="flex-none block mx-2"
            preserve-scroll
            :class="{
              'border-b-4 border-pink-700 text-gray-dark dark:text-gray-lighter': route().current('songs.index', {
                filter: 'really-unreleased',
              }),
            }"
          >
            Inédits sans variantes
          </inertia-link>
          <inertia-link
            :href="route('songs.index', { filter: 'deleted' })"
            class="flex-none block ml-2"
            preserve-scroll
            :class="{
              'border-b-4 border-pink-700 text-gray-dark dark:text-gray-lighter': route().current('songs.index', {
                filter: 'deleted',
              }),
            }"
          >
            Supprimés
          </inertia-link>

          <div class="flex-none w-16 h-1"></div>
        </div>
      </div>

      <p v-show="route().current('songs.index', { filter: undefined })" class="mb-8 text-sm"><i class="mr-2 opacity-50 fas fa-info-circle"></i> Tous les tracks référencés</p>
      <p v-show="route().current('songs.index', { filter: 'published' })" class="mb-8 text-sm"><i class="mr-2 opacity-50 fas fa-info-circle"></i> Tous les tracks officiels</p>
      <p v-show="route().current('songs.index', { filter: 'published-lost' })" class="mb-8 text-sm"><i class="mr-2 opacity-50 fas fa-info-circle"></i> Les tracks officiels qui ne sont pas dans à un album ou présent dans un event</p>
      <p v-show="route().current('songs.index', { filter: 'really-unreleased' })" class="mb-8 text-sm"><i class="mr-2 opacity-50 fas fa-info-circle"></i> Les tracks qui n'ont pas eu de release et qu'on a entendu qu'une fois</p>
      <p v-show="route().current('songs.index', { filter: 'unreleased' })" class="mb-8 text-sm"><i class="mr-2 opacity-50 fas fa-info-circle"></i> Les tracks qui n'ont pas eu de release officielle</p>
      <p v-show="route().current('songs.index', { filter: 'deleted' })" class="mb-8 text-sm"><i class="mr-2 opacity-50 fas fa-info-circle"></i> Les tracks qui ont été publiés un jour et qui sont aujourd'hui retirés des plateformes</p>

      <songs-table class="mb-4" :songs="songs.data"></songs-table>

      <div class="flex items-center justify-center">
        <inertia-link v-if="songs.prev_page_url" preserve-scroll :href="songs.prev_page_url" class="transition duration-200 ease-in-out text-gray-dark dark:text-gray-default hover:text-gray-darker dark:hover:text-gray-lightest">
          <i class="fas fa-angle-left"></i>
        </inertia-link>
        <div v-else></div>

        <div class="mx-4 text-xs text-gray-dark dark:text-gray-default">{{ songs.current_page }} / {{ songs.last_page }}</div>

        <inertia-link preserve-scroll v-if="songs.next_page_url" :href="songs.next_page_url" class="transition duration-200 ease-in-out text-gray-dark dark:text-gray-default hover:text-gray-darker dark:hover:text-gray-lightest">
          <i class="fas fa-angle-right"></i>
        </inertia-link>
        <div v-else></div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  layout: require('../../layouts/app').default,

  props: ['songs'],
};
</script>
