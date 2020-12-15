<template>
    <div>
        <div class="p-8">
            <form @submit.prevent="submit" class="mb-8">
                <div class="flex flex-row items-center">
                    <form-input
                        class="flex-auto"
                        v-model="form.q"
                        :errors="$page.props.errors.q"
                        autofocus
                        placeholder="On écoute quoi ?"
                    />

                    <i class="ml-4 text-xs transition-all duration-200 ease-in-out fas fa-search text-gray-dark hover:text-gray-default" @click="submit"></i>
                </div>
            </form>

            <template v-if="q">
                <h2 class="mb-4 text-xl font-semibold">Tracks</h2>
                <songs-table v-if="results.songs && results.songs.length" class="mb-8" :songs="results.songs"></songs-table>
                <div class="mb-8 text-sm text-gray-dark" v-else>Aucun track trouvé</div>

                <h2 class="mb-4 text-xl font-semibold">Albums</h2>
                <albums-grid v-if="results.albums && results.albums.length" class="mb-8" :albums="results.albums"></albums-grid>
                <div class="mb-8 text-sm text-gray-dark" v-else>Aucun album trouvé</div>

                <h2 class="mb-4 text-xl font-semibold">Events</h2>
                <events-grid v-if="results.events && results.events.length" class="mb-8" :events="results.events"></events-grid>
                <div class="mb-8 text-sm text-gray-dark" v-else>Aucun event trouvé</div>
            </template>
        </div>
    </div>
</template>

<script>
    export default {
        layout: require('../../layouts/app').default,

        props: ['results', 'q'],

        data() {
            return {
                form: {
                    q: '',
                }
            }
        },

        mounted() {
            this.form.q = this.q;
        },

        methods: {
            submit() {
                this.$page.props.errors = {}

                this.$inertia.get(
                    this.route('search.index'),
                    this.form
                )
            }
        }
    }
</script>
