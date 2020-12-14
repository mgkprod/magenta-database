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
                label="Happened at"
                v-model="form.happened_at"
                :errors="$page.props.errors.happened_at"
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
            event: Object,
        },

        data() {
            return {
                form: {
                    name: '',
                    happened_at: '',
                    details: '',
                    image: undefined,
                }
            }
        },

        mounted() {
            this.form.name = this.event.name
            this.form.happened_at = this.event.happened_at
            this.form.details = this.event.details
        },

        methods: {
            submit() {
                this.$page.props.errors = {}

                var data = new FormData()
                data.append('_method', 'put')
                data.append('name', this.form.name || '')
                data.append('happened_at', this.form.happened_at || '')
                data.append('details', this.form.details || '')
                data.append('image', this.form.image || '')

                this.$inertia.post(
                    this.route('events.update', this.event),
                    data
                )
            }
        }
    }
</script>
