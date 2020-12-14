<template>
    <div class="flex flex-wrap items-start justify-start -m-4">
        <div
            v-for="event in events"
            v-bind:key="event.id"
            class="flex flex-col m-4 transition duration-200 ease-in-out transform rounded shadow-md cursor-pointer w-52 justify-left bg-gray-darker hover:bg-gray-dark hover:shadow-lg hover:scale-105"
            @click="$inertia.get(route('events.show', event))"
        >
            <div
                class="bg-cover rounded-t aspect-w-16 aspect-h-9"
                :style="{'background-image': 'url(\'' + (event.image_url || '/images/header.jpg') + '\')' }"
            >
            </div>
            <div class="p-3">
                <div>
                    {{ event.name }}
                </div>
                <div class="text-sm text-gray-400">
                    {{ moment(event.happened_at).format('MM/YYYY') }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['events']
    }
</script>
