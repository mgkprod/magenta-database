<template>
    <label class="block mb-6">
        <span v-if="label" class="block mb-2 text-sm font-semibold text-gray-dark dark:text-gray-default" v-text="label"></span>

        <div :class="{ error: errors.length }">
            <input ref="file" type="file" :accept="accept" class="hidden" @change="change">
            <div v-if="!value">
                <button type="button" class="inline-flex items-center px-4 py-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500" @click="browse">
                    <i class="mr-2 opacity-50 fas fa-file"></i> Browse
                </button>
            </div>
            <div v-else class="flex items-center justify-between">
                <div class="flex-none truncate">
                    <div class="truncate">
                        {{ value.name }} ({{ get_readable_file_size_string(value.size) }})
                    </div>
                </div>
                <button type="button" class="inline-flex items-center px-4 py-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500" @click.stop="remove">
                    Remove
                </button>
            </div>
        </div>

        <p v-if="errors.length" class="pl-1 text-xs font-semibold text-red-500" v-text="errors[0]"></p>
    </label>
</template>

<script>
    export default {
        inheritAttrs: false,

        props: {
            value: File,
            label: String,
            accept: String,
            errors: {
            type: Array,
            default: () => [],
            },
        },

        watch: {
            value(value) {
                if (!value) {
                    this.$refs.file.value = ''
                }
            },
        },

        methods: {
            get_readable_file_size_string(file_size_in_bytes) {
                var i = -1;
                var byte_units = [' kB', ' MB', ' GB', ' TB', 'PB', 'EB', 'ZB', 'YB'];
                do {
                    file_size_in_bytes = file_size_in_bytes / 1024;
                    i++;
                } while (file_size_in_bytes > 1024);

                return Math.max(file_size_in_bytes, 0.1).toFixed(1) + byte_units[i];
            },
            browse() {
                this.$refs.file.click()
            },
            change(e) {
                this.$emit('input', e.target.files[0])
            },
            remove() {
                this.$emit('input', null)
            },
        },
    }
</script>
