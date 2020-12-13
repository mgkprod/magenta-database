<template>
    <div>
        <div class="flex flex-col justify-center p-8 mb-8 rounded lg:pt-24 bg-header min-h-72">
            <div class="mb-4 text-2xl">
                Bienvenue sur la
                <h1 class="inline italic tracking-tighter uppercase font-eurostile-extended">MAGENTA Database</h1>
            </div>
            <p>
                Ce site est une base de données communautaire qui référence la plupart des tracks du groupe.<br>
                L'obectif, à terme, est de garder une trace des différentes réinterprétations musicales et des tracks non publiées.<br>
                <br>
                Le site est alimenté et mis à jour par les membres du Discord. N'hésitez pas à <a href="https://bit.ly/magentadiscord" target="_blank" class="text-gray-300 transition duration-200 ease-in-out hover:text-white">nous rejoindre</a> !<br>
            </p>
        </div>

        <h2 class="mb-4 italic uppercase font-eurostile-extended">
            Derniers ajouts
        </h2>

        <div class="flex flex-row">

        </div>
    </div>
</template>

<script>
    export default {
        layout: require('../layouts/app').default,
    }
</script>
