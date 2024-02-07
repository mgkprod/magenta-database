<template>
  <div>
    <inertia-head>
      <title>Search</title>
      <!-- <meta head-key="description" name="description" content="" /> -->
    </inertia-head>

    <div class="p-4 md:p-8">
      <form class="mb-8" @submit.prevent="submit">
        <div class="flex flex-row items-center">
          <input v-model="form.q" type="text" placeholder="On écoute quoi ?" autofocus class="m-0 w-full appearance-none rounded-md bg-neutral-0 px-3 py-1.5 font-sans leading-6 text-neutral-900 shadow-sm outline-none ring-1 ring-inset ring-neutral-300 ring-offset-0 transition duration-150 ease-in-out placeholder:text-neutral-400 focus:ring-indigo-500 sm:text-sm dark:bg-neutral-900 dark:text-neutral-0 dark:ring-neutral-700 dark:placeholder:text-neutral-500 dark:focus:ring-indigo-400" />

          <i class="fas fa-search ml-4 text-xs text-gray-light transition-all duration-200 ease-in-out hover:text-gray-dark dark:text-gray-dark dark:hover:text-gray-default" @click="submit" />
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
