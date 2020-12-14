<template>
    <div class="h-full">
        <div class="p-8">
            <div class="mb-8 text-2xl">
                Bienvenue sur la <h1 class="inline italic tracking-tighter uppercase font-eurostile-extended">MAGENTA Database</h1>
            </div>

            <p class="mb-8">
                Ce site est une base de données communautaire qui référence la plupart des tracks du groupe.<br>
                L'obectif, à terme, est de garder une trace des différentes réinterprétations musicales et des tracks non publiées.<br>
                <br>
                Le site est alimenté et mis à jour par les membres du Discord. N'hésitez pas à <a href="https://bit.ly/magentadiscord" target="_blank" class="text-gray-300 transition duration-200 ease-in-out hover:text-white">nous rejoindre</a> !<br>
            </p>

            <p class="mb-8 text-sm text-gray-default">
                Les contenus référencés et hébergés appartiennent à leurs auteurs respectifs.<br>
                Développé avec <span class="text-pink-500">❤️</span> par <a href="https://mgk.dev" target="_blank" class="transition duration-200 ease-in-out text-gray-default hover:text-gray-lighter">Simon Rubuano</a>
            </p>

            <p class="text-sm text-gray-default">
                {{ $page.props.version }}<br>
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        layout: require('../layouts/app').default,
    }
</script>
