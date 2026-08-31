<script setup>
import { Link } from '@inertiajs/vue3';
import MainLayout from '../../Layouts/MainLayout.vue';
import PageHero from '../../Components/PageHero.vue';

defineProps({
    posts: { type: Array, default: () => [] },
    seo: Object,
});

const categoryLabels = {
    cleanout: 'Cleanouts',
    removal: 'Removal',
    'outside-cleanup': 'Outside Cleanup',
};

function formatDate(iso) {
    return iso
        ? new Date(iso).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })
        : '';
}
</script>

<template>
    <MainLayout>
        <PageHero :image="'/wp-content/uploads/2024/12/Denco-collecting-the-garbage-and-separating-waste-to-fre-2023-11-27-05-17-10-utc.jpg'">
            <p class="font-display text-sm font-semibold uppercase tracking-widest text-haz-400">Blog</p>
            <h1 class="display-tight mt-2 text-5xl font-extrabold sm:text-6xl">Tips from the crew</h1>
            <p class="mt-4 max-w-2xl text-lg text-asphalt-300">
                Junk removal tips, cleanout guides, and seasonal advice for Denver homeowners and businesses.
            </p>
        </PageHero>

        <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <Link
                    v-for="post in posts"
                    :key="post.slug"
                    :href="`/${post.category}/${post.slug}`"
                    class="group flex flex-col overflow-hidden border border-paper-200 bg-white transition hover:-translate-y-1 hover:border-haz-500 hover:shadow-lg"
                >
                    <img
                        v-if="post.og_image"
                        :src="post.og_image"
                        :alt="post.title"
                        loading="lazy"
                        class="aspect-[16/9] w-full object-cover"
                    />
                    <div class="flex grow flex-col p-6">
                        <p class="font-display text-sm font-bold uppercase tracking-widest text-haz-600">
                            {{ categoryLabels[post.category] ?? post.category }} · {{ formatDate(post.published_at) }}
                        </p>
                        <h2 class="mt-2 grow font-display text-xl font-bold uppercase leading-tight tracking-tight text-asphalt-900 group-hover:text-haz-600">
                            {{ post.title }}
                        </h2>
                        <p class="mt-3 line-clamp-3 text-sm text-asphalt-700">{{ post.meta_description }}</p>
                    </div>
                </Link>
            </div>
        </section>
    </MainLayout>
</template>
