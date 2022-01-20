<template>
    <div class="w-full h-full relative rounded-md overflow-hidden shadow-md shadow-Dark/[98%] cursor-pointer">
        <div class="transition-all duration-300">
            <img class="w-full h-full object-fit" :src="arr.url" :alt="arr.name">
        </div>
        <div class="absolute w-full py-3 bottom-0 left-0 bg-Dark/80 flex justify-center text-xs font-bold px-2">
            {{ arr.name }}
        </div>
    </div>
</template>

<script>
export default {
    name: "Game",

    props: ['arr'],
}
</script>

<style scoped>

</style>
