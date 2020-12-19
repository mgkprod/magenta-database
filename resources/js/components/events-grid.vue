<template>
    <div class="flex flex-wrap items-start justify-start -m-2 xl:-m-3">
        <div
            v-for="event in events"
            v-bind:key="event.id"
            class="w-full p-2 xs:w-1/2 sm:w-1/2 lg:w-1/3 xl:p-3 xl:w-64"
            @click="$inertia.get(route('events.show', event))"
        >
            <div class="flex flex-col transition duration-200 ease-in-out transform rounded shadow-md cursor-pointer justify-left bg-gray-lightest dark:bg-gray-darker hover:bg-gray-lighter dark:hover:bg-gray-dark hover:shadow-lg hover:scale-105">
                <vue-load-image class="bg-white bg-opacity-50 rounded-t dark:bg-black aspect-w-16 aspect-h-9">
                    <img slot="image" :src="event.image_url" class="object-cover w-full h-full rounded-t animate__animated animate__fadeIn animate__fastest" />
                    <div class="flex items-center justify-center rounded-t opacity-50" :style="{ 'background-color': event.image_dominant_color }" slot="preloader"><i class="text-black dark:text-white fas fa-spin fa-spinner"></i></div>
                </vue-load-image>

                <div class="px-4 py-3">
                    <div class="break-all truncate">
                        {{ event.name }}
                    </div>
                    <div class="text-sm truncate text-gray-dark dark:text-gray-default">
                        {{ moment(event.happened_at).format('MM/YYYY') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VueLoadImage from 'vue-load-image'

    export default {
        props: ['events'],

        components: {
            VueLoadImage
        }
    }
</script>
