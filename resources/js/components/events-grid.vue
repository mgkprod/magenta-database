<template>
  <div class="flex flex-wrap items-start justify-start -m-2 xl:-m-3">
    <inertia-link v-for="event in events" :key="event.id" class="w-full p-2 xs:w-1/2 sm:w-1/2 lg:w-1/3 xl:p-3 xl:w-64" :href="route('events.show', event)">
      <div class="flex flex-col transition duration-200 ease-in-out transform rounded shadow-md cursor-pointer justify-left bg-gray-lightest dark:bg-gray-darker hover:bg-gray-lighter dark:hover:bg-gray-dark hover:shadow-lg hover:scale-105">
        <vue-load-image class="bg-white bg-opacity-50 rounded-t dark:bg-black aspect-w-16 aspect-h-9">
          <template #image>
            <img :src="event.image_url" class="object-cover w-full h-full rounded-t animate__animated animate__fadeIn animate__fastest" />
          </template>
          <template #preloader>
            <div class="flex items-center justify-center rounded-t opacity-50" :style="{ 'background-color': event.image_dominant_color }">
              <i class="text-black dark:text-white fas fa-spin fa-spinner" />
            </div>
          </template>
        </vue-load-image>

        <div class="px-4 py-3">
          <div class="break-all truncate">
            {{ event.name }}
          </div>
          <div class="text-sm truncate text-gray-dark dark:text-gray-default">
            {{ moment(event.happened_at).format('MM/YYYY') }}
          </div>
        </div>
      </div>
    </inertia-link>
  </div>
</template>

<script>
export default {
  props: ['events'],
}
</script>
