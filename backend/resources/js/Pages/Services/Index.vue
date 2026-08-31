<script setup>
import { Link } from '@inertiajs/vue3';
import MainLayout from '../../Layouts/MainLayout.vue';

defineProps({
    services: { type: Array, default: () => [] },
    seo: Object,
});
</script>

<template>
    <MainLayout>
        <section class="bg-asphalt-950 text-paper-50">
            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6">
                <p class="font-display text-sm font-semibold uppercase tracking-widest text-haz-400">Services</p>
                <h1 class="display-tight mt-2 text-5xl font-extrabold sm:text-6xl">Junk Removal Services</h1>
                <p class="mt-4 max-w-3xl text-lg text-asphalt-300">
                    Mile High Haul-Off offers fast, reliable junk removal services in the Denver area — from
                    construction debris and appliance removal to yard cleanups and full property cleanouts.
                </p>
            </div>
            <div class="hazard-stripe"></div>
        </section>

        <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <Link
                    v-for="service in services"
                    :key="service.slug"
                    :href="`/services/${service.slug}`"
                    class="group flex flex-col border border-paper-200 bg-white p-6 transition hover:-translate-y-1 hover:border-haz-500 hover:shadow-lg"
                >
                    <h2 class="font-display text-2xl font-bold uppercase leading-tight tracking-tight text-asphalt-900 group-hover:text-haz-600">
                        {{ service.name }}
                    </h2>
                    <p class="mt-3 line-clamp-4 grow text-asphalt-700">{{ service.meta_description }}</p>
                    <p class="mt-4 font-display font-bold uppercase tracking-wide text-haz-600">View Service →</p>
                </Link>
            </div>
        </section>
    </MainLayout>
</template>
