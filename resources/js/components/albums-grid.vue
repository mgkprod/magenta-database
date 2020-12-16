<template>
    <div class="flex flex-wrap items-start justify-start -m-4">
        <div
            v-for="album in albums"
            v-bind:key="album.id"
            class="flex flex-col m-4 transition duration-200 ease-in-out transform rounded shadow-md cursor-pointer w-52 justify-left bg-gray-darker hover:bg-gray-dark hover:shadow-lg hover:scale-105"
            @click="$inertia.get(route('albums.show', album))"
        >
            <vue-load-image class="bg-black bg-opacity-50 rounded-t aspect-w-1 aspect-h-1">
                <img slot="image" :src="album.image_url" class="object-cover w-full h-full rounded-t" />
                <div class="flex items-center justify-center" slot="preloader"><i class="fas fa-spin fa-spinner text-gray-default"></i></div>
            </vue-load-image>

            <div class="px-4 py-3">
                <div class="break-all truncate">{{ album.name }}</div>
                <div>
                    <span class="text-sm text-gray-default">{{ album.artist }}</span>
                    <span class="text-gray-dark">&bull;</span>
                    <span class="text-sm text-gray-default">{{ moment(album.released_at).format('YYYY') }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VueLoadImage from 'vue-load-image'

    export default {
        props: ['albums'],

        components: {
            VueLoadImage
        }
    }
</script>
