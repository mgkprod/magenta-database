<template>
  <div>
    <inertia-head>
      <title>Events</title>
      <meta head-key="description" name="description" content="Tous les tracks regroupés par évènements" />
    </inertia-head>

    <div v-if="$page.props.user" class="flex w-full flex-row justify-end border-b-4 border-gray-lighter bg-white p-4 dark:border-gray-darker dark:bg-black">
      <inertia-link class="mx-1 inline-flex items-center rounded bg-gray-lightest px-4 py-1 text-sm font-semibold text-gray-dark transition duration-200 ease-in-out hover:bg-gray-light focus:outline-none focus:ring-2 focus:ring-gray-500/50 active:bg-transparent dark:bg-gray-darker dark:text-gray-default dark:hover:bg-gray-dark" :href="route('events.create')"> <i class="fas fa-plus mr-2 opacity-50" /> Add </inertia-link>
    </div>

    <div class="p-4 md:p-8">
      <div class="mb-8">
        <events-grid :events="events" class="mb-8" />
      </div>
    </div>
  </div>
</template>

<script>
import Layout from '@/layouts/app.vue'

export default {
  layout: Layout,

  props: {
    events: Array,
  },
}
</script>
