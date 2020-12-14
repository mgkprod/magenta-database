<template>
    <div class="flex flex-col w-full h-screen">
        <div class="flex flex-row flex-auto min-h-0">
            <!-- Sidebar -->
            <div class="flex flex-col w-64 bg-black">
                <div class="my-8">
                    <inertia-link :href="route('index')" class="tracking-tight transition-all duration-200 ease-in-out">
                        <img src="/images/logo.svg" alt="Logo" class="w-full px-2 hover-contrast">
                    </inertia-link>
                </div>

                <inertia-link
                    class="flex items-center px-4 py-3 text-sm font-semibold transition duration-200 ease-in-out border-l-8 border-transparent active:bg-transparent focus:outline-none hover:text-pink-300 hover:bg-pink-900"
                    :class="{ 'border-pink-700 text-pink-300 bg-pink-900': route().current('songs*') }"
                    :href="route('songs.index')"
                >
                    <span class="tracking-tighter uppercase font-eurostile-extended">Tracks</span>
                </inertia-link>

                <inertia-link
                    class="flex items-center px-4 py-3 text-sm font-semibold transition duration-200 ease-in-out border-l-8 border-transparent active:bg-transparent focus:outline-none hover:text-blue-300 hover:bg-blue-900"
                    :class="{ 'border-blue-700 text-blue-300 bg-blue-900': route().current('albums*') }"
                    :href="route('albums.index')"
                >
                    <span class="tracking-tighter uppercase font-eurostile-extended">Albums/EPs</span>
                </inertia-link>

                <inertia-link
                    class="flex items-center px-4 py-3 text-sm font-semibold transition duration-200 ease-in-out border-l-8 border-transparent active:bg-transparent focus:outline-none hover:text-yellow-300 hover:bg-yellow-900"
                    :class="{ 'border-yellow-700 text-yellow-300 bg-yellow-900': route().current('events*') }"
                    :href="route('events.index')"
                >
                    <span class="tracking-tighter uppercase font-eurostile-extended">Events</span>
                </inertia-link>

                <div class="mt-auto"></div>

                <inertia-link
                    class="flex items-center px-4 py-3 text-sm font-semibold transition duration-200 ease-in-out border-l-8 border-transparent active:bg-transparent focus:outline-none hover:text-gray-300 hover:bg-gray-900"
                    :class="{ 'border-gray-700 text-gray-300 bg-gray-900': route().current('index') }"
                    :href="route('index')"
                >
                    <span class="tracking-tighter uppercase font-eurostile-extended">À propos</span>
                </inertia-link>

                <div class="mb-8"></div>

                <div class="border-b bg-gray-darker border-gray-dark" v-if="player.howl">
                    <div class="flex flex-col justify-between px-4 py-4">
                        <img :src="player.song.image_url" :alt="player.song.name" class="mb-4 border rounded shadow border-gray-darker">

                        <div class="w-full mb-4">
                            {{ player.song.title }}
                        </div>
                        <input
                            class="w-auto mb-4 overflow-hidden rounded-lg appearance-none bg-gray-default focus:outline-none"
                            type="range"
                            min="0"
                            :max="player.seek_max"
                            step="0.01"
                            v-model="player.seek"
                            style="height: 8px"
                            @input="set_seek()"
                        />

                        <div class="flex flex-row items-center justify-between text-gray-default">
                            <div class="text-xs">
                                {{ moment.duration(player.seek, 'seconds').format('mm:ss', { trim: false }) }}
                            </div>
                            <div class="text-xs">
                                <span v-if="player.seek_max != 0">
                                    {{ moment.duration(player.seek_max, 'seconds').format('mm:ss', { trim: false }) }}
                                </span>
                                <span v-else>
                                    --:--
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-darker">
                    <div class="flex flex-row items-center justify-center px-4 py-4 text-gray-default">
                        <div class="mr-4">
                            <i
                                v-if="player.howl"
                                @click="pause()"
                                class="transition duration-200 ease-in-out fas fa-fw hover:text-gray-lightest"
                                :class="{
                                    'fa-play': !player.howl.playing(),
                                    'fa-pause': player.howl.playing(),
                                }" />
                            <i
                                v-else
                                class="fas fa-fw fa-play text-gray-dark"
                            />
                        </div>
                        <div class="mr-4">
                            <i
                                @click="mute()"
                                class="transition duration-200 ease-in-out fas fa-fw hover:text-gray-lightest"
                                :class="{
                                    'fa-volume-off': player.volume == 0,
                                    'fa-volume-down': player.volume > 0 && player.volume < 0.5,
                                    'fa-volume-up': player.volume >= 0.5,
                                    'fa-volume-up ': player.volume == 1,
                                }"/>
                        </div>
                        <input class="w-32 overflow-hidden rounded-lg appearance-none bg-gray-dark focus:outline-none" type="range" min="0" max="1" step="0.01" v-model="player.volume" style="height: 8px" />
                    </div>
                </div>
            </div>

            <!-- Content -->
            <main class="w-full min-h-0 overflow-y-auto">
                <slot></slot>
            </main>
        </div>

        <!-- Footer? -->
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
                    howl: undefined,
                    song: undefined,
                    media: undefined,
                    volume: 0.5,
                    seek: 0,
                    seek_max: 0,
                }
            }
        },

        mounted(){
            EventBus.$on('play:media', payload => this.play(payload));

            setInterval(() => { this.update_seek(); }, 500);
        },

        watch: {
            'player.volume': function (volume, old_volume) {
                if (this.player.howl && old_volume == 0 && volume > 0) {
                    this.player.howl.play();
                } else if (this.player.howl && volume == 0 && old_volume > 0) {
                    this.player.howl.pause();
                }

                this.player.howl ? this.player.howl.volume(volume) : ''
            }
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
                    volume: this.player.volume,
                    onplay: () => { this.player.is_playing = true },
                    onpause: () => { this.player.is_playing = false },
                    onend: () => { this.player.is_playing = false },
                    onstop: () => { this.player.is_playing = false },
                    onload: () => { this.player.seek = 0; this.player.seek_max = this.player.howl.duration() },
                });

                this.player.show = true;
                this.player.is_playing = true;
            },
            pause(){
                this.player.howl.playing()
                    ? this.player.howl.pause()
                    : this.player.howl.play()
            },
            mute(){
                this.player.volume == 0
                    ? this.player.volume = 0.5
                    : this.player.volume = 0
            },
            update_seek(){
                this.player.seek = this.player.howl ? this.player.howl.seek() : 0
            },
            set_seek(){
                this.player.howl ? this.player.howl.seek(this.player.seek) : ''
            }
        }
    }
</script>
