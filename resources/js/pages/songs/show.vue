<template>
    <div>
        <div class="flex flex-row justify-end w-full px-4 py-4 bg-black border-b-4 border-gray-darker" v-if="$page.props.user">
            <inertia-link
                class="inline-flex items-center px-4 py-1 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-darker text-gray-default hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500"
                :href="route('songs.edit', song)"
            >
                <i class="mr-2 opacity-50 fas fa-edit"></i> Edit
            </inertia-link>

            <inertia-link
                class="inline-flex items-center px-4 py-1 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-darker text-gray-default hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500"
                :href="route('songs.edit-relations', song)"
            >
                <i class="mr-2 opacity-50 fas fa-link"></i> Relations
            </inertia-link>

            <inertia-link
                class="inline-flex items-center px-4 py-1 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-darker text-gray-default hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500"
                :href="route('songs.files.create', song)"
            >
                <i class="mr-2 opacity-50 fas fa-folder-open"></i> Add file
            </inertia-link>

            <inertia-link
                class="inline-flex items-center px-4 py-1 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-darker text-gray-default hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500"
                :href="route('songs.medias.create', song)"
            >
                <i class="mr-2 opacity-50 fas fa-compact-disc"></i> Add media
            </inertia-link>

            <button
                class="inline-flex items-center px-4 py-1 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-darker text-gray-default hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500"
                @click="destroy()"
            >
                <i class="mr-2 opacity-50 fas fa-trash"></i> Delete
            </button>
        </div>

        <div class="relative flex flex-row items-start justify-start p-8 border-b-4 border-gray-darker">
            <div class="bg-cover-container">
                <div class="bg-cover bg-gradient-to-br from-black to-black" :style="{ '--tw-gradient-from': song.image_dominant_color }"></div>
            </div>

            <div class="flex-none w-64 mr-8">
                <vue-load-image class="shadow-xl aspect-w-1 aspect-h-1">
                    <img slot="image" :src="song.image_url" class="object-cover w-full h-full animate__animated animate__fadeIn animate__fastest" />
                    <div class="flex items-center justify-center opacity-50" :style="{ 'background-color': song.image_dominant_color }" slot="preloader"><i class="text-white fas fa-spin fa-spinner"></i></div>
                </vue-load-image>
            </div>

            <div>
                <div class="mb-2 text-xs uppercase text-gray-default">Track</div>
                <h1 class="mb-4 text-4xl font-semibold">
                    {{ song.title }}
                    <div class="text-xl">{{ song.artist }}</div>
                </h1>
                <div v-if="song.alt_title" class="text-gray-default">Titre alternatif : {{ song.alt_title }}</div>
                <div class="text-gray-default">
                    Version :
                    <span v-if="song.type == 'original'">Originale</span>
                    <span v-if="song.type == 'clip'">Clip</span>
                    <span v-if="song.type == 'remix'">Remix</span>
                    <span v-if="song.type == 'extended-mix'">Extended Mix</span>
                    <span v-if="song.type == 'live-rework'">Live Rework</span>
                    <span v-if="song.type == 'live'">Live</span>
                    <span v-if="song.type == 'radio-edit'">Radio Edit</span>
                    <span v-if="song.type == 'rework'">Rework</span>
                </div>
                <div class="text-gray-default">
                    Disponibilité :
                    <span v-if="song.availability == 'unreleased'">Inédit</span>
                    <span v-if="song.availability == 'deleted'">Supprimé</span>
                    <span v-if="song.availability == 'published'">Publié</span>
                </div>
                <div v-if="song.first_time_played_at" class="text-gray-default">Première diffusion le : {{ moment(song.first_time_played_at).format('L') }}</div>
                <div v-if="song.released_at" class="text-gray-default">
                    Année de sortie :
                    <span v-if="song.released_at">{{ moment(song.released_at).format('YYYY') }}</span>
                    <span v-else>N/A</span>
                </div>
                <div class="text-gray-default">Ajouté le : {{ moment(song.created_at).format('L') }}</div>

                <div class="w-full mt-4 whitespace-pre-wrap" v-if="song.details">
                    <vue-simple-markdown :source="song.details"></vue-simple-markdown>
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
            <div class="flex flex-col mb-8">
                <div class="flex flex-row px-2 py-2 mb-2 border-b border-gray-darker">
                    <div class="w-8 mx-2 text-xs text-center uppercase text-gray-default"></div>
                    <div class="w-64 mx-2 text-xs text-left uppercase text-gray-default">Info</div>
                    <div class="flex-auto mx-2 text-xs text-left uppercase text-gray-default">Source</div>
                    <div class="w-16 mx-2 text-xs text-left uppercase text-gray-default">Durée</div>
                    <div class="w-20 mx-2 text-xs text-left uppercase text-gray-default">Taille</div>
                    <div class="w-32 mx-2 text-xs text-left uppercase text-gray-default">Ajouté</div>
                    <div class="w-10 mx-2 text-xs text-center uppercase text-gray-default"></div>
                </div>

                <div
                    v-for="media in medias"
                    v-bind:key="media.id"
                    class="flex flex-row items-center px-2 py-3 mb-2 transition-all duration-200 ease-in-out rounded hover:bg-gray-darker"
                >
                    <div class="w-8 mx-2 text-center transition-all duration-200 ease-in-out text-gray-dark hover:text-gray-default" @click="play_media(media)">
                        <span v-if="$curr_media_id == media.id">
                            <i class="text-gray-default fas fa-volume-up fa-fw"></i>
                        </span>
                        <span v-else>
                            <i class="text-xs fas fa-fw fa-play"></i>
                        </span>
                    </div>
                    <div class="w-64 mx-2 text-left">
                        {{ media.custom_properties.codec_name }}
                        <div class="text-xs">
                            <span v-if="media.custom_properties.bit_rate">{{ Math.round(media.custom_properties.bit_rate / 1000) }} kbps</span>
                            <span v-else-if="media.custom_properties.bits_per_raw_sample">{{ media.custom_properties.bits_per_raw_sample }} bits</span>
                            <span v-else-if="media.custom_properties.bits_per_sample">{{ media.custom_properties.bits_per_sample }} bits</span>
                            <span class="text-gray-dark">&bull;</span>
                            {{ media.custom_properties.sample_rate / 1000 }} kHz
                            <template v-if="$page.props.user">
                                <span class="text-gray-dark">&bull;</span>
                                {{ media.score }}
                            </template>
                        </div>
                    </div>
                    <div class="flex-auto mx-2 text-left text-gray-default">
                        <span v-if="media.custom_properties.source == 'youtube'"><i class="mr-1 opacity-50 fa-fw fab fa-youtube"></i> YouTube</span>
                        <span v-else-if="media.custom_properties.source == 'soundcloud'"><i class="mr-1 opacity-50 fa-fw fab fa-soundcloud"></i> SoundCloud</span>
                        <span v-else-if="media.custom_properties.source == 'deezer'"><i class="mr-1 opacity-50 fa-fw fab fa-deezer"></i> Deezer</span>
                        <span v-else-if="media.custom_properties.source == 'qobuz'"><i class="mr-1 opacity-50 fa-fw fas fa-compact-disc"></i> Qobuz</span>
                        <span v-else-if="media.custom_properties.source" class="capitalize">{{ media.custom_properties.source }}</span>
                        <span v-else>N/A</span>
                    </div>
                    <div class="w-16 mx-2 text-left text-gray-default">
                        {{ moment.duration(media.custom_properties.duration, 'seconds').format('mm:ss', { trim: false }) }}
                    </div>
                    <div class="w-20 mx-2 text-left text-gray-default">
                        {{ getReadableFileSizeString(media.size) }}
                    </div>
                    <div class="w-32 mx-2 text-left text-gray-default">
                        {{ moment(media.created_at).format('L') }}
                    </div>
                    <div class="w-10 mx-2 text-center text-gray-dark">
                        <a v-if="song.is_downloadable" class="transition-all duration-200 ease-in-out hover:text-gray-default" :href="media.url" target="_blank">
                            <i class="text-xs fas fa-arrow-down"></i>
                        </a>
                        <button v-if="$page.props.user" class="ml-2 transition-all duration-200 ease-in-out hover:text-gray-default" @click="destroy_media(media)">
                            <i class="text-xs fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>

            <template v-if="files && files.length">
                <h2 class="mb-4 text-xl font-semibold">Fichiers</h2>
                <files-table class="mb-8" :files="files"></files-table>
            </template>

            <template v-if="variants">
                <h2 class="mb-4 text-xl font-semibold">Variantes</h2>
                <songs-table class="mb-8" :songs="variants"></songs-table>
            </template>

            <template v-if="song.events.length">
                <h2 class="mb-4 text-xl font-semibold">Diffusions</h2>
                <events-grid class="mb-8" :events="song.events"></events-grid>
            </template>

            <template v-if="song.albums.length">
                <h2 class="mb-4 text-xl font-semibold">Présent dans</h2>
                <albums-grid class="mb-8" :albums="song.albums"></albums-grid>
            </template>
        </div>
    </div>
</template>

<script>
    import { EventBus } from '../../event-bus.js';
    import VueLoadImage from 'vue-load-image'

    export default {
        layout: require('../../layouts/app').default,

        components: {
            VueLoadImage
        },

        props: ['song', 'medias', 'files', 'variants'],

        methods: {
            destroy() {
                this.$inertia.delete(
                    this.route('songs.destroy', this.song)
                );
            },
            destroy_media(media) {
                this.$inertia.delete(
                    this.route('songs.medias.destroy', { song: this.song, media })
                );
            },
            play(){
                EventBus.$emit('play:song', {
                    song: this.song,
                    empty_queue: true,
                });
            },
            play_media(media){
                EventBus.$emit('play:media', {
                    song: this.song,
                    media: media,
                });
            },
            getReadableFileSizeString(fileSizeInBytes) {
                var i = -1;
                var byteUnits = [' kB', ' MB', ' GB', ' TB', 'PB', 'EB', 'ZB', 'YB'];
                do {
                    fileSizeInBytes = fileSizeInBytes / 1024;
                    i++;
                } while (fileSizeInBytes > 1024);

                return Math.max(fileSizeInBytes, 0.1).toFixed(1) + byteUnits[i];
            }
        }
    }
</script>
