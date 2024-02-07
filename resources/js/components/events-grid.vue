<template>
  <div class="-m-2 flex flex-wrap items-start justify-start xl:-m-3">
    <inertia-link v-for="event in events" :key="event.id" class="xs:w-1/2 w-full p-2 sm:w-1/2 lg:w-1/3 xl:w-64 xl:p-3" :href="route('events.show', event)">
      <div class="justify-left flex cursor-pointer flex-col rounded bg-gray-lightest shadow-md transition duration-200 ease-in-out hover:scale-105 hover:bg-gray-lighter hover:shadow-lg dark:bg-gray-darker dark:hover:bg-gray-dark">
        <vue-load-image class="aspect-h-9 aspect-w-16 rounded-t bg-white/50 dark:bg-black/50">
          <template #image>
            <img :src="event.image_url" class="animate__animated animate__fadeIn animate__fastest size-full rounded-t object-cover" />
          </template>
          <template #preloader>
            <div class="flex items-center justify-center rounded-t opacity-50" :style="{ 'background-color': event.image_dominant_color }">
              <i class="fas fa-spin fa-spinner text-black dark:text-white" />
            </div>
          </template>
        </vue-load-image>

        <div class="px-4 py-3">
          <div class="truncate break-all">
            {{ event.name }}
          </div>
          <div class="truncate text-sm text-gray-dark dark:text-gray-default">
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
