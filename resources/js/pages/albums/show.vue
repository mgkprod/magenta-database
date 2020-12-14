<template>
    <div>
        <div class="mb-8" v-if="$page.props.user">
            <inertia-link
                class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-500 transition duration-200 ease-in-out bg-gray-900 rounded shadow-inner hover:text-gray-300 hover:bg-gray-800 active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500"
                :href="route('albums.edit', album)"
            >
                Edit
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
                <img v-if="album.image_url" :src="album.image_url" :alt="album.name" class="w-full max-w-md mb-8 border border-gray-900 rounded shadow-inner">
                <div class="text-xl font-semibold">{{ album.name }}</div>
                <div class="text-gray-400">
                    Disponibilité :
                    <span v-if="album.availability == 'published'">Publié</span>
                    <span v-if="album.availability == 'unreleased'">Inédit</span>
                    <span v-if="album.availability == 'announced'">Annoncé</span>
                </div>
                <div class="text-gray-400">
                    Date de sortie :
                    <span v-if="album.released_at">{{ moment(album.released_at).format('L') }}</span>
                    <span v-else>N/A</span>
                </div>
                <div class="text-gray-400">Ajouté le : {{ moment(album.created_at).format('L') }}</div>

                <div class="w-full mt-4 whitespace-pre-wrap" v-if="album.details">
                    <vue-simple-markdown :source="album.details"></vue-simple-markdown>
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
            album: Object,
        },

        methods: {
            destroy() {
                this.$inertia.delete(
                    this.route('albums.destroy', this.album)
                );
            }
        }
    }
</script>
