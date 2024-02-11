<template>
  <div class="p-4 md:p-8">
    <form @submit.prevent="submit">
      <h2 class="mb-4 text-xl font-semibold">Albums</h2>

      <div v-if="form.album_ids" class="mb-8">
        <div class="-m-2 flex flex-wrap items-start justify-start xl:-m-3">
          <div v-for="id in form.album_ids" :key="id" class="w-1/2 p-2 sm:w-1/3 lg:w-1/4 xl:w-56 xl:p-3">
            <div class="relative rounded bg-gray-lightest p-4 shadow-md dark:bg-gray-darker">
              <div class="truncate text-sm">{{ albums[id] }}</div>
              <button class="absolute right-0 top-0 p-2 text-sm text-red-500 focus:outline-none" @click.prevent="remove_album(id)">
                <i class="fas fa-times" />
              </button>
            </div>
          </div>
        </div>
      </div>

      <form class="mb-8 w-full" @submit.prevent="assoc_album">
        <div class="flex flex-col items-end justify-start">
          <form-select v-model="current_album_id" label="Add the following album" class="mb-2 w-full" :options="albums_for_select" option-label="name" option-value="id" />
          <button type="submit" class="inline-flex items-center rounded bg-gray-lightest px-4 py-1 text-sm font-semibold text-gray-dark transition duration-200 ease-in-out hover:bg-gray-light focus:outline-none focus:ring-2 focus:ring-gray-500/50 active:bg-transparent dark:bg-gray-darker dark:text-gray-default dark:hover:bg-gray-dark">
            <i class="fas fa-plus" />
          </button>
        </div>
      </form>

      <h2 class="mb-4 text-xl font-semibold">Events</h2>

      <div v-if="form.event_ids.length" class="mb-8">
        <div class="-m-2 flex flex-wrap items-start justify-start xl:-m-3">
          <div v-for="id in form.event_ids" :key="id" class="w-1/2 p-2 sm:w-1/3 lg:w-1/4 xl:w-56 xl:p-3">
            <div class="relative rounded bg-gray-lightest p-4 shadow-md dark:bg-gray-darker">
              <div class="truncate text-sm">{{ events[id] }}</div>
              <button class="absolute right-0 top-0 p-2 text-sm text-red-500 focus:outline-none" @click.prevent="remove_event(id)">
                <i class="fas fa-times" />
              </button>
            </div>
          </div>
        </div>
      </div>

      <form class="mb-8 w-full" @submit.prevent="assoc_event">
        <div class="flex flex-col items-end justify-start">
          <form-select v-model="current_event_id" label="Add the following event" class="mb-2 w-full" :options="events_for_select" option-label="name" option-value="id" />
          <button type="submit" class="inline-flex items-center rounded bg-gray-lightest px-4 py-1 text-sm font-semibold text-gray-dark transition duration-200 ease-in-out hover:bg-gray-light focus:outline-none focus:ring-2 focus:ring-gray-500/50 active:bg-transparent dark:bg-gray-darker dark:text-gray-default dark:hover:bg-gray-dark">
            <i class="fas fa-plus" />
          </button>
        </div>
      </form>

      <div class="flex justify-end">
        <button class="inline-flex items-center rounded bg-gray-lightest px-4 py-1 text-sm font-semibold text-gray-dark transition duration-200 ease-in-out hover:bg-gray-light focus:outline-none focus:ring-2 focus:ring-gray-500/50 active:bg-transparent dark:bg-gray-darker dark:text-gray-default dark:hover:bg-gray-dark"><i class="fas fa-edit mr-2 opacity-50" /> Edit</button>
      </div>
    </form>
  </div>
</template>

<script>
import Layout from '@/layouts/app.vue'
import formSelect from '../../../components/form-select.vue'
import _ from 'lodash'

export default {
  components: { formSelect },
  layout: Layout,

  props: {
    song: Object,
    album_ids: Array,
    event_ids: Array,
    albums: Object,
    events: Object,
  },

  data() {
    return {
      current_album_id: '',
      current_event_id: '',

      form: {
        album_ids: '',
        event_ids: '',
      },

      albums_for_select: _.map(this.albums, (value, key) => ({ id: key, name: value })),
      events_for_select: _.map(this.events, (value, key) => ({ id: key, name: value })),
    }
  },

  mounted() {
    this.form.album_ids = this.album_ids
    this.form.event_ids = this.event_ids
  },

  methods: {
    submit() {
      this.$page.props.errors = {}

      this.$inertia.put(this.route('songs.update-relations', this.song), { ...this.form })
    },

    assoc_album() {
      if (!_.find(this.form.album_ids, (elem) => elem == this.current_album_id)) this.form.album_ids.push(this.current_album_id)
      this.current_album_id = ''
    },

    assoc_event() {
      if (!_.find(this.form.event_ids, (elem) => elem == this.current_event_id)) this.form.event_ids.push(this.current_event_id)
      this.current_event_id = ''
    },

    remove_album(id) {
      this.form.album_ids = _.reject(this.form.album_ids, (elem) => elem == id)
    },

    remove_event(id) {
      this.form.event_ids = _.reject(this.form.event_ids, (elem) => elem == id)
    },
  },
}
</script>
