<template>
  <div class="relative h-full">
    <inertia-head>
      <title>Settings</title>
    </inertia-head>

    <div class="relative p-4 md:p-8">
      <h2 class="mb-4 text-xl font-semibold">Préférences</h2>

      <p class="text-gray-dark dark:text-gray-default">
        <button class="inline-flex cursor-pointer items-center rounded bg-white/50 px-4 py-2 text-xs font-semibold text-gray-dark transition duration-200 ease-in-out hover:bg-white/70 focus:outline-none focus:ring-2 focus:ring-gray-500/50 active:bg-transparent dark:bg-black/50 dark:text-gray-default dark:hover:bg-black/70" @click="toggle_theme"><i class="fas fa-lightbulb mr-1" /> Thème {{ theme == 'dark' ? 'clair' : 'sombre' }}</button><br />
      </p>
    </div>
  </div>
</template>

<script>
import Layout from '@/layouts/app.vue'

export default {
  layout: Layout,

  props: ['albums'],

  data() {
    return {
      theme: undefined,
    }
  },

  mounted() {
    this.theme = localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) ? 'dark' : 'light'
  },

  methods: {
    toggle_theme() {
      if (this.theme == 'dark') {
        this.theme = localStorage.theme = 'light'
        document.querySelector('html').classList.remove('dark')
      } else {
        this.theme = localStorage.theme = 'dark'
        document.querySelector('html').classList.add('dark')
      }
    },
  },
}
</script>
