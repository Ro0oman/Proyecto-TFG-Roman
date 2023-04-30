<template>
    <div class="bg-[#2F4858]">
      <header class="shadow">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
          <h1 class="text-3xl font-bold  text-[#F1574B]">{{title}}</h1>
        </div>
      </header>
      <main class="min-h-screen">
        <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
          <slot></slot>
        </div>
      </main>
    </div>
</template>

<script>

export default {
    props: {
        title: String,
    }
}
</script>

<style>

</style>