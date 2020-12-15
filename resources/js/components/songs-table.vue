<template>
    <div class="flex flex-col">
        <div class="flex flex-row px-2 py-2 mb-2 border-b border-gray-darker">
            <div class="w-8 mx-2 text-xs text-center uppercase text-gray-default"></div>
            <div class="flex-auto mx-2 text-xs text-left uppercase text-gray-default">Titre</div>
            <div class="w-32 mx-2 text-xs text-left uppercase text-gray-default">Version</div>
            <div class="w-32 mx-2 text-xs text-left uppercase text-gray-default">Disponibilité</div>
            <div class="w-32 mx-2 text-xs text-left uppercase text-gray-default">Première diff.</div>
        </div>
        <div
            v-for="song in songs"
            v-bind:key="song.id"
            class="flex flex-row items-center px-2 py-3 mb-2 transition-all duration-200 ease-in-out rounded cursor-pointer hover:bg-gray-darker"
            @click="$inertia.get(route('songs.show', song))"
        >
            <div class="w-8 mx-2 text-center transition-all duration-200 ease-in-out text-gray-dark hover:text-gray-default" @click.prevent="">
                <!-- <i class="text-xs fas fa-play"></i> -->
            </div>
            <div class="flex-auto mx-2">
                {{ song.title }}<br>
                <span class="text-gray-default">{{ song.artist }}</span>
            </div>
            <div class="w-32 mx-2 text-left text-gray-default">
                <span v-if="song.type == 'original'">Originale</span>
                <span v-if="song.type == 'remix'">Remix</span>
                <span v-if="song.type == 'live'">Live</span>
                <span v-if="song.type == 'concert'">Concert</span>
            </div>
            <div class="w-32 mx-2 text-left text-gray-default">
                <span v-if="song.availability == 'unreleased'">Inédit</span>
                <span v-if="song.availability == 'announced'">Annoncé</span>
                <span v-if="song.availability == 'published'">Publié</span>
            </div>
            <div class="w-32 mx-2 text-left text-gray-default">
                {{ moment(song.first_time_played_at).format('L') }}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['songs']
    }
</script>
