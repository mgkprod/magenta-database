<template>
    <div>
        <div class="flex flex-row justify-end w-full px-4 py-4 bg-black border-b-4 border-gray-darker" v-if="$page.props.user">
            <inertia-link
                class="inline-flex items-center px-4 py-1 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-darker text-gray-default hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500"
                :href="route('albums.edit', album)"
            >
                <i class="mr-2 opacity-50 fas fa-edit"></i> Edit
            </inertia-link>

            <button
                class="inline-flex items-center px-4 py-1 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-darker text-gray-default hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500"
                @click="destroy()"
            >
                <i class="mr-2 opacity-50 fas fa-trash"></i>  Delete
            </button>
        </div>

        <div class="relative flex flex-row items-start justify-start p-8 border-b-4 border-gray-darker">
            <div class="bg-cover-container">
                <div class="bg-cover" :style="{ 'background-image': 'url(' + album.image_url + ')' }"></div>
            </div>

            <div class="flex-none w-64 mr-8">
                <vue-load-image class="bg-black bg-opacity-50 rounded-t shadow-xl aspect-w-1 aspect-h-1">
                    <img slot="image" :src="album.image_url" class="object-cover w-full h-full" />
                    <div class="flex items-center justify-center" slot="preloader"><i class="fas fa-spin fa-spinner text-gray-default"></i></div>
                </vue-load-image>
            </div>

            <div>
                <div class="mb-2 text-xs uppercase text-gray-default">{{ album.type }}</div>
                <h1 class="mb-4 text-4xl font-semibold">
                    {{ album.name }}
                    <div class="text-xl">{{ album.artist }}</div>
                </h1>
                <div class="text-gray-default">
                    Disponibilité :
                    <span v-if="album.availability == 'published'">Publié</span>
                    <span v-if="album.availability == 'unreleased'">Inédit</span>
                    <span v-if="album.availability == 'deleted'">Supprimé</span>
                </div>
                <div class="text-gray-default">
                    Année de sortie :
                    <span v-if="album.released_at">{{ moment(album.released_at).format('YYYY') }}</span>
                    <span v-else>N/A</span>
                </div>
                <div class="text-gray-default">Ajouté le : {{ moment(album.created_at).format('L') }}</div>

                <div class="w-full mt-4 whitespace-pre-wrap" v-if="album.details">
                    <vue-simple-markdown :source="album.details"></vue-simple-markdown>
                </div>

                <div class="mt-8">
                    <div class="inline-flex items-center px-4 py-1 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded cursor-pointer bg-gray-darker text-gray-default hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500" @click="play()">
                        <i class="mr-2 text-xs opacity-50 fas fa-play"></i>
                        <span>Écouter</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full p-8 pb-0">
            <songs-table :songs="album.songs"></songs-table>
        </div>
    </div>
</template>

<script>
    import VueLoadImage from 'vue-load-image'
    import { EventBus } from '../../event-bus.js';

    export default {
        layout: require('../../layouts/app').default,

        components: {
            VueLoadImage
        },

        props: {
            album: Object,
        },

        methods: {
            destroy() {
                this.$inertia.delete(
                    this.route('albums.destroy', this.album)
                );
            },
            play(){
                EventBus.$emit('play:album', {
                    album: this.album
                });
            }
        }
    }
</script>
