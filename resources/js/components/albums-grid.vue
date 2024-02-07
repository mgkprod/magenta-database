<template>
  <div class="-m-2 flex flex-wrap items-start justify-start xl:-m-3">
    <inertia-link v-for="album in albums" :key="album.id" class="w-1/2 p-2 sm:w-1/3 lg:w-1/4 xl:w-56 xl:p-3" :href="route('albums.show', album)">
      <div class="justify-left flex cursor-pointer flex-col rounded bg-gray-lightest shadow-md transition duration-200 ease-in-out hover:scale-105 hover:bg-gray-lighter hover:shadow-lg dark:bg-gray-darker dark:hover:bg-gray-dark">
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

        <div class="px-4 py-3">
          <div class="truncate break-all">{{ album.name }}</div>
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
}
</script>
