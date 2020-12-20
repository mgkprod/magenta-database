<template>
    <div class="p-4 md:p-8">
        <form @submit.prevent="submit">
            <h2 class="mb-4 text-xl font-semibold">Albums</h2>

            <div class="mb-8" v-if="form.album_ids">
                <div class="flex flex-wrap items-start justify-start -m-2 xl:-m-3">
                    <div
                        class="w-1/2 p-2 sm:w-1/3 lg:w-1/4 xl:p-3 xl:w-56"
                        v-for="id in form.album_ids"
                        v-bind:key="id"
                    >
                        <div class="relative p-4 rounded shadow-md bg-gray-lightest dark:bg-gray-darker">
                            <div class="text-sm truncate">{{ albums[id] }}</div>
                            <button @click.prevent="remove_album(id)" class="absolute top-0 right-0 p-2 text-sm text-red-500 focus:outline-none"><i class="fas fa-times"></i></button>
                        </div>
                    </div>

                </div>
            </div>

            <form class="w-full mb-8" @submit.prevent="assoc_album">
                <div class="flex flex-col items-end justify-start">
                    <form-select label="Add the following album" v-model="current_album_id" class="w-full mb-2" :options="albums" />
                    <button type="submit" class="inline-flex items-center px-4 py-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500"><i class="fas fa-plus"></i></button>
                </div>
            </form>

            <h2 class="mb-4 text-xl font-semibold">Events</h2>

            <div class="mb-8" v-if="form.event_ids.length">
                <div class="flex flex-wrap items-start justify-start -m-2 xl:-m-3">
                    <div
                        class="w-1/2 p-2 sm:w-1/3 lg:w-1/4 xl:p-3 xl:w-56"
                        v-for="id in form.event_ids"
                        v-bind:key="id"
                    >
                        <div class="relative p-4 rounded shadow-md bg-gray-lightest dark:bg-gray-darker">
                            <div class="text-sm truncate">{{ events[id] }}</div>
                            <button @click.prevent="remove_event(id)" class="absolute top-0 right-0 p-2 text-sm text-red-500 focus:outline-none"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <form class="w-full mb-8" @submit.prevent="assoc_event">
                <div class="flex flex-col items-end justify-start">
                    <form-select label="Add the following event" v-model="current_event_id" class="w-full mb-2" :options="events" />
                    <button type="submit" class="inline-flex items-center px-4 py-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500"><i class="fas fa-plus"></i></button>
                </div>
            </form>

            <div class="flex justify-end">
                <button class="inline-flex items-center px-4 py-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500">
                    <i class="mr-2 opacity-50 fas fa-edit"></i> Edit
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import formSelect from '../../../components/form-select.vue';
    export default {
  components: { formSelect },
        layout: require('../../../layouts/app').default,

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
                }
            }
        },

        mounted() {
            this.form.album_ids = this.album_ids
            this.form.event_ids = this.event_ids
        },

        methods: {
            submit() {
                this.$page.props.errors = {}

                this.$inertia.put(
                    this.route('songs.update-relations', this.song), { ...this.form }
                )
            },
            assoc_album(){
                if (!_.find(this.form.album_ids, (elem) => elem == this.current_album_id))
                    this.form.album_ids.push(this.current_album_id)
                this.current_album_id = ''
            },
            assoc_event(){
                if (!_.find(this.form.event_ids, (elem) => elem == this.current_event_id))
                    this.form.event_ids.push(this.current_event_id)
                this.current_event_id = ''
            },
            remove_album(id){
                this.form.album_ids = _.reject(this.form.album_ids, (elem) => elem == id)
            },
            remove_event(id){
                this.form.event_ids = _.reject(this.form.event_ids, (elem) => elem == id)
            }
        }
    }
</script>
