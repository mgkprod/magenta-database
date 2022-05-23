<template>
  <div class="flex flex-wrap items-start justify-start -m-2 xl:-m-3">
    <inertia-link v-for="album in albums" v-bind:key="album.id" class="w-1/2 p-2 sm:w-1/3 lg:w-1/4 xl:p-3 xl:w-56" :href="route('albums.show', album)">
      <div class="flex flex-col transition duration-200 ease-in-out transform rounded shadow-md cursor-pointer justify-left bg-gray-lightest dark:bg-gray-darker hover:bg-gray-lighter dark:hover:bg-gray-dark hover:shadow-lg hover:scale-105">
        <vue-load-image class="rounded-t aspect-w-1 aspect-h-1">
          <img slot="image" :src="album.image_url" class="object-cover w-full h-full rounded-t animate__animated animate__fadeIn animate__fastest" />
          <div class="flex items-center justify-center rounded-t opacity-50" :style="{ 'background-color': album.image_dominant_color }" slot="preloader">
            <i class="text-black dark:text-white fas fa-spin fa-spinner"></i>
          </div>
        </vue-load-image>

        <div class="px-4 py-3">
          <div class="break-all truncate">{{ album.name }}</div>
          <div class="truncate text-gray-dark dark:text-gray-default">
            <span class="text-sm">{{ album.artist }}</span>
            <span class="text-gray-light dark:text-gray-dark">&bull;</span>
            <span class="text-sm">{{ moment(album.released_at).format('YYYY') }}</span>
          </div>
        </div>
      </div>
    </inertia-link>
  </div>
</template>

<script>
export default {
  props: ['albums'],
};
</script>
