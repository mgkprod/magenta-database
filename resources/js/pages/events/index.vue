<template>
  <div>
    <inertia-head>
      <title>Events</title>
      <meta head-key="description" name="description" content="Tous les tracks regroupés par évènements" />
    </inertia-head>

    <div class="flex flex-row justify-end w-full px-4 py-4 bg-white border-b-4 dark:bg-black border-gray-lighter dark:border-gray-darker" v-if="$page.props.user">
      <inertia-link class="inline-flex items-center px-4 py-1 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500" :href="route('events.create')"> <i class="mr-2 opacity-50 fas fa-plus"></i> Add </inertia-link>
    </div>

    <div class="p-4 md:p-8">
      <div class="mb-8">
        <events-grid :events="events" class="mb-8"></events-grid>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  layout: require('../../layouts/app').default,

  props: {
    events: Array,
  },
};
</script>
