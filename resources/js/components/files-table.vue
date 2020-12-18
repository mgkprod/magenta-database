<template>
    <div class="flex flex-col">
        <div class="flex flex-row px-2 py-2 mb-2 border-b border-gray-darker">
            <div class="flex-auto mx-2 text-xs text-left uppercase text-gray-default">Nom</div>
            <div class="w-20 mx-2 text-xs text-left uppercase text-gray-default">Taille</div>
            <div class="w-32 mx-2 text-xs text-left uppercase text-gray-default">Ajouté</div>
            <div class="w-10 mx-2 text-xs text-center uppercase text-gray-default"></div>
        </div>

        <div
            v-for="file in files"
            v-bind:key="file.id"
            class="flex flex-row items-center px-2 py-3 mb-2 transition-all duration-200 ease-in-out rounded hover:bg-gray-darker"
        >
            <div class="flex-auto mx-2 text-left">
                <span v-if="file.custom_properties.name">{{ file.custom_properties.name }}</span>
                <span v-else>{{ file.name }}</span>
            </div>
            <div class="w-20 mx-2 text-left text-gray-default">
                {{ getReadableFileSizeString(file.size) }}
            </div>
            <div class="w-32 mx-2 text-left text-gray-default">
                {{ moment(file.created_at).format('L') }}
            </div>
            <div class="w-10 mx-2 text-center text-gray-dark">
                <a class="transition-all duration-200 ease-in-out hover:text-gray-default" :href="file.url" target="_blank">
                    <i class="text-xs fas fa-arrow-down"></i>
                </a>
                <button v-if="$page.props.user" class="ml-2 transition-all duration-200 ease-in-out hover:text-gray-default" @click="destroy(file)">
                    <i class="text-xs fas fa-trash"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['files'],

        methods: {
            destroy(file) {
                this.$inertia.delete(
                    this.route('files.destroy', { file })
                );
            },
            getReadableFileSizeString(fileSizeInBytes) {
                var i = -1;
                var byteUnits = [' kB', ' MB', ' GB', ' TB', 'PB', 'EB', 'ZB', 'YB'];
                do {
                    fileSizeInBytes = fileSizeInBytes / 1024;
                    i++;
                } while (fileSizeInBytes > 1024);

                return Math.max(fileSizeInBytes, 0.1).toFixed(1) + byteUnits[i];
            }
        }
    }
</script>
