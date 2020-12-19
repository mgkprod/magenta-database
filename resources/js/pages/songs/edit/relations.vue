<template>
    <div class="p-4 md:p-8">
        <form @submit.prevent="submit">
            <div class="flex flex-wrap items-start justify-start">
                <div
                    class="p-4 mx-2 mb-4 font-mono border border-gray-900 rounded"
                    v-for="id in form.album_ids"
                    v-bind:key="id"
                >
                    {{ albums[id] }} ({{ id }})

                    <button @click.prevent="removeAlbum(id)" class="flex items-center px-4 py-2 text-sm font-semibold text-red-500 transition duration-200 ease-in-out bg-gray-900 rounded shadow-inner hover:text-gray-300 hover:bg-gray-800 active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500">x</button>
                </div>

                <form @submit.prevent="assocAlbum">
                    <div class="flex items-end justify-start">
                        <form-select label="Add the following album" v-model="current_album_id" class="flex-grow" :options="albums" />
                        <button type="submit" class="flex items-center px-4 py-2 text-sm font-semibold text-gray-500 transition duration-200 ease-in-out bg-gray-900 rounded shadow-inner hover:text-gray-300 hover:bg-gray-800 active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500">+</button>
                    </div>
                </form>
            </div>

            <div class="flex flex-wrap items-start justify-start">
                <div
                    class="p-4 mx-2 mb-4 font-mono border border-gray-900 rounded"
                    v-for="id in form.event_ids"
                    v-bind:key="id"
                >
                    {{ events[id] }} ({{ id }})

                    <button @click.prevent="removeEvent(id)" class="flex items-center px-4 py-2 text-sm font-semibold text-red-500 transition duration-200 ease-in-out bg-gray-900 rounded shadow-inner hover:text-gray-300 hover:bg-gray-800 active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500">x</button>
                </div>

                <form @submit.prevent="assocEvent">
                    <div class="flex items-end justify-start">
                        <form-select label="Add the following event" v-model="current_event_id" class="flex-grow" :options="events" />
                        <button type="submit" class="flex items-center px-4 py-2 text-sm font-semibold text-gray-500 transition duration-200 ease-in-out bg-gray-900 rounded shadow-inner hover:text-gray-300 hover:bg-gray-800 active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500">+</button>
                    </div>
                </form>
            </div>

            <button class="flex items-center px-4 py-2 text-sm font-semibold text-gray-500 transition duration-200 ease-in-out bg-gray-900 rounded shadow-inner hover:text-gray-300 hover:bg-gray-800 active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500">
                Edit
            </button>
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
            assocAlbum(){
                if (!_.find(this.form.album_ids, (elem) => elem == this.current_album_id))
                    this.form.album_ids.push(this.current_album_id)
                this.current_album_id = ''
            },
            assocEvent(){
                if (!_.find(this.form.event_ids, (elem) => elem == this.current_event_id))
                    this.form.event_ids.push(this.current_event_id)
                this.current_event_id = ''
            },
            removeAlbum(id){
                this.form.album_ids = _.reject(this.form.album_ids, (elem) => elem == id)
            },
            removeEvent(id){
                this.form.event_ids = _.reject(this.form.event_ids, (elem) => elem == id)
            }
        }
    }
</script>
