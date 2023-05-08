<template>
    <div class="bg-[#222222]">
      <header class="shadow">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
          <h1 class="text-3xl font-bold text-[#eded00]">{{title}}</h1>
        </div>
        <hr>
      </header>
      <main class="flex ">
        <div class="mx-auto ">
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