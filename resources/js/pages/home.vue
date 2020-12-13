<template>
    <div>
        <div class="flex flex-col overflow-hidden bg-white rounded shadow-sm">
            <div class="w-full px-5 py-4 font-semibold lg:px-6 bg-gray-50">
                <h3>Welcome, {{ user.name }}!</h3>
            </div>

            <div class="flex-grow w-full p-5 lg:p-6">
                <p>Build something incredible.</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        layout: require('../layouts/app').default,

        props: {
            user: Object,
        }
    }
</script>
