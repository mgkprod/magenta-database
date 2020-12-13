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

        <img :src="event.image_url" :alt="event.name" class="w-64">

        {{ event.name }}
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
