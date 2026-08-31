<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import MainLayout from '../Layouts/MainLayout.vue';
import QuoteForm from '../Components/QuoteForm.vue';
import PageHero from '../Components/PageHero.vue';

defineProps({
    services: { type: Array, default: () => [] },
    seo: Object,
});
const site = computed(() => usePage().props.site);
</script>

<template>
    <MainLayout>
        <PageHero :image="'/wp-content/uploads/2024/12/Denco-movers-in-uniform-and-medical-masks-lifting-glass-2024-11-14-20-52-53-utc.jpg'">
            <p class="font-display text-sm font-semibold uppercase tracking-widest text-haz-400">Get Started</p>
            <h1 class="display-tight mt-2 text-5xl font-extrabold sm:text-6xl">Request a Quote</h1>
            <p class="mt-4 max-w-2xl text-lg text-asphalt-300">Contact us today to receive a free quote!</p>
        </PageHero>

        <section class="mx-auto grid max-w-7xl gap-12 px-4 py-16 sm:px-6 lg:grid-cols-5">
            <div class="lg:col-span-3">
                <QuoteForm :services="services" endpoint="/submit/quote" />
            </div>
            <aside class="space-y-6 lg:col-span-2">
                <div class="border border-paper-200 bg-white p-6">
                    <h2 class="font-display text-xl font-bold uppercase tracking-wide text-asphalt-900">Service Areas</h2>
                    <p class="mt-3 text-asphalt-700">
                        We proudly serve Denver, Lakewood, and the surrounding areas, providing reliable junk removal
                        services to both residential and commercial customers.
                    </p>
                </div>
                <div class="border border-paper-200 bg-white p-6">
                    <h2 class="font-display text-xl font-bold uppercase tracking-wide text-asphalt-900">Operating Hours</h2>
                    <ul class="mt-3 space-y-1 text-asphalt-700">
                        <li>Mon – Fri: 8 AM – 5 PM</li>
                        <li>Sat: 10 AM – 3 PM</li>
                    </ul>
                </div>
                <div class="border-t-4 border-haz-500 bg-asphalt-950 p-6 text-paper-50">
                    <h2 class="font-display text-xl font-bold uppercase tracking-wide">Call or Text</h2>
                    <a :href="`tel:${site.phone}`" class="mt-2 block font-display text-3xl font-extrabold text-haz-400">
                        {{ site.phoneDisplay }}
                    </a>
                    <a :href="`mailto:${site.email}`" class="mt-2 block text-asphalt-300 hover:text-haz-400">{{ site.email }}</a>
                </div>
            </aside>
        </section>
    </MainLayout>
</template>
