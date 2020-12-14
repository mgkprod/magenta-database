<template>
    <div>
        <div class="mb-8" v-if="$page.props.user">
            <inertia-link
                class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-500 transition duration-200 ease-in-out bg-gray-900 rounded shadow-inner hover:text-gray-300 hover:bg-gray-800 active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500"
                :href="route('events.edit', event)"
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
                <img v-if="event.image_url" :src="event.image_url" :alt="event.name" class="w-full max-w-md mb-8 border border-gray-900 rounded shadow-inner">
                <div class="text-xl font-semibold">{{ event.name }}</div>
                <div class="text-gray-400">Date : {{ moment(event.happened_at).format('L') }}</div>
                <div class="text-gray-400">Ajouté le : {{ moment(event.created_at).format('L') }}</div>

                <div class="w-full mt-4 whitespace-pre-wrap" v-if="event.details">
                    <vue-simple-markdown :source="event.details"></vue-simple-markdown>
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
            event: Object,
        },

        methods: {
            destroy() {
                this.$inertia.delete(
                    this.route('events.destroy', this.event)
                );
            }
        }
    }
</script>
