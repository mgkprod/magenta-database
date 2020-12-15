<template>
    <div class="p-8">
        <form @submit.prevent="submit">
            <form-input class="mb-6"
                label="Name"
                v-model="form.source"
                :errors="$page.props.errors.source"
            />

            <form-file-input class="mb-6"
                label="Audio"
                type="file"
                v-model="form.audio"
                accept="audio/*"
                :errors="$page.props.errors.audio"
            />

            <button class="flex items-center px-4 py-2 text-sm font-semibold text-gray-500 transition duration-200 ease-in-out bg-gray-900 rounded shadow-inner hover:text-gray-300 hover:bg-gray-800 active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500">
                Upload
            </button>
        </form>
    </div>
</template>

<script>
    export default {
        layout: require('../../../layouts/app').default,

        props: {
            song: Object,
        },

        data() {
            return {
                form: {
                    source: '',
                    audio: undefined,
                }
            }
        },

        methods: {
            submit() {
                this.$page.props.errors = {}

                var data = new FormData()
                data.append('source', this.form.source || '')
                data.append('audio', this.form.audio || '')

                this.$inertia.post(
                    this.route('songs.files.store', this.song),
                    data
                )
            }
        }
    }
</script>
