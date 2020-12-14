<template>
    <div>
        <div class="mb-8" v-if="$page.props.user">
            <inertia-link
                class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-500 transition duration-200 ease-in-out bg-gray-900 rounded shadow-inner hover:text-gray-300 hover:bg-gray-800 active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500"
                :href="route('songs.edit', song)"
            >
                Edit
            </inertia-link>

            <inertia-link
                class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-500 transition duration-200 ease-in-out bg-gray-900 rounded shadow-inner hover:text-gray-300 hover:bg-gray-800 active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500"
                :href="route('songs.edit-relations', song)"
            >
                Rel
            </inertia-link>

            <inertia-link
                class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-500 transition duration-200 ease-in-out bg-gray-900 rounded shadow-inner hover:text-gray-300 hover:bg-gray-800 active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500"
                :href="route('songs.files.create', song)"
            >
                Add file
            </inertia-link>

            <button
                class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-500 transition duration-200 ease-in-out bg-gray-900 rounded shadow-inner hover:text-gray-300 hover:bg-gray-800 active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500"
                @click="destroy()"
            >
                Delete
            </button>
        </div>

        <div class="flex flex-col lg:flex-row">
            <div class="w-full mb-8 lg:w-1/3">
                <div class="text-xl font-semibold">{{ song.title }}</div>
                <div v-if="song.alt_title" class="text-gray-400">Titre alternatif : {{ song.alt_title }}</div>
                <div class="text-gray-400">
                    Version :
                    <span v-if="song.type == 'original'">Originale</span>
                    <span v-if="song.type == 'remix'">Remix</span>
                    <span v-if="song.type == 'live'">Live</span>
                    <span v-if="song.type == 'concert'">Concert</span>
                </div>
                <div class="text-gray-400">
                    Disponibilité :
                    <span v-if="song.availability == 'unreleased'">Inédit</span>
                    <span v-if="song.availability == 'announced'">Annoncé</span>
                    <span v-if="song.availability == 'published'">Publié</span>
                </div>
                <div class="text-gray-400">Première diff le : {{ moment(song.first_time_played_at).format('L') }}</div>
                <div class="text-gray-400">
                    Date de sortie :
                    <span v-if="song.released_at">{{ moment(song.released_at).format('L') }}</span>
                    <span v-else>N/A</span>
                </div>
                <div class="text-gray-400">Ajouté le : {{ moment(song.created_at).format('L') }}</div>

                <div class="w-full mt-4 whitespace-pre-wrap" v-if="song.details">
                    <vue-simple-markdown :source="song.details"></vue-simple-markdown>
                </div>
            </div>

            <div class="w-full lg:mb-0 lg:ml-8 lg:w-2/3">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        layout: require('../../layouts/app').default,

        props: {
            song: Object,
        },

        methods: {
            destroy() {
                this.$inertia.delete(
                    this.route('songs.destroy', this.song)
                );
            }
        }
    }
</script>
