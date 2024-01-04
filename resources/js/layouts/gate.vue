<template>
  <div class="flex flex-col w-full min-h-screen mx-auto bg-white dark:bg-black">
    <main class="flex flex-col flex-auto max-w-full">
      <div class="relative flex items-center justify-center w-full min-h-screen p-4 mx-auto overflow-hidden max-w-10xl lg:p-8">
        <div class="relative w-full py-6 lg:py-0 md:w-8/12 lg:w-6/12 xl:w-4/12">
          <div class="mb-8 text-center">
            <h1 class="inline-flex items-center mb-1 text-4xl font-bold tracking-tighter text-primary-500">
              <inertia-link :href="route('index')" target="_blank" class="transition duration-200 ease-in-out text-primary-500 hover:text-primary-400" />
            </h1>
          </div>

          <slot />

          <div class="mt-8 text-sm text-center text-gray-500">
            © 2024 -
            <inertia-link :href="route('index')" target="_blank" class="transition duration-200 ease-in-out text-primary-500 hover:text-primary-400">{{ $page.props.app_name }}</inertia-link>
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
