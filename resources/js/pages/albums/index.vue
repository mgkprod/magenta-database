<template>
    <div>
        <div class="mb-8" v-if="$page.props.user">
            <inertia-link
                class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-500 transition duration-200 ease-in-out bg-gray-900 rounded shadow-inner hover:text-gray-300 hover:bg-gray-800 active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500"
                :href="route('albums.create')"
            >
                Add
            </inertia-link>
        </div>

        <div class="flex flex-wrap items-start justify-start -m-4">
            <div
                v-for="album in albums"
                v-bind:key="album.id"
                class="flex flex-col items-center justify-center w-48 h-48 m-4 transition duration-200 ease-in-out transform bg-cover border border-gray-900 rounded shadow-inner cursor-pointer lg:w-56 lg:h-56 hover:rotate-1 hover:scale-105"
                :style="{'background-image': 'url(/images/header.jpg)' }"
                @click="$inertia.get(route('albums.show', album))"
            >
                <div class="text-sm font-bold lg:text-base">{{ album.name }}</div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        layout: require('../../layouts/app').default,

        props: {
            albums: Array
        }
    }
</script>
