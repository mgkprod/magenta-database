<template>
    <div class="h-full">
        <div class="p-4 md:p-8">
            <div class="mb-8 text-2xl">
                Bienvenue sur la <h1 class="inline italic tracking-tighter uppercase font-eurostile-extended">MAGENTA Database</h1>
            </div>

            <p class="mb-8">
                Ce site est une base de données communautaire qui référence les tracks connues du groupe MAGENTA et de leurs projets liés.<br>
                L'objectif est de garder une trace des différentes réinterprétations musicales et des tracks non publiées.<br>
                <br>
                Le site est alimenté par les contributions des membres du Discord. N'hésitez pas à <a href="https://bit.ly/magentadiscord" target="_blank" class="transition duration-200 ease-in-out text-gray-dark dark:text-gray-default hover:text-gray-darker dark:hover:text-gray-lighter">nous rejoindre</a> !<br>
            </p>

            <div class="mb-8">
                <div class="mb-2">Retrouvez MAGENTA sur les réseaux :</div>

                <ul class="grid grid-cols-1 gap-1">
                    <li><a href="https://www.facebook.com/magentamusique/" class="inline-flex items-center px-4 py-1 text-sm font-semibold transition duration-200 ease-in-out rounded cursor-pointer bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500" target="_blank"><i class="mr-2 opacity-50 fab fa-fw fa-facebook"></i> Facebook</a></li>
                    <li><a href="https://www.youtube.com/channel/UCDJL7wvwArdhfydZR-XFtgw" class="inline-flex items-center px-4 py-1 text-sm font-semibold transition duration-200 ease-in-out rounded cursor-pointer bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500" target="_blank"><i class="mr-2 opacity-50 fab fa-fw fa-youtube"></i> YouTube</a></li>
                    <li><a href="https://www.instagram.com/magenta.club/" class="inline-flex items-center px-4 py-1 text-sm font-semibold transition duration-200 ease-in-out rounded cursor-pointer bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500" target="_blank"><i class="mr-2 opacity-50 fab fa-fw fa-instagram"></i> Instagram</a></li>
                    <li><a href="https://open.spotify.com/artist/5du1Lf0YKbak13Ym58jKsA" class="inline-flex items-center px-4 py-1 text-sm font-semibold transition duration-200 ease-in-out rounded cursor-pointer bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500" target="_blank"><i class="mr-2 opacity-50 fab fa-fw fa-spotify"></i> Spotify</a></li>
                    <li><a href="https://music.apple.com/fr/artist/magenta/1482405700" class="inline-flex items-center px-4 py-1 text-sm font-semibold transition duration-200 ease-in-out rounded cursor-pointer bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500" target="_blank"><i class="mr-2 opacity-50 fab fa-fw fa-apple"></i> Apple Music</a></li>
                    <li><a href="https://mtl.fm/magenta?fbclid=IwAR3uKDD5RqFPbpl0ziM3xub62vQQ8OC3oHWHg2-dkz_iQqwyXWbFyuHV9Aw#!/index" class="inline-flex items-center px-4 py-1 text-sm font-semibold transition duration-200 ease-in-out rounded cursor-pointer bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500" target="_blank"><i class="mr-2 opacity-50 fas fa-fw fa-phone"></i> WhatsApp</a></li>
                </ul>
            </div>

            <p class="mb-8 text-xs text-gray-dark dark:text-gray-default">
                <button @click="toggle_theme" class="transition duration-200 ease-in-out text-gray-dark dark:text-gray-default hover:text-gray-darker dark:hover:text-gray-lighter focus:outline-none"><i class="mr-1 fas fa-lightbulb"></i> Thème {{ theme == 'dark' ? 'clair' : 'sombre' }}</button><br>
                <br>
                Développé avec <span class="text-pink-500">❤️</span> par <a href="https://mgk.dev" target="_blank" class="transition duration-200 ease-in-out text-gray-dark dark:text-gray-default hover:text-gray-darker dark:hover:text-gray-lighter">Simon R.</a><br>
                <br>
                Les contenus référencés et hébergés appartiennent à leurs auteurs respectifs.<br>
                &copy; <a href="https://mgk.dev" target="_blank" class="transition duration-200 ease-in-out text-gray-dark dark:text-gray-default hover:text-gray-darker dark:hover:text-gray-lighter">MGK</a> - {{ $page.props.version }}<br>
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        layout: require('../layouts/app').default,

        data() {
            return {
                theme: undefined,
            }
        },

        mounted() {
            this.theme = (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches))
                ? 'dark'
                : 'light'
        },

        methods: {
            toggle_theme(){
                if (this.theme == 'dark') {
                    this.theme = localStorage.theme = 'light'
                    document.querySelector('html').classList.remove('dark')
                } else {
                    this.theme = localStorage.theme = 'dark'
                    document.querySelector('html').classList.add('dark')
                }
            }
        }
    }
</script>
