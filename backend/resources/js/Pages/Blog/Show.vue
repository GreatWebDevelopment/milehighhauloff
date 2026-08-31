<script setup>
import { Link } from '@inertiajs/vue3';
import MainLayout from '../../Layouts/MainLayout.vue';

const props = defineProps({
    post: Object,
    seo: Object,
});

function formatDate(iso) {
    return iso
        ? new Date(iso).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })
        : '';
}
</script>

<template>
    <MainLayout>
        <section class="bg-asphalt-950 text-paper-50">
            <div class="mx-auto max-w-4xl px-4 py-16 sm:px-6">
                <nav class="font-display text-sm font-semibold uppercase tracking-widest text-asphalt-300">
                    <Link href="/" class="hover:text-haz-400">Home</Link>
                    <span class="mx-2 text-asphalt-500">/</span>
                    <Link href="/blog" class="hover:text-haz-400">Blog</Link>
                </nav>
                <h1 class="display-tight mt-3 text-3xl font-extrabold sm:text-4xl lg:text-5xl">{{ post.title }}</h1>
                <p class="mt-4 font-display font-semibold uppercase tracking-widest text-haz-400">
                    {{ formatDate(post.published_at) }}
                </p>
            </div>
            <div class="hazard-stripe"></div>
        </section>

        <article class="mx-auto max-w-3xl px-4 py-16 sm:px-6">
            <div class="wp-content" v-html="post.content"></div>

            <div class="mt-12 border-t-4 border-haz-500 bg-asphalt-950 p-8 text-center text-paper-50">
                <h2 class="display-tight text-3xl font-extrabold">Need it hauled off?</h2>
                <p class="mt-3 text-asphalt-300">Free quotes. Same-day service when available. Veteran-owned.</p>
                <Link
                    href="/get-started"
                    class="mt-5 inline-block bg-haz-500 px-8 py-3 font-display text-xl font-bold uppercase tracking-wide text-asphalt-950 transition hover:bg-haz-400"
                >
                    Get Your Free Quote
                </Link>
            </div>
        </article>
    </MainLayout>
</template>
