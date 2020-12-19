<template>
    <div>
        <div class="flex flex-row justify-end w-full px-4 py-4 bg-black border-b-4 border-gray-darker" v-if="$page.props.user">
            <inertia-link
                class="inline-flex items-center px-4 py-1 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-darker text-gray-default hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500"
                :href="route('events.files.create', event)"
            >
                <i class="mr-2 opacity-50 fas fa-folder-open"></i> Add file
            </inertia-link>

            <inertia-link
                class="inline-flex items-center px-4 py-1 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-darker text-gray-default hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500"
                :href="route('events.edit', event)"
            >
                <i class="mr-2 opacity-50 fas fa-edit"></i> Edit
            </inertia-link>

            <button
                class="inline-flex items-center px-4 py-1 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-darker text-gray-default hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500"
                @click="destroy()"
            >
                <i class="mr-2 opacity-50 fas fa-trash"></i>  Delete
            </button>
        </div>

        <div class="relative flex flex-col items-start justify-start p-8 border-b-4 sm:flex-row border-gray-darker">
            <div class="bg-cover-container">
                <div class="bg-cover bg-gradient-to-br from-black to-black" :style="{ '--tw-gradient-from': event.image_dominant_color }"></div>
            </div>

            <div class="flex-none mb-8 w-72 sm:w-48 lg:w-72 sm:mb-0 sm:mr-8">
                <vue-load-image class="shadow-xl aspect-w-16 aspect-h-9">
                    <img slot="image" :src="event.image_url" class="object-cover w-full h-full animate__animated animate__fadeIn animate__fastest" />
                    <div class="flex items-center justify-center opacity-50" :style="{ 'background-color': event.image_dominant_color }" slot="preloader"><i class="text-white fas fa-spin fa-spinner"></i></div>
                </vue-load-image>
            </div>

            <div>
                <div class="mb-2 text-xs uppercase text-gray-default">Event</div>
                <h1 class="mb-4 text-4xl font-semibold">{{ event.name }}</h1>
                <div class="text-gray-default">
                    Date :
                    <span v-if="event.happened_at">{{ moment(event.happened_at).format('L') }}</span>
                    <span v-else>N/A</span>
                </div>
                <div class="text-gray-default">Ajouté le : {{ moment(event.created_at).format('L') }}</div>

                <div class="w-full mt-4 whitespace-pre-wrap" v-if="event.details">
                    <vue-simple-markdown :source="event.details"></vue-simple-markdown>
                </div>

                <div class="mt-8">
                    <div class="inline-flex items-center px-4 py-1 text-sm font-semibold transition duration-200 ease-in-out rounded cursor-pointer bg-gray-darker text-gray-default hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500" @click="play()">
                        <i class="mr-2 text-xs opacity-50 fas fa-play"></i>
                        <span>Écouter</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full p-4 pb-0 md:p-8">
            <songs-table class="mb-8" :songs="event.songs"></songs-table>

            <template v-if="files && files.length">
                <h2 class="mb-4 text-xl font-semibold">Fichiers</h2>
                <files-table class="mb-8" :files="files"></files-table>
            </template>
        </div>
    </div>
</template>

<script>
    import VueLoadImage from 'vue-load-image'
    import { EventBus } from '../../event-bus.js';

    export default {
        layout: require('../../layouts/app').default,

        components: {
            VueLoadImage
        },

        props: ['event', 'files'],

        methods: {
            destroy() {
                this.$inertia.delete(
                    this.route('events.destroy', this.event)
                );
            },
            play(){
                EventBus.$emit('play:event', {
                    event: this.event
                });
            }
        }
    }
</script>
