<template>
  <div>
    <inertia-head>
      <title>Search</title>
      <!-- <meta head-key="description" name="description" content="" /> -->
    </inertia-head>

    <div class="p-4 md:p-8">
      <form class="mb-8" @submit.prevent="submit">
        <div class="flex flex-row items-center">
          <input v-model="form.q" type="text" placeholder="On écoute quoi ?" autofocus class="font-sans leading-6 m-0 py-1.5 px-3 sm:text-sm text-neutral-900 dark:text-neutral-0 placeholder:text-neutral-400 dark:placeholder:text-neutral-500 bg-neutral-0 dark:bg-neutral-900 shadow-sm ring-1 ring-inset ring-neutral-300 dark:ring-neutral-700 ring-offset-0 rounded-md appearance-none w-full outline-none focus:ring-indigo-500 dark:focus:ring-indigo-400 transition duration-150 ease-in-out" />

          <i class="ml-4 text-xs transition-all duration-200 ease-in-out fas fa-search text-gray-light dark:text-gray-dark hover:text-gray-dark dark:hover:text-gray-default" @click="submit" />
        </div>
      </form>

      <template v-if="q">
        <h2 class="mb-4 text-xl font-semibold">Tracks</h2>
        <songs-table v-if="results.songs && results.songs.length" class="mb-8" :songs="results.songs" />
        <div v-else class="mb-8 text-sm text-gray-light dark:text-gray-dark">Aucun track trouvé</div>

        <h2 class="mb-4 text-xl font-semibold">Albums</h2>
        <div v-if="results.albums && results.albums.length" class="mb-8">
          <albums-grid :albums="results.albums" />
        </div>
        <div v-else class="mb-8 text-sm text-gray-light dark:text-gray-dark">Aucun album trouvé</div>

        <h2 class="mb-4 text-xl font-semibold">Events</h2>
        <div v-if="results.events && results.events.length" class="mb-8">
          <events-grid :events="results.events" />
        </div>
        <div v-else class="mb-8 text-sm text-gray-light dark:text-gray-dark">Aucun event trouvé</div>
      </template>
    </div>
  </div>
</template>

<script>
import Layout from '@/layouts/app.vue'

export default {
  layout: Layout,

  props: ['results', 'q'],

  data() {
    return {
      form: {
        q: '',
      },
    }
  },

  mounted() {
    this.form.q = this.q
  },

  methods: {
    submit() {
      this.$page.props.errors = {}

      this.$inertia.get(this.route('search.index'), this.form)
    },
  },
}
</script>
