<template>
    <div>
        <div class="mb-8" v-if="$page.props.user">
            <inertia-link
                class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-500 transition duration-200 ease-in-out bg-gray-900 rounded shadow-inner hover:text-gray-300 hover:bg-gray-800 active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500"
                :href="route('songs.create')"
            >
                Add
            </inertia-link>
        </div>

        <div class="flex flex-col border border-b-0 border-gray-900 rounded">
            <div class="flex flex-col px-4 py-4 -mx-2 border-b border-gray-900 sm:flex-row">
                <div class="flex-auto mx-2 text-sm font-bold text-left">Titre</div>
                <div class="w-32 mx-2 font-bold text-left sm:text-sm sm:text-center">Version</div>
                <div class="w-32 mx-2 font-bold text-left sm:text-sm sm:text-center">Dispo.</div>
                <div class="w-48 mx-2 font-bold text-left sm:text-sm sm:text-center">Première diff.</div>
            </div>
            <div
                v-for="song in songs"
                v-bind:key="song.id"
                class="flex flex-col px-4 py-4 -mx-2 transition-all duration-200 ease-in-out border-b border-gray-900 sm:flex-row hover:bg-gray-900"
                @click="$inertia.get(route('songs.show', song))"
            >
                <div class="flex-auto mx-2 font-bold">
                    {{ song.title }}
                </div>
                <div class="mx-2 text-left sm:w-32 sm:text-center">
                    <span v-if="song.type == 'original'">Originale</span>
                    <span v-if="song.type == 'remix'">Remix</span>
                    <span v-if="song.type == 'live'">Live</span>
                    <span v-if="song.type == 'concert'">Concert</span>
                </div>
                <div class="mx-2 text-left sm:w-32 sm:text-center">
                    <span v-if="song.availability == 'unreleased'">Inédit</span>
                    <span v-if="song.availability == 'announced'">Annoncé</span>
                    <span v-if="song.availability == 'published'">Publié</span>
                </div>
                <div class="mx-2 text-left sm:w-48 sm:text-center">
                    {{ moment(song.first_time_played_at).format('L') }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        layout: require('../../layouts/app').default,

        props: {
            songs: Array
        }
    }
</script>
