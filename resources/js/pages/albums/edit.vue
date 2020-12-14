<template>
    <div class="p-8">
        <form @submit.prevent="submit">
            <form-input class="mb-6"
                label="Name"
                v-model="form.name"
                :errors="$page.props.errors.name"
                required
            />

            <form-input class="mb-6"
                label="Released at"
                v-model="form.released_at"
                :errors="$page.props.errors.released_at"
            />

            <form-select class="mb-6"
                label="Availability"
                v-model="form.availability"
                :errors="$page.props.errors.availability"
                :options="availabilities"
            />

            <form-select class="mb-6"
                label="Type"
                v-model="form.type"
                :errors="$page.props.errors.type"
                :options="types"
            />

            <form-textarea class="mb-6"
                label="Details"
                v-model="form.details"
                :errors="$page.props.errors.details"
                rows="10"
            />

            <form-file-input class="mb-6"
                label="Image"
                type="file"
                v-model="form.image"
                accept="image/*"
                :errors="$page.props.errors.image"
            />

            <button class="flex items-center px-4 py-2 text-sm font-semibold text-gray-500 transition duration-200 ease-in-out bg-gray-900 rounded shadow-inner hover:text-gray-300 hover:bg-gray-800 active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500">
                Edit
            </button>
        </form>
    </div>
</template>

<script>
    export default {
        layout: require('../../layouts/app').default,

        props: {
            album: Object,
            types: Object,
            availabilities: Object,
        },

        data() {
            return {
                form: {
                    name: '',
                    released_at: '',
                    availability: '',
                    type: '',
                    details: '',
                    image: null,
                }
            }
        },

        mounted() {
            this.form.name = this.album.name
            this.form.released_at = this.album.released_at
            this.form.availability = this.album.availability
            this.form.type = this.album.type
            this.form.details = this.album.details
        },

        methods: {
            submit() {
                this.$page.props.errors = {}

                var data = new FormData()
                data.append('_method', 'put')
                data.append('name', this.form.name || '')
                data.append('released_at', this.form.released_at || '')
                data.append('availability', this.form.availability || '')
                data.append('type', this.form.type || '')
                data.append('details', this.form.details || '')
                data.append('image', this.form.image || '')

                this.$inertia.post(
                    this.route('albums.update', this.album),
                    data
                )
            }
        }
    }
</script>
