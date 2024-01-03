<template>
  <div>
    <inertia-head>
      <title>Search</title>
      <!-- <meta head-key="description" name="description" content="" /> -->
    </inertia-head>

    <div class="p-4 md:p-8">
      <form @submit.prevent="submit" class="mb-8">
        <div class="flex flex-row items-center">
          <InputText type="text" v-model="form.q" placeholder="On écoute quoi ?" autofocus />

          <i class="ml-4 text-xs transition-all duration-200 ease-in-out fas fa-search text-gray-light dark:text-gray-dark hover:text-gray-dark dark:hover:text-gray-default" @click="submit"></i>
        </div>
      </form>

      <template v-if="q">
        <h2 class="mb-4 text-xl font-semibold">Tracks</h2>
        <songs-table v-if="results.songs && results.songs.length" class="mb-8" :songs="results.songs"></songs-table>
        <div class="mb-8 text-sm text-gray-light dark:text-gray-dark" v-else>Aucun track trouvé</div>

        <h2 class="mb-4 text-xl font-semibold">Albums</h2>
        <div class="mb-8" v-if="results.albums && results.albums.length">
          <albums-grid :albums="results.albums"></albums-grid>
        </div>
        <div class="mb-8 text-sm text-gray-light dark:text-gray-dark" v-else>Aucun album trouvé</div>

        <h2 class="mb-4 text-xl font-semibold">Events</h2>
        <div class="mb-8" v-if="results.events && results.events.length">
          <events-grid :events="results.events"></events-grid>
        </div>
        <div class="mb-8 text-sm text-gray-light dark:text-gray-dark" v-else>Aucun event trouvé</div>
      </template>
    </div>
  </div>
</template>

<script>
import Layout from '@/layouts/app.vue';
import InputText from '@/components/form-input.vue';

export default {
  layout: Layout,

  components: {
    InputText,
  },

  props: ['results', 'q'],

  data() {
    return {
      form: {
        q: '',
      },
    };
  },

  mounted() {
    this.form.q = this.q;
  },

  methods: {
    submit() {
      this.$page.props.errors = {};

      this.$inertia.get(this.route('search.index'), this.form);
    },
  },
};
</script>
