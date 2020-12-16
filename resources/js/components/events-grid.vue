<template>
    <div class="flex flex-wrap items-start justify-start -m-4">
        <div
            v-for="event in events"
            v-bind:key="event.id"
            class="flex flex-col w-64 m-4 transition duration-200 ease-in-out transform rounded shadow-md cursor-pointer justify-left bg-gray-darker hover:bg-gray-dark hover:shadow-lg hover:scale-105"
            @click="$inertia.get(route('events.show', event))"
        >
            <vue-load-image class="bg-black bg-opacity-50 rounded-t aspect-w-16 aspect-h-9">
                <img slot="image" :src="event.image_url" class="object-cover w-full h-full rounded-t animate__animated animate__fadeIn animate__fastest" />
                <div class="flex items-center justify-center rounded-t opacity-50" :style="{ 'background-color': event.image_dominant_color }" slot="preloader"><i class="text-white fas fa-spin fa-spinner"></i></div>
            </vue-load-image>

            <div class="px-4 py-3">
                <div class="break-all truncate">
                    {{ event.name }}
                </div>
                <div class="text-sm text-gray-default">
                    {{ moment(event.happened_at).format('MM/YYYY') }}
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
