<template>
    <div>
        <div class="mb-8" v-if="$page.props.user">
            <inertia-link
                class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-500 transition duration-200 ease-in-out bg-gray-900 rounded shadow-inner hover:text-gray-300 hover:bg-gray-800 active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500"
                :href="route('events.create')"
            >
                Add
            </inertia-link>
        </div>

        <div class="flex flex-wrap items-start justify-start -m-4">
            <div
                v-for="event in events"
                v-bind:key="event.id"
                class="flex flex-col m-4 transition duration-200 ease-in-out transform cursor-pointer justify-left hover:scale-105"
                @click="$inertia.get(route('events.show', event))"
            >
                <div
                    class="w-48 h-24 mb-2 bg-cover border border-gray-900 rounded shadow-inner lg:w-56 lg:h-32 "
                    :style="{'background-image': 'url(\'' + (event.image_url || '/images/header.jpg') + '\')' }"
                >
                </div>
                <div>
                    <div>
                        {{ event.name }}
                    </div>
                    <div class="text-sm text-gray-400">
                        {{ moment(event.happened_at).format('L') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        layout: require('../../layouts/app').default,

        props: {
            events: Array
        }
    }
</script>
