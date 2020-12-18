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
                    class="flex items-center px-4 py-3 text-sm font-semibold transition duration-200 ease-in-out border-l-4 border-transparent active:bg-transparent focus:outline-none hover:text-pink-300 hover:bg-pink-900"
                    :class="{ 'border-pink-700 text-pink-300 bg-pink-900': route().current('songs*') }"
                    :href="route('songs.index')"
                >
                    <span class="tracking-tighter uppercase font-eurostile-extended">Tracks</span>
                </inertia-link>

                <inertia-link
                    class="flex items-center px-4 py-3 text-sm font-semibold transition duration-200 ease-in-out border-l-4 border-transparent active:bg-transparent focus:outline-none hover:text-blue-300 hover:bg-blue-900"
                    :class="{ 'border-blue-700 text-blue-300 bg-blue-900': route().current('albums*') }"
                    :href="route('albums.index')"
                >
                    <span class="tracking-tighter uppercase font-eurostile-extended">Albums/EPs</span>
                </inertia-link>

                <inertia-link
                    class="flex items-center px-4 py-3 text-sm font-semibold transition duration-200 ease-in-out border-l-4 border-transparent active:bg-transparent focus:outline-none hover:text-yellow-300 hover:bg-yellow-900"
                    :class="{ 'border-yellow-700 text-yellow-300 bg-yellow-900': route().current('events*') }"
                    :href="route('events.index')"
                >
                    <span class="tracking-tighter uppercase font-eurostile-extended">Events</span>
                </inertia-link>

                <inertia-link
                    class="flex items-center px-4 py-3 text-sm font-semibold transition duration-200 ease-in-out border-l-4 border-transparent active:bg-transparent focus:outline-none hover:text-purple-300 hover:bg-purple-900"
                    :class="{ 'border-purple-700 text-purple-300 bg-purple-900': route().current('search*') }"
                    :href="route('search.index')"
                >
                    <span class="tracking-tighter uppercase font-eurostile-extended">Search</span>
                </inertia-link>

                <div class="mt-auto"></div>

                <inertia-link
                    class="flex items-center px-4 py-3 text-sm font-semibold transition duration-200 ease-in-out border-l-4 border-transparent active:bg-transparent focus:outline-none hover:text-gray-300 hover:bg-gray-900"
                    :class="{ 'border-gray-700 text-gray-300 bg-gray-900': route().current('index') }"
                    :href="route('index')"
                >
                    <span class="tracking-tighter uppercase font-eurostile-extended">À propos</span>
                </inertia-link>

                <div class="mb-8"></div>

                <transition
                    name="custom-classes-transition"
                    enter-class="slide-top-enter"
                    enter-active-class="slide-top-enter-active"
                    leave-class="slide-bottom-leave"
                    leave-active-class="slide-bottom-leave-active"
                >
                    <div class="border-b-4 bg-gray-darker border-gray-dark" v-if="player.howl">
                        <div class="relative flex flex-col justify-between px-4 py-4">
                            <div class="z-10">
                                <inertia-link class="hover:underline" :href="route('songs.show', player.song)">
                                    <vue-load-image class="mb-4 bg-black bg-opacity-50 rounded shadow-xl aspect-w-1 aspect-h-1 ">
                                        <img slot="image" :src="player.song.image_url" class="object-cover w-full h-full rounded animate__animated animate__fadeIn animate__fastest" />
                                        <div class="flex items-center justify-center" slot="preloader"><i class="fas fa-spin fa-spinner text-gray-default"></i></div>
                                    </vue-load-image>
                                </inertia-link>

                                <div class="w-full mb-4">
                                    <inertia-link class="hover:underline" :href="route('songs.show', player.song)">{{ player.song.display_title }}</inertia-link><br>
                                    <span class="text-gray-default">{{ player.song.artist }}</span>
                                </div>

                                <div class="flex flex-row items-center justify-center w-full mb-4 text-gray-default">
                                    <div class="mr-2 text-xs">
                                        <i
                                            v-if="player.queue.length"
                                            @click="toggle_random()"
                                            class="transition duration-200 ease-in-out fa-random fas fa-fw hover:text-gray-lightest"
                                            :class="{
                                                'text-gray-dark': !player.random,
                                                'text-gray-default': player.random,
                                            }"
                                        />
                                    </div>
                                    <div class="mx-2">
                                        <i
                                            v-if="!(player.queue_index <= 0)"
                                            @click="backward()"
                                            class="transition duration-200 ease-in-out fa-backward fas fa-fw hover:text-gray-lightest"
                                        />
                                        <i
                                            v-else
                                            class="fas fa-fw fa-backward text-gray-dark"
                                        />
                                    </div>
                                    <div class="mx-2">
                                        <i
                                            v-if="player.is_loading"
                                            class="fas fa-fw fa-spinner fa-spin "
                                        />
                                        <i
                                            v-else-if="player.howl"
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
                                    <div class="mx-2">
                                        <i
                                            v-if="!((player.queue_index >= (player.queue.length - 1))) || this.player.random || this.player.loop != 'disabled'"
                                            @click="forward()"
                                            class="transition duration-200 ease-in-out fa-forward fas fa-fw hover:text-gray-lightest"
                                        />
                                        <i
                                            v-else
                                            class="fas fa-fw fa-forward text-gray-dark"
                                        />
                                    </div>
                                    <div class="relative ml-2 text-xs">
                                        <i
                                            @click="toggle_loop()"
                                            class="transition duration-200 ease-in-out fa-redo fas fa-fw hover:text-gray-lightest"
                                            :class="{
                                                'text-gray-dark': player.loop == 'disabled',
                                                'text-gray-default': player.loop == 'queue' || player.loop == 'self'
                                            }"
                                        />
                                        <div :class="{ 'hidden': player.loop != 'self' }" class="absolute bottom-0 right-0 leading-none text-pink-500" style="font-size: 0.1rem"><i class="fas fa-circle"></i></div>
                                    </div>
                                </div>

                                <input
                                    class="w-full mb-4 overflow-hidden rounded-lg appearance-none bg-gray-default focus:outline-none"
                                    type="range"
                                    min="0"
                                    :max="player.seek_max"
                                    step="0.01"
                                    v-model="player.seek"
                                    style="height: 8px"
                                    @input="set_seek()"
                                />

                                <div class="flex flex-row items-center justify-between w-full text-gray-default">
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
                            <canvas ref="canvas" class="absolute inset-0 top-auto z-0 w-full h-24"></canvas>
                        </div>
                    </div>
                </transition>
                <div class="bg-gray-darker">
                    <div class="flex flex-row items-center justify-center px-4 py-4 text-gray-default">
                        <div class="mr-4 text-left fa-fw">
                            <i
                                @click="mute()"
                                class="transition duration-200 ease-in-out fas hover:text-gray-lightest"
                                :class="{
                                    'fa-volume-mute': player.volume == 0,
                                    'fa-volume-off': player.volume > 0 && player.volume < 0.25,
                                    'fa-volume-down': player.volume > 0.25 && player.volume < 0.50,
                                    'fa-volume-up': player.volume >= 0.50,
                                    'fa-volume-up ': player.volume == 1,
                                }"/>
                        </div>
                        <input class="w-32 overflow-hidden rounded-lg appearance-none bg-gray-dark focus:outline-none" type="range" min="0" max="1" step="0.01" v-model="player.volume" style="height: 8px" />
                    </div>
                </div>
            </div>

            <!-- Content -->
            <main class="w-full min-h-0 overflow-x-hidden overflow-y-auto">
                <transition
                    name="custom-classes-transition"
                    enter-class="slide-left-enter"
                    enter-active-class="slide-left-enter-active"
                    leave-class="slide-left-leave"
                    leave-active-class="slide-left-leave-active"
                >
                    <div class="w-full min-h-0" v-if="show">
                        <slot></slot>
                    </div>
                </transition>
            </main>
        </div>
    </div>
</template>

<script>
    import { EventBus } from '../event-bus.js';
    import { Howl, Howler } from 'howler';
    import VueLoadImage from 'vue-load-image'

    export default {
        components: {
            VueLoadImage
        },

        data() {
            return {
                show: false,
                player: {
                    show: false,
                    howl: undefined,
                    song: undefined,
                    media: undefined,
                    volume: 0.5,
                    seek: 0,
                    seek_max: 0,
                    queue: [],
                    queue_index: 0,
                    random: false,
                    loop: 'disabled',
                },
                visualizer: {
                    analyser: undefined,
                    freq_data: undefined,
                    buffer_length: undefined,
                }
            }
        },

        mounted(){
            EventBus.$on('play:media', payload => { this.player.queue = []; this.play(payload) });
            EventBus.$on('play:event', payload => this.fetch_event(payload));
            EventBus.$on('play:album', payload => this.fetch_album(payload));
            EventBus.$on('play:song', payload => this.fetch_song(payload));

            setInterval(() => { this.update_seek(); }, 500);

            this.show = true
            this.$inertia.on('before', (event) => { this.show = false })
            this.$inertia.on('success', (event) => { this.show = true })
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
            fetch_event(payload) {
                axios.get('/api/events/' + payload.event.id + '/songs')
                    .then((response) => {
                        this.player.queue = response.data.songs;
                        this.player.queue_index = -1;
                        this.forward();
                    });
            },
            fetch_album(payload) {
                axios.get('/api/albums/' + payload.album.id + '/songs')
                    .then((response) => {
                        this.player.queue = response.data.songs;
                        this.player.queue_index = -1;
                        this.forward();
                    });
            },
            fetch_song(payload) {
                axios.get('/api/songs/' + payload.song.id + '/medias?best=true')
                    .then((response) => {
                        if (payload.empty_queue) {
                            this.player.queue = [];
                            this.player.queue_index = -1;
                        }
                        if (payload.context) {
                            this.player.queue = payload.context;
                            this.player.queue_index = _.findIndex(payload.context, payload.song);
                        }
                        this.play({
                            song: payload.song,
                            media: response.data.media,
                        })
                    });
            },
            backward(){
                this.player.queue_index--;
                if (this.player.queue_index < 0) {
                    this.player.queue_index = 0;
                    return;
                }

                let song = this.player.queue[this.player.queue_index];
                this.fetch_song({ song });
            },
            forward(){
                if (this.player.loop == 'self') {
                    // Don't increment the queue_index
                } else if (this.player.random) {
                    this.player.queue_index = Math.floor(Math.random() * this.player.queue.length);
                } else {
                    this.player.queue_index++;
                }
                if (this.player.queue_index >= this.player.queue.length) {
                    if (this.player.loop == 'queue') {
                        this.player.queue_index = 0;
                    } else {
                        this.player.queue_index = (this.player.queue.length - 1);
                        return;
                    }
                }

                let song = this.player.queue[this.player.queue_index];
                this.fetch_song({ song });
            },
            play(payload) {
                let first_time = true;

                if (this.player.howl) {
                    this.player.howl.unload();
                    first_time = false;
                }

                this.player.song = payload.song;
                this.player.media = payload.media;
                this.player.seek_max = 0;
                this.player.is_loading = true;

                this.$curr_song_id = payload.song.id;
                this.$curr_media_id = payload.media.id;

                this.player.howl = new Howl({
                    src: [this.player.media.url],
                    html5: true,
                    autoplay: true,
                    volume: this.player.volume,
                    onplay: () => { },
                    onpause: () => { },
                    onend: () => { this.forward() },
                    onstop: () => { },
                    onload: () => { this.player.is_loading = false; this.player.seek = 0; this.player.seek_max = this.player.howl.duration() },
                });

                if ('mediaSession' in navigator) {
                    navigator.mediaSession.metadata = new MediaMetadata({
                        title: this.player.song.display_title,
                        artist: this.player.song.artist,
                        artwork: [
                            { src: this.player.song.image_url, sizes: '256x256', type: 'image/png' },
                        ]
                    });
                }

                if (first_time) {
                    this.visualizer_init();

                    if ('mediaSession' in navigator) {
                        navigator.mediaSession.setActionHandler('play', this.pause);
                        navigator.mediaSession.setActionHandler('pause', this.pause);
                        navigator.mediaSession.setActionHandler('previoustrack', this.backward);
                        navigator.mediaSession.setActionHandler('nexttrack', this.forward);
                    }
                }

                this.player.show = true;
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
            toggle_random(){
                this.player.random = !this.player.random;
            },
            toggle_loop(){
                if (this.player.loop == 'disabled') this.player.loop = 'queue';
                else if (this.player.loop == 'queue') this.player.loop = 'self';
                else if (this.player.loop == 'self') this.player.loop = 'disabled';
            },
            update_seek(){
                this.player.seek = this.player.howl ? this.player.howl.seek() : 0
            },
            set_seek(){
                this.player.howl ? this.player.howl.seek(this.player.seek) : ''
            },
            visualizer_init(){
                this.visualizer.analyser = Howler.ctx.createAnalyser();
                Howler.masterGain.connect(this.visualizer.analyser);

                this.visualizer.analyser.fftSize = 128;
                this.visualizer.buffer_length = this.visualizer.analyser.frequencyBinCount;

                this.visualizer.freq_data = new Uint8Array(this.visualizer.buffer_length);

                requestAnimationFrame(this.visualizer_frame);
            },
            visualizer_frame(){
                this.visualizer.analyser.getByteFrequencyData(this.visualizer.freq_data);

                let width = this.$refs.canvas.width;
                let height = this.$refs.canvas.height;
                let ctx = this.$refs.canvas.getContext("2d");

                ctx.fillStyle = "rgb(40, 40, 40)";
                ctx.fillRect(0, 0, width, height);

                let bar_width = (width / this.visualizer.buffer_length) * 2.5;

                let gradient = ctx.createLinearGradient(0, 0, 200, 0);
                gradient.addColorStop(0, '#424242');
                gradient.addColorStop(1, '#424242');

                let x = 0;

                for (let i = 0; i < this.visualizer.buffer_length; i++) {
                    let freq_data = this.visualizer.freq_data[i];
                    let bar_height = (freq_data / 255) * height;

                    ctx.fillStyle = gradient;
                    ctx.fillRect(x, (height - bar_height), bar_width, bar_height);

                    x += bar_width - 1;
                }

                requestAnimationFrame(this.visualizer_frame);
            },
        }
    }
</script>
