<template>
    <div class="flex flex-col w-full min-h-screen mx-auto">
        <header class="fixed top-0 left-0 right-0 z-30 flex items-center flex-none h-40 bg-black border-b border-gray-900">
            <div class="container max-w-screen-lg">
                <nav class="flex flex-col items-center w-full -mx-1">
                    <inertia-link :href="route('index')" class="inline-flex items-center mx-1 mr-4 text-lg font-bold tracking-tight transition-all duration-200 ease-in-out hover-contrast">
                        <img src="/images/logo.svg" alt="Logo" class="h-16 mb-4">
                    </inertia-link>

                    <div class="flex flex-row -mx-1">
                        <inertia-link
                            class="flex items-center px-4 py-2 mx-1 text-sm font-semibold text-gray-500 transition duration-200 ease-in-out bg-gray-900 rounded shadow-inner hover:text-pink-300 hover:bg-pink-900 active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-pink-500"
                            :class="{ 'text-pink-300 bg-pink-900': route().current('songs*') }"
                            :href="route('songs.index')"
                        >
                            <span class="tracking-tighter uppercase font-eurostile-extended">Tracks</span>
                        </inertia-link>

                        <inertia-link
                            class="flex items-center px-4 py-2 mx-1 text-sm font-semibold text-gray-500 transition duration-200 ease-in-out bg-gray-900 rounded shadow-inner hover:text-blue-300 hover:bg-blue-900 active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-blue-500"
                            :class="{ 'text-blue-300 bg-blue-900': route().current('albums*') }"
                            :href="route('albums.index')"
                        >
                            <span class="tracking-tighter uppercase font-eurostile-extended">Albums/EPs</span>
                        </inertia-link>

                        <inertia-link
                            class="flex items-center px-4 py-2 mx-1 text-sm font-semibold text-gray-500 transition duration-200 ease-in-out bg-gray-900 rounded shadow-inner hover:text-yellow-300 hover:bg-yellow-900 active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-yellow-500"
                            :class="{ 'text-yellow-300 bg-yellow-900': route().current('events*') }"
                            :href="route('events.index')"
                        >
                            <span class="tracking-tighter uppercase font-eurostile-extended">Events</span>
                        </inertia-link>
                    </div>
                </nav>
            </div>
        </header>

        <main class="flex flex-col flex-auto max-w-full py-8 mt-40">
            <main class="container max-w-screen-lg">
                <slot></slot>
            </main>
        </main>

        <footer class="flex flex-col">
            <div v-if="player.show" class="container flex flex-row items-center justify-start max-w-screen-lg py-4 mb-8 border border-gray-900 rounded">
                <button
                    @click="pause()"
                    class="flex items-center justify-center w-32 px-4 py-2 mx-1 text-sm font-semibold text-gray-500 transition duration-200 ease-in-out bg-gray-900 rounded shadow-inner hover:text-blue-300 hover:bg-blue-900 active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-blue-500"
                >
                    <span class="tracking-tighter uppercase font-eurostile-extended">
                        <span v-if="this.player.is_playing">Pause</span>
                        <span v-if="!this.player.is_playing">Play</span>
                    </span>
                </button>

                <div class="ml-4">
                    {{ this.player.song.title }}
                </div>
            </div>
            <div class="container flex flex-row items-center justify-between max-w-screen-lg py-4 text-xs bg-black">
                <div>
                    Les contenus présentés appartiennent à leurs auteurs respectifs.<br>
                    Handcrafted with ❤️ by <a href="https://mgk.dev" target="_blank" class="text-gray-300 transition duration-200 ease-in-out hover:text-gray-200">Simon (MGK)</a>
                </div>

                <div class="mx-auto"></div>

                <div class="text-right">
                    {{ $page.props.version }}<br>
                    <inertia-link :href="route('login')" class="text-gray-300 transition duration-200 ease-in-out hover:text-gray-200">Management</inertia-link>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
    import { Howl, Howler } from 'howler';
    import { EventBus } from '../event-bus.js';

    export default {
        data() {
            return {
                player: {
                    show: false,
                    is_playing: false,
                    howl: undefined,
                    song: undefined,
                    media: undefined,
                }
            }
        },

        mounted(){
            EventBus.$on('play:media', payload => this.play(payload));
        },

        methods: {
            play(payload){
                if (this.player.howl) {
                    this.player.howl.unload();
                }

                this.player.song = payload.song;
                this.player.media = payload.media;

                this.player.howl = new Howl({
                    src: [this.player.media.url],
                    autoplay: true,
                    loop: true,
                    volume: 0.5,
                    onplay: () => { this.player.is_playing = true },
                    onpause: () => { this.player.is_playing = false },
                    onend: () => { this.player.is_playing = false },
                    onstop: () => { this.player.is_playing = false },
                });

                this.player.show = true;
                this.player.is_playing = true;
            },
            pause(){
                this.player.howl.playing()
                    ? this.player.howl.pause()
                    : this.player.howl.play()
            }
        }
    }
</script>
