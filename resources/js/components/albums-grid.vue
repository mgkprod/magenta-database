<template>
    <div class="flex flex-wrap items-start justify-start -m-4">
        <div
            v-for="album in albums"
            v-bind:key="album.id"
            class="flex flex-col m-4 transition duration-200 ease-in-out transform rounded shadow-md cursor-pointer w-52 justify-left bg-gray-darker hover:bg-gray-dark hover:shadow-lg hover:scale-105"
            @click="$inertia.get(route('albums.show', album))"
        >
            <div
                class="bg-cover rounded-t aspect-w-1 aspect-h-1"
                :style="{'background-image': 'url(\'' + (album.image_url || '/images/header.jpg') + '\')' }"
            >
            </div>
            <div class="px-4 py-2">
                <div>
                    {{ album.name }}
                </div>
                <div class="text-sm text-gray-400">
                    {{ moment(album.released_at).format('YYYY') }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            albums: Object
        }
    }
</script>
