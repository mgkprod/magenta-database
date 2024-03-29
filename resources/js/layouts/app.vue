<template>
  <div class="vh flex w-full flex-col">
    <inertia-head>
      <title>{{ $page.props.app_name }}</title>
      <meta head-key="description" name="description" :content="$page.props.app_description" />
    </inertia-head>

    <div class="z-10 flex w-full flex-row items-center justify-between border-b-4 border-gray-darker bg-black p-4 lg:hidden">
      <button v-if="$page.props.app_name == 'DISTRACTIONS-DATABASE'" ref="toggle_sidebar_btn" class="bg-gradient-distractions mb-0 size-8 focus:outline-none" @click="show_sidebar = !show_sidebar" />
      <button v-else ref="toggle_sidebar_btn" class="bg-gradient-magenta mb-0 size-8 focus:outline-none" @click="show_sidebar = !show_sidebar" />
    </div>

    <div class="flex min-h-0 flex-auto flex-row">
      <!-- Sidebar -->
      <transition name="custom-classes-transition" enter-class="slide-left-enter" enter-active-class="slide-left-enter-active" leave-class="slide-left-leave" leave-active-class="slide-left-leave-active">
        <div v-click-away="away" class="absolute inset-y-0 z-30 flex w-56 flex-none flex-col bg-black text-gray-lightest shadow-lg transition-all duration-200 ease-in-out lg:static" :class="{ 'left-0': show_sidebar, '-left-96': !show_sidebar }">
          <div v-if="show_sidebar_links" class="flex h-full flex-col overflow-y-auto py-4">
            <div class="mb-4 py-4">
              <inertia-link :href="route('index')" class="tracking-tight transition-all duration-200 ease-in-out" @click="show_sidebar = false">
                <img v-if="$page.props.app_name == 'DISTRACTIONS-DATABASE'" src="/images/logo_distractions.png" alt="Logo" class="hover-contrast w-full" />
                <img v-else src="/images/logo.svg" alt="Logo" class="hover-contrast w-full" />
              </inertia-link>
            </div>

            <inertia-link class="flex items-center border-l-4 border-transparent px-4 py-3 text-sm font-semibold transition duration-200 ease-in-out hover:bg-pink-900 hover:text-pink-300 focus:outline-none active:bg-transparent" :class="{ 'border-pink-700 bg-pink-900 text-pink-300': route().current('songs*') }" :href="route('songs.index')" @click="show_sidebar = false">
              <span class="font-eurostile-extended uppercase tracking-tighter">Tracks</span>
            </inertia-link>

            <inertia-link class="flex items-center border-l-4 border-transparent px-4 py-3 text-sm font-semibold transition duration-200 ease-in-out hover:bg-blue-900 hover:text-blue-300 focus:outline-none active:bg-transparent" :class="{ 'border-blue-700 bg-blue-900 text-blue-300': route().current('albums*') }" :href="route('albums.index')" @click="show_sidebar = false">
              <span class="font-eurostile-extended uppercase tracking-tighter">Albums/EPs</span>
            </inertia-link>

            <inertia-link class="flex items-center border-l-4 border-transparent px-4 py-3 text-sm font-semibold transition duration-200 ease-in-out hover:bg-yellow-900 hover:text-yellow-300 focus:outline-none active:bg-transparent" :class="{ 'border-yellow-700 bg-yellow-900 text-yellow-300': route().current('events*') }" :href="route('events.index')" @click="show_sidebar = false">
              <span class="font-eurostile-extended uppercase tracking-tighter">Events</span>
            </inertia-link>

            <inertia-link class="flex items-center border-l-4 border-transparent px-4 py-3 text-sm font-semibold transition duration-200 ease-in-out hover:bg-purple-900 hover:text-purple-300 focus:outline-none active:bg-transparent" :class="{ 'border-purple-700 bg-purple-900 text-purple-300': route().current('search*') }" :href="route('search.index')" @click="show_sidebar = false">
              <span class="font-eurostile-extended uppercase tracking-tighter">Search</span>
            </inertia-link>

            <div class="mt-auto" />

            <inertia-link class="flex items-center border-l-4 border-transparent px-4 py-3 text-sm font-semibold transition duration-200 ease-in-out hover:bg-gray-900 hover:text-gray-300 focus:outline-none active:bg-transparent" :class="{ 'border-gray-700 bg-gray-900 text-gray-300': route().current('settings') }" :href="route('settings')" @click="show_sidebar = false">
              <span class="font-eurostile-extended uppercase tracking-tighter">Settings</span>
            </inertia-link>

            <inertia-link class="flex items-center border-l-4 border-transparent px-4 py-3 text-sm font-semibold transition duration-200 ease-in-out hover:bg-gray-900 hover:text-gray-300 focus:outline-none active:bg-transparent" :class="{ 'border-gray-700 bg-gray-900 text-gray-300': route().current('index') }" :href="route('index')" @click="show_sidebar = false">
              <span class="font-eurostile-extended uppercase tracking-tighter">About</span>
            </inertia-link>
          </div>

          <div class="fixed inset-0 flex w-full flex-col transition-all duration-200 ease-in-out lg:static" :class="{ 'top-full': !show_player }">
            <div v-if="!player.howl" class="flex-auto bg-gray-darker lg:hidden" />
            <transition name="custom-classes-transition" enter-class="slide-top-enter" enter-active-class="slide-top-enter-active" leave-class="slide-bottom-leave" leave-active-class="slide-bottom-leave-active">
              <div v-if="player.howl" class="relative flex-auto bg-gray-darker p-4">
                <div class="relative z-10 flex h-full flex-col items-center justify-center sm:flex-row lg:flex-col">
                  <inertia-link class="mb-4 block w-72 hover:underline sm:mb-0 sm:w-48 lg:mb-auto lg:w-full" :href="route('songs.show', player.song)" @click="show_player = false">
                    <vue-load-image class="aspect-h-1 aspect-w-1 mb-4 rounded bg-black/50 shadow-xl">
                      <template #image>
                        <img :src="player.song.image_url" class="animate__animated animate__fadeIn animate__fastest size-full rounded object-cover" />
                      </template>
                      <template #preloader>
                        <div class="flex items-center justify-center">
                          <i class="fas fa-spin fa-spinner text-gray-default" />
                        </div>
                      </template>
                    </vue-load-image>
                  </inertia-link>
                  <div class="flex w-full flex-col items-center justify-center sm:ml-8 sm:w-auto lg:ml-0 lg:w-full">
                    <div class="mb-4 w-72 text-center sm:text-left lg:w-full">
                      <inertia-link class="mb-2 block hover:underline lg:mb-0" :href="route('songs.show', player.song)" @click="show_player = false">{{ player.song.display_title }}</inertia-link>
                      <span class="text-gray-default">{{ player.song.artist }}</span>
                    </div>

                    <div class="mb-4 flex w-72 flex-row items-center justify-center text-gray-default lg:w-full">
                      <div class="mr-2 text-xs">
                        <i
                          v-if="player.queue.length"
                          class="fa-random fas fa-fw transition duration-200 ease-in-out hover:text-gray-lightest"
                          :class="{
                            'text-gray-dark': !player.random,
                            'text-gray-default': player.random,
                          }"
                          @click="toggle_random()"
                        />
                        <i v-else class="fas fa-fw fa-random text-gray-dark" />
                      </div>
                      <div class="mx-2">
                        <i v-if="!(player.queue_index <= 0)" class="fa-backward fas fa-fw transition duration-200 ease-in-out hover:text-gray-lightest" @click="backward()" />
                        <i v-else class="fas fa-fw fa-backward text-gray-dark" />
                      </div>
                      <div class="mx-2">
                        <i v-if="is_buffering" class="fas fa-fw fa-spinner fa-spin" />
                        <i
                          v-else-if="player.howl"
                          class="fas fa-fw transition duration-200 ease-in-out hover:text-gray-lightest"
                          :class="{
                            'fa-play': !is_playing,
                            'fa-pause': is_playing,
                          }"
                          @click="pause()"
                        />
                        <i v-else class="fas fa-fw fa-play text-gray-dark" />
                      </div>
                      <div class="mx-2">
                        <i v-if="!(player.queue_index >= player.queue.length - 1) || player.random || player.loop != 'disabled'" class="fa-forward fas fa-fw transition duration-200 ease-in-out hover:text-gray-lightest" @click="forward()" />
                        <i v-else class="fas fa-fw fa-forward text-gray-dark" />
                      </div>
                      <div class="relative ml-2 text-xs">
                        <i
                          class="fa-redo fas fa-fw transition duration-200 ease-in-out hover:text-gray-lightest"
                          :class="{
                            'text-gray-dark': player.loop == 'disabled',
                            'text-gray-default': player.loop == 'queue' || player.loop == 'self',
                          }"
                          @click="toggle_loop()"
                        />
                        <div :class="{ hidden: player.loop != 'self' }" class="absolute bottom-0 right-0 leading-none text-pink-500" style="font-size: 0.1rem">
                          <i class="fas fa-circle" />
                        </div>
                      </div>
                    </div>

                    <input v-model="player.seek" class="mb-4 w-72 appearance-none overflow-hidden rounded-lg bg-gray-default focus:outline-none lg:w-full" type="range" min="0" :max="player.seek_max" step="0.01" style="height: 8px" @input="set_seek()" />

                    <div class="flex w-72 flex-row items-center justify-between text-gray-default lg:w-full">
                      <div class="text-xs">
                        {{ moment.duration(player.seek, 'seconds').format('mm:ss', { trim: false }) }}
                      </div>
                      <div class="text-xs">
                        <span v-if="player.seek_max != 0">
                          {{ moment.duration(player.seek_max, 'seconds').format('mm:ss', { trim: false }) }}
                        </span>
                        <span v-else> --:-- </span>
                      </div>
                    </div>
                  </div>
                </div>
                <canvas ref="canvas" class="absolute inset-0 top-auto z-0 h-24 w-full border-b-4 border-gray-dark" />

                <button v-if="!is_casting && player.cjs && player.cjs.available" class="absolute bottom-0 left-0 z-10 h-16 px-4 text-xs focus:outline-none lg:hidden" @click="cast_connect">
                  <i class="fab fa-chromecast text-gray-default transition duration-200 ease-in-out hover:text-gray-lightest" />
                </button>
                <button v-if="is_casting" class="absolute bottom-0 left-0 z-10 h-16 px-4 text-xs focus:outline-none lg:hidden" @click="cast_disconnect">
                  <i class="fab fa-chromecast text-gray-default transition duration-200 ease-in-out hover:text-gray-lightest" />
                  <span v-if="player.cjs && player.cjs.device" class="ml-2">Connecté à {{ player.cjs.device }}</span>
                </button>
                <button class="absolute bottom-0 right-0 z-10 h-16 px-4 text-xs focus:outline-none lg:hidden" @click="show_player = false">
                  <i class="fas fa-chevron-down text-gray-default transition duration-200 ease-in-out hover:text-gray-lightest" />
                </button>
              </div>
            </transition>

            <div class="hidden bg-gray-darker lg:block">
              <transition name="custom-classes-transition" enter-class="slide-top-enter" enter-active-class="slide-top-enter-active" leave-class="slide-bottom-leave" leave-active-class="slide-bottom-leave-active">
                <div v-if="is_casting" class="flex flex-row items-center justify-center bg-pink-400 p-4 text-gray-darkest">
                  <div class="fa-fw mr-4 text-left">
                    <i
                      class="fab fa-chromecast transition duration-200 ease-in-out hover:text-gray-lightest"
                      :class="{
                        '': is_casting,
                      }"
                      @click="cast_disconnect"
                    />
                  </div>
                  <div class="w-full truncate text-xs">
                    <span v-if="player.cjs && player.cjs.device">Connecté à {{ player.cjs.device }}</span>
                  </div>
                </div>
              </transition>

              <div class="flex flex-row items-center justify-center p-4 text-gray-default">
                <transition name="custom-classes-transition" enter-class="slide-left-enter" enter-active-class="slide-left-enter-active" leave-class="slide-left-leave" leave-active-class="slide-left-leave-active">
                  <div v-if="!is_casting && player.cjs && player.cjs.available" class="fa-fw mr-4 text-left">
                    <i class="fab fa-chromecast transition duration-200 ease-in-out hover:text-gray-lightest" @click="cast_connect" />
                  </div>
                </transition>
                <div class="fa-fw mr-4 text-left">
                  <i
                    class="fas transition duration-200 ease-in-out hover:text-gray-lightest"
                    :class="{
                      'fa-volume-mute': player.volume == 0,
                      'fa-volume-off': player.volume > 0 && player.volume < 0.25,
                      'fa-volume-down': player.volume > 0.25 && player.volume < 0.5,
                      'fa-volume-up': player.volume >= 0.5,
                      'fa-volume-up ': player.volume == 1,
                    }"
                    @click="mute()"
                  />
                </div>
                <input v-model="player.volume" class="hidden w-full appearance-none overflow-hidden rounded-lg bg-gray-dark focus:outline-none lg:block" type="range" min="0" max="1" step="0.01" style="height: 8px" @input="set_volume()" />
              </div>
            </div>
          </div>
        </div>
      </transition>

      <!-- Content -->
      <main class="min-h-0 w-full overflow-y-auto overflow-x-hidden" scroll-region>
        <transition name="custom-classes-transition" enter-class="slide-left-enter" enter-active-class="slide-left-enter-active" leave-class="slide-left-leave" leave-active-class="slide-left-leave-active">
          <div v-show="show_page" class="size-full min-h-0">
            <slot />
          </div>
        </transition>
      </main>
    </div>

    <transition name="custom-classes-transition" enter-class="slide-top-enter" enter-active-class="slide-top-enter-active" leave-class="slide-bottom-leave" leave-active-class="slide-bottom-leave-active">
      <div v-if="player.howl" class="z-10 flex w-full flex-row items-center justify-start border-t-4 border-gray-darker bg-black text-gray-lightest lg:hidden" @click="show_player = true">
        <div v-if="player.howl" class="size-16 flex-none">
          <vue-load-image class="aspect-h-1 aspect-w-1 bg-black/50 shadow-xl">
            <template #image>
              <img :src="player.song.image_url" class="animate__animated animate__fadeIn animate__fastest size-full object-cover" />
            </template>
            <template #preloader>
              <div class="flex items-center justify-center">
                <i class="fas fa-spin fa-spinner text-xs text-gray-default" />
              </div>
            </template>
          </vue-load-image>
        </div>
        <div class="flex-auto truncate">
          <div v-if="player.howl" class="flex h-full flex-col items-center px-4">
            <div class="w-full text-left text-sm">
              <div class="mb-1 truncate">{{ player.song.display_title }}</div>
              <div class="truncate text-gray-default">{{ player.song.artist }}</div>
            </div>
          </div>
        </div>
        <button class="ml-auto h-16 px-4 focus:outline-none lg:hidden" @click="show_player = true">
          <i class="fas fa-chevron-up text-xs text-gray-default transition duration-200 ease-in-out hover:text-gray-lightest" />
        </button>
      </div>
    </transition>
  </div>
</template>

<script>
import { EventBus } from '../event-bus.js'
import { Howl, Howler } from 'howler'
import Castjs from '../vendor/cast.js'
import _ from 'lodash'
import {global_data} from '../store.js'

export default {
  data() {
    return {
      show_page: true,
      show_sidebar: false,
      show_sidebar_links: true,
      show_player: false,
      player: {
        cjs: undefined,
        howl: undefined,
        song: undefined,
        media: undefined,
        volume: 1,
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
      },

      // Temp variables to handle cast connection/disconnection
      was_volume: 0.5,
      is_disconnecting: false,
      was_playing: false,
      was_seek: 0,

      // Temp variable to refresh computed properties
      refreshKey: 0,
    }
  },

  computed: {
    is_casting() {
      this.refreshKey

      return this.player.cjs && this.player.cjs.connected
    },

    is_playing() {
      this.refreshKey

      if (this.is_casting) return !this.player.cjs.paused
      else return this.player.howl && this.player.howl.playing()
    },

    is_buffering() {
      this.refreshKey

      if (this.is_casting) return this.player.cjs.state == 'buffering'
      else return this.player.howl && this.player.howl.state() == 'loading'
    },
  },

  watch: {
    // 'player.volume': function (volume, old_volume) {
    //   // if (this.player.howl && old_volume == 0 && volume > 0) {
    //   //   this.player.howl.play();
    //   // } else if (this.player.howl && volume == 0 && old_volume > 0) {
    //   //   this.player.howl.pause();
    //   // }
    //   // this.set_volume(volume);
    // },
  },

  mounted() {
    EventBus.$on('play:media', (payload) => {
      this.player.queue = [payload.song]
      this.player.queue_index = 0
      this.play(payload)
    })
    EventBus.$on('play:event', (payload) => this.fetch_event(payload))
    EventBus.$on('play:album', (payload) => this.fetch_album(payload))
    EventBus.$on('play:song', (payload) => this.fetch_song(payload))

    setInterval(() => !this.is_casting && this.update_seek(), 500)

    this.show_page = true
    this.$inertia.on('before', () => {
      this.show_page = false
    })
    this.$inertia.on('finish', () => {
      this.show_page = true

      this.show_sidebar_links = false
      this.$nextTick(() => (this.show_sidebar_links = true))
    })

    if (typeof window !== 'undefined' && !this.player.cjs) this.init_cjs()
  },

  methods: {
    init_cjs() {
      this.player.cjs = new Castjs()

      this.player.cjs.on('disconnect', () => (this.is_disconnecting = true))
      this.player.cjs.on('timeupdate', () => this.update_seek())
      this.player.cjs.on('volumechange', () => (this.player.volume = this.player.cjs.volumeLevel))
      this.player.cjs.on('mute', () => (this.player.volume = 0))
      this.player.cjs.on('unmute', () => (this.player.volume = this.player.cjs.volumeLevel))
      this.player.cjs.on('playing', () => {
        this.player.seek_max = this.player.cjs.duration
        this.player.volume = this.player.cjs.volumeLevel
      })
      this.player.cjs.on('end', () => {
        if (this.player.seek_max !== 0 && !this.is_disconnecting) {
          // If seek_max is not empty, then we assume that we was playing a song, so we need to play the next one.
          this.forward()
        }
      })
    },

    init_howl() {
      this.player.howl = new Howl({
        autoplay: true,
        src: [this.player.media.url],
        html5: true,
        volume: this.player.volume,
        onplay: () => { this.refreshKey++ },
        onpause: () => {},
        onend: () => { this.forward() },
        onstop: () => {},
        onload: () => {
          this.update_media_session()
          this.player.seek_max = this.player.howl.duration()

          this.refreshKey++
        },
      })
    },

    cast_connect() {
      if (!this.player.cjs) this.init_cjs()
      this.was_playing = this.is_playing
      this.is_disconnecting = false

      this.player.cjs.requestSession(() => {
        if (this.was_playing) {
          this.player.howl.pause()
          this.play({ song: this.player.song, media: this.player.media }, true)
          this.was_playing = false
        }
      })
    },

    cast_disconnect() {
      this.was_playing = this.is_playing
      this.was_seek = this.player.seek
      this.player.cjs.disconnect()

      let rearm_howl = () => {
        if (this.is_casting) return setTimeout(rearm_howl, 500)

        this.play({ song: this.player.song, media: this.player.media }, true)
        this.was_playing = false
      }

      if (this.was_playing) {
        setTimeout(rearm_howl, 500)
      }
    },

    away(e) {
      if (e.target != this.$refs.toggle_sidebar_btn) this.show_sidebar = false
    },

    fetch_event(payload) {
      this.axios.get('/api/events/' + payload.event.id + '/songs').then((response) => {
        this.player.queue = response.data.songs
        this.player.queue_index = -1
        this.forward()
      })
    },

    fetch_album(payload) {
      this.axios.get('/api/albums/' + payload.album.id + '/songs').then((response) => {
        this.player.queue = response.data.songs
        this.player.queue_index = -1
        this.forward()
      })
    },

    fetch_song(payload) {
      this.axios.get('/api/songs/' + payload.song.id + '/medias?best=true').then((response) => {
        if (payload.empty_queue) {
          this.player.queue = [payload.song]
          this.player.queue_index = 0
        }
        if (payload.context) {
          this.player.queue = payload.context
          this.player.queue_index = _.findIndex(payload.context, payload.song)
        }
        this.play({
          song: payload.song,
          media: response.data.media,
        })
      })
    },

    backward() {
      this.player.queue_index--
      if (this.player.queue_index < 0) {
        this.player.queue_index = 0
        return
      }

      let song = this.player.queue[this.player.queue_index]
      this.fetch_song({ song })
    },

    forward() {
      if (this.player.loop == 'self') {
        // Don't increment the queue_index
      } else if (this.player.random) {
        this.player.queue_index = Math.floor(Math.random() * this.player.queue.length)
      } else {
        this.player.queue_index++
      }
      if (this.player.queue_index >= this.player.queue.length) {
        if (this.player.loop == 'queue') {
          this.player.queue_index = 0
        } else {
          this.player.queue_index = this.player.queue.length - 1
          return
        }
      }

      let song = this.player.queue[this.player.queue_index]
      this.fetch_song({ song })
    },

    play(payload, resumeSeek = false) {
      this.player.song = payload.song
      this.player.media = payload.media
      if (!resumeSeek) this.player.seek = 0
      this.player.seek_max = 0

      global_data.$curr_song_id = payload.song.id
      global_data.$curr_media_id = payload.media.id

      if (!this.player.cjs) this.init_cjs()

      if (this.is_casting) {
        this.player.cjs.cast(
          this.player.media.url,
          {
            title: this.player.song.artist + ' - ' + this.player.song.display_title,
            poster: this.player.song.image_url,
            startTime: resumeSeek ? this.player.seek : 0,
          },
          false,
        )

        this.player.cjs.play()
      } else {
        if (this.player.howl) this.player.howl.unload()
        this.init_howl()
        this.player.howl.seek(resumeSeek ? this.was_seek : 0)
      }

      this.update_media_session()

      if (!this.visualizer.analyser) this.visualizer_init()
    },

    pause() {
      if (this.is_casting) !this.player.cjs.paused ? this.player.cjs.pause() : this.player.cjs.play()
      else this.player.howl ? (this.player.howl.playing() ? this.player.howl.pause() : this.player.howl.play()) : 0
    },

    mute() {
      if (this.player.volume !== 0) this.was_volume = this.player.volume
      this.player.volume == 0 ? (this.player.volume = this.was_volume) : (this.player.volume = 0)
      this.set_volume()
    },

    toggle_random() {
      this.player.random = !this.player.random
    },

    toggle_loop() {
      if (this.player.loop == 'disabled') this.player.loop = 'queue'
      else if (this.player.loop == 'queue') this.player.loop = 'self'
      else if (this.player.loop == 'self') this.player.loop = 'disabled'
    },

    update_seek() {
      if (this.is_casting) this.player.seek = this.player.cjs.time
      else this.player.seek = this.player.howl ? this.player.howl.seek() : 0
    },

    set_seek() {
      if (this.is_casting) this.player.cjs.seek(this.player.seek)
      else this.player.howl ? this.player.howl.seek(this.player.seek) : ''
    },

    set_volume() {
      if (this.is_casting) this.player.cjs.volume(Math.round(this.player.volume * 10) / 10)
      else this.player.howl ? this.player.howl.volume(this.player.volume) : ''
    },

    update_media_session() {
      if ('mediaSession' in navigator) {
        navigator.mediaSession.metadata = new MediaMetadata({
          title: this.player.song.display_title,
          artist: this.player.song.artist,
          artwork: [{ src: this.player.song.image_url, sizes: '256x256', type: 'image/png' }],
        })

        navigator.mediaSession.setActionHandler('play', this.pause)
        navigator.mediaSession.setActionHandler('pause', this.pause)
        navigator.mediaSession.setActionHandler('previoustrack', this.backward)
        navigator.mediaSession.setActionHandler('nexttrack', this.forward)
      }
    },

    visualizer_init() {
      let ctx = new AudioContext()
      this.visualizer.analyser = ctx.createAnalyser()

      let audio = this.player.howl._sounds[0]._node
      let source = ctx.createMediaElementSource(audio)
      source.connect(this.visualizer.analyser)
      this.visualizer.analyser.connect(ctx.destination)

      this.visualizer.analyser.fftSize = 128
      this.visualizer.buffer_length = this.visualizer.analyser.frequencyBinCount
      this.visualizer.freq_data = new Uint8Array(this.visualizer.buffer_length)

      requestAnimationFrame(this.visualizer_frame)
    },

    visualizer_frame() {
      this.visualizer.analyser.getByteFrequencyData(this.visualizer.freq_data)

      let width = this.$refs.canvas.width
      let height = this.$refs.canvas.height
      let ctx = this.$refs.canvas.getContext('2d')

      ctx.fillStyle = 'rgb(40, 40, 40)'
      ctx.fillRect(0, 0, width, height)

      let bar_width = (width / this.visualizer.buffer_length) * 2.5

      let gradient = ctx.createLinearGradient(0, 0, 200, 0)
      gradient.addColorStop(0, '#424242')
      gradient.addColorStop(1, '#424242')

      let x = 0

      for (let i = 0; i < this.visualizer.buffer_length; i++) {
        let freq_data = this.visualizer.freq_data[i]
        let bar_height = (freq_data / 255) * height

        ctx.fillStyle = gradient
        ctx.fillRect(x, height - bar_height, bar_width, bar_height)

        x += bar_width - 1
      }

      requestAnimationFrame(this.visualizer_frame)
    },
  },
}
</script>
