<template>
    <div class="p-4 md:p-8">
        <form @submit.prevent="submit">
            <form-input class="mb-6"
                label="Title"
                v-model="form.title"
                :errors="$page.props.errors.title"
            />

            <form-input class="mb-6"
                label="Alternative title"
                v-model="form.alt_title"
                :errors="$page.props.errors.alt_title"
            />

            <form-input class="mb-6"
                label="Artist"
                v-model="form.artist"
                :errors="$page.props.errors.artist"
            />

            <form-select class="mb-6"
                label="Type"
                v-model="form.type"
                :errors="$page.props.errors.type"
                :options="types"
            />

            <form-select class="mb-6"
                label="Availability"
                v-model="form.availability"
                :errors="$page.props.errors.availability"
                :options="availabilities"
            />

            <form-input class="mb-6"
                label="Released at"
                v-model="form.released_at"
                :errors="$page.props.errors.released_at"
            />

            <form-input class="mb-6"
                label="First time played at"
                v-model="form.first_time_played_at"
                :errors="$page.props.errors.first_time_played_at"
            />

            <form-input class="mb-6"
                label="Variant aggregate"
                v-model="form.variant_agg"
                :errors="$page.props.errors.variant_agg"
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

            <form-checkbox class="mb-4" label="Downloadable?" name="is_downloadable" v-model="form.is_downloadable"  :errors="$page.props.errors.is_downloadable" />

            <div class="flex justify-end">
                <button class="inline-flex items-center px-4 py-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500">
                    <i class="mr-2 opacity-50 fas fa-edit"></i> Edit
                </button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        layout: require('../../layouts/app').default,

        props: {
            song: Object,
            availabilities: Object,
            types: Object,
        },

        data() {
            return {
                form: {
                    title: '',
                    alt_title: '',
                    artist: '',
                    type: '',
                    availability: '',
                    released_at: '',
                    first_time_played_at: '',
                    variant_agg: '',
                    details: '',
                    image: undefined,
                    is_downloadable: false,
                }
            }
        },

        mounted() {
            this.form = { ...this.song };

            this.form.released_at = this.moment(this.song.released_at).format('YYYY-MM-DD');
            this.form.first_time_played_at = this.moment(this.song.first_time_played_at).format('YYYY-MM-DD');
        },

        methods: {
            submit() {
                this.$page.props.errors = {}

                var data = new FormData()
                data.append('_method', 'put')
                data.append('title', this.form.title || '')
                data.append('alt_title', this.form.alt_title || '')
                data.append('artist', this.form.artist || '')
                data.append('type', this.form.type || '')
                data.append('availability', this.form.availability || '')
                data.append('released_at', this.form.released_at || '')
                data.append('first_time_played_at', this.form.first_time_played_at || '')
                data.append('variant_agg', this.form.variant_agg || '')
                data.append('details', this.form.details || '')
                data.append('image', this.form.image || '')
                data.append('is_downloadable', this.form.is_downloadable || false)

                this.$inertia.post(
                    this.route('songs.update', this.song),
                    data
                )
            }
        }
    }
</script>
