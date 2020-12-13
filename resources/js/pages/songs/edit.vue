<template>
    <div>
        <form @submit.prevent="submit">
            <form-input class="mb-6"
                label="Title"
                v-model="form.title"
                :errors="$page.props.errors.title"
                required
            />

            <form-input class="mb-6"
                label="Released at"
                v-model="form.released_at"
                :errors="$page.props.errors.released_at"
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
            song: Object,
        },

        data() {
            return {
                form: {
                    title: '',
                    released_at: '',
                }
            }
        },

        mounted() {
            this.form = { ...this.song };
        },

        methods: {
            submit() {
                this.$page.props.errors = {}

                this.$inertia.put(
                    this.route('songs.update', this.song), { ...this.form }
                )
            }
        }
    }
</script>
