<script setup>
defineProps({
    image: { type: String, default: null },
});
</script>

<template>
    <section class="relative overflow-hidden bg-asphalt-950 text-paper-50">
        <div v-if="image" class="absolute inset-0" aria-hidden="true">
            <img :src="image" alt="" class="h-full w-full object-cover opacity-30" loading="eager" />
            <div class="absolute inset-0 bg-gradient-to-r from-asphalt-950 via-asphalt-950/85 to-asphalt-950/50"></div>
        </div>
        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6">
            <slot />
        </div>
        <div class="hazard-stripe relative"></div>
    </section>
</template>
