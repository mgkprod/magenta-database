<template>
  <div class="mx-auto flex min-h-screen w-full flex-col bg-white dark:bg-black">
    <main class="flex max-w-full flex-auto flex-col">
      <div class="max-w-10xl relative mx-auto flex min-h-screen w-full items-center justify-center overflow-hidden p-4 lg:p-8">
        <div class="relative w-full py-6 md:w-8/12 lg:w-6/12 lg:py-0 xl:w-4/12">
          <div class="mb-8 text-center">
            <h1 class="mb-1 inline-flex items-center text-4xl font-bold tracking-tighter text-primary-500">
              <inertia-link :href="route('index')" target="_blank" class="text-primary-500 transition duration-200 ease-in-out hover:text-primary-400" />
            </h1>
          </div>

          <slot />

          <div class="mt-8 text-center text-sm text-gray-500">
            © 2024 -
            <inertia-link :href="route('index')" target="_blank" class="text-primary-500 transition duration-200 ease-in-out hover:text-primary-400">{{ $page.props.app_name }}</inertia-link>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
export default {
  //
}
</script>
