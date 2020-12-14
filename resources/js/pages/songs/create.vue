<template>
    <div class="p-8">
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

            <button class="flex items-center px-4 py-2 text-sm font-semibold text-gray-500 transition duration-200 ease-in-out bg-gray-900 rounded shadow-inner hover:text-gray-300 hover:bg-gray-800 active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500">
                Add
            </button>
        </form>
    </div>
</template>

<script>
    export default {
        layout: require('../../layouts/app').default,

        props: {
            availabilities: Object,
            types: Object,
        },

        data() {
            return {
                form: {
                    title: '',
                    alt_title: '',
                    type: '',
                    availability: '',
                    released_at: '',
                    first_time_played_at: '',
                    variant_agg: '',
                    details: '',
                }
            }
        },

        methods: {
            submit() {
                this.$page.props.errors = {}

                this.$inertia.post(
                    this.route('songs.store'), { ...this.form }
                )
            }
        }
    }
</script>
