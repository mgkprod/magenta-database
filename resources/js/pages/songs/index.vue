<template>
    <div>
        <div class="flex flex-row justify-end w-full px-4 py-4 bg-black" v-if="$page.props.user">
            <inertia-link
                class="inline-flex items-center px-4 py-1 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-darker text-gray-default hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500"
                :href="route('songs.create')"
            >
                <i class="mr-2 opacity-50 fas fa-plus"></i> Add
            </inertia-link>
        </div>

        <div class="p-8">
            <songs-table :songs="songs"></songs-table>
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
