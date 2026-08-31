<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import MainLayout from '../../Layouts/MainLayout.vue';
import PageHero from '../../Components/PageHero.vue';

const props = defineProps({
    service: Object,
    seo: Object,
});

const site = computed(() => usePage().props.site);
</script>

<template>
    <MainLayout>
        <PageHero :image="service.og_image">
            <nav class="font-display text-sm font-semibold uppercase tracking-widest text-asphalt-300">
                    <Link href="/" class="hover:text-haz-400">Home</Link>
                    <span class="mx-2 text-asphalt-500">/</span>
                    <Link href="/services" class="hover:text-haz-400">Services</Link>
                </nav>
                <h1 class="display-tight mt-3 max-w-4xl text-4xl font-extrabold sm:text-5xl lg:text-6xl">
                    {{ service.name }}
                </h1>
                <p class="mt-4 max-w-3xl text-lg text-asphalt-300">{{ service.meta_description }}</p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <Link
                        href="/get-started"
                        class="bg-haz-500 px-8 py-3 font-display text-xl font-bold uppercase tracking-wide text-asphalt-950 transition hover:bg-haz-400"
                    >
                        Get a Free Quote
                    </Link>
                    <a
                        :href="`tel:${site.phone}`"
                        class="border-2 border-paper-50/30 px-8 py-3 font-display text-xl font-bold uppercase tracking-wide text-paper-50 transition hover:border-haz-400 hover:text-haz-400"
                    >
                        {{ site.phoneDisplay }}
                    </a>
                </div>
        </PageHero>

        <article class="mx-auto max-w-4xl px-4 py-16 sm:px-6">
            <div class="wp-content" v-html="service.content"></div>
        </article>
    </MainLayout>
</template>
