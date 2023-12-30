<template>
  <div class="relative h-full">
    <inertia-head>
      <title>Settings</title>
    </inertia-head>

    <div class="relative p-4 md:p-8">
      <h2 class="mb-4 text-xl font-semibold">Préférences</h2>

      <p class="text-gray-dark dark:text-gray-default">
        <button @click="toggle_theme" class="inline-flex items-center px-4 py-2 text-xs font-semibold transition duration-200 ease-in-out bg-white bg-opacity-50 rounded cursor-pointer dark:bg-black text-gray-dark dark:text-gray-default active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500 hover:bg-opacity-70"><i class="mr-1 fas fa-lightbulb"></i> Thème {{ theme == 'dark' ? 'clair' : 'sombre' }}</button><br />
      </p>
    </div>
  </div>
</template>

<script>
import Layout from '@/layouts/app.vue';

export default {
  layout: Layout,

  props: ['albums'],

  data() {
    return {
      theme: undefined,
    };
  },

  mounted() {
    this.theme = localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) ? 'dark' : 'light';
  },

  methods: {
    toggle_theme() {
      if (this.theme == 'dark') {
        this.theme = localStorage.theme = 'light';
        document.querySelector('html').classList.remove('dark');
      } else {
        this.theme = localStorage.theme = 'dark';
        document.querySelector('html').classList.add('dark');
      }
    },
  },
};
</script>
