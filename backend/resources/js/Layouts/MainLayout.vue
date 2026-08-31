<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const site = computed(() => page.props.site);
const flash = computed(() => page.props.flash?.success);
const mobileOpen = ref(false);

const nav = [
    { label: 'Services', href: '/services' },
    { label: 'About', href: '/about' },
    { label: 'Blog', href: '/blog' },
    { label: 'Contact', href: '/contact' },
];
</script>

<template>
    <div class="min-h-screen bg-paper-50 font-sans text-asphalt-800">
        <!-- Top utility bar -->
        <div class="bg-asphalt-950 text-paper-100">
            <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-1.5 text-sm sm:px-6">
                <p class="flex items-center gap-2 font-display uppercase tracking-wide text-haz-400">
                    <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 2l2.9 6.3 6.9.8-5.1 4.7 1.4 6.8L12 17.3l-6.1 3.3 1.4-6.8L2.2 9.1l6.9-.8z"/></svg>
                    Veteran-Owned &amp; Operated
                </p>
                <a :href="`tel:${site.phone}`" class="font-semibold text-paper-50 hover:text-haz-400">
                    Call or Text {{ site.phoneDisplay }}
                </a>
            </div>
        </div>

        <!-- Header -->
        <header class="sticky top-0 z-40 border-b border-paper-200 bg-paper-50/95 backdrop-blur">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6">
                <Link href="/" class="shrink-0">
                    <img
                        :src="'/images/logo-light-long.png'"
                        alt="Mile High Haul-Off — Professional Junk Removal"
                        class="h-10 w-auto sm:h-12"
                        width="600"
                        height="90"
                    />
                </Link>
                <nav class="hidden items-center gap-8 md:flex">
                    <Link
                        v-for="item in nav"
                        :key="item.href"
                        :href="item.href"
                        class="font-display text-lg font-semibold uppercase tracking-wide text-asphalt-700 transition hover:text-haz-600"
                    >
                        {{ item.label }}
                    </Link>
                    <Link
                        href="/get-started"
                        class="bg-haz-500 px-5 py-2 font-display text-lg font-bold uppercase tracking-wide text-asphalt-950 transition hover:bg-haz-400"
                    >
                        Free Quote
                    </Link>
                </nav>
                <button
                    class="md:hidden"
                    aria-label="Toggle menu"
                    @click="mobileOpen = !mobileOpen"
                >
                    <svg class="h-7 w-7 stroke-asphalt-900" fill="none" viewBox="0 0 24 24" stroke-width="2">
                        <path v-if="!mobileOpen" stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" />
                        <path v-else stroke-linecap="round" d="M6 6l12 12M18 6L6 18" />
                    </svg>
                </button>
            </div>
            <nav v-if="mobileOpen" class="border-t border-paper-200 bg-paper-50 px-4 pb-4 md:hidden">
                <Link
                    v-for="item in nav"
                    :key="item.href"
                    :href="item.href"
                    class="block py-3 font-display text-xl font-semibold uppercase text-asphalt-800"
                    @click="mobileOpen = false"
                >
                    {{ item.label }}
                </Link>
                <Link
                    href="/get-started"
                    class="mt-2 block bg-haz-500 px-5 py-3 text-center font-display text-xl font-bold uppercase text-asphalt-950"
                    @click="mobileOpen = false"
                >
                    Free Quote
                </Link>
            </nav>
        </header>

        <!-- Flash -->
        <Transition
            enter-active-class="transition duration-300"
            enter-from-class="opacity-0 -translate-y-2"
            leave-active-class="transition duration-300"
            leave-to-class="opacity-0"
        >
            <div v-if="flash" class="bg-olive-600 px-4 py-3 text-center font-semibold text-paper-50">
                {{ flash }}
            </div>
        </Transition>

        <main>
            <slot />
        </main>

        <!-- Pre-footer CTA -->
        <section class="relative overflow-hidden bg-asphalt-950">
            <div class="hazard-stripe"></div>
            <div class="mx-auto flex max-w-7xl flex-col items-center gap-6 px-4 py-16 text-center sm:px-6">
                <h2 class="display-tight text-4xl font-extrabold text-paper-50 sm:text-5xl">
                    Ready to reclaim your space?
                </h2>
                <p class="max-w-2xl text-lg text-asphalt-300">
                    Free quotes, same-day service when available, and a fully insured crew that treats your property with respect.
                </p>
                <div class="flex flex-wrap items-center justify-center gap-4">
                    <Link
                        href="/get-started"
                        class="bg-haz-500 px-8 py-3 font-display text-xl font-bold uppercase tracking-wide text-asphalt-950 transition hover:bg-haz-400"
                    >
                        Get Your Free Quote
                    </Link>
                    <a
                        :href="`tel:${site.phone}`"
                        class="border-2 border-paper-50/40 px-8 py-3 font-display text-xl font-bold uppercase tracking-wide text-paper-50 transition hover:border-haz-400 hover:text-haz-400"
                    >
                        {{ site.phoneDisplay }}
                    </a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="border-t border-asphalt-800 bg-asphalt-950 text-asphalt-300">
            <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 md:grid-cols-3">
                <div>
                    <img
                        :src="'/images/logo-dark-long.png'"
                        alt="Mile High Haul-Off — Professional Junk Removal"
                        class="h-10 w-auto"
                        width="600"
                        height="90"
                        loading="lazy"
                    />
                    <p class="mt-4 text-sm leading-relaxed">
                        Veteran-owned junk removal and yard cleanup serving the Denver metro area. Fast, reliable, and eco-friendly.
                    </p>
                    <p class="mt-4 text-sm">
                        6699 West Mexico Place<br />Lakewood, Colorado 80232
                    </p>
                </div>
                <div>
                    <p class="font-display text-lg font-bold uppercase tracking-wide text-paper-50">Hours &amp; Contact</p>
                    <ul class="mt-3 space-y-1.5 text-sm">
                        <li>Mon – Fri: 8 AM – 5 PM</li>
                        <li>Sat: 10 AM – 3 PM</li>
                        <li><a :href="`tel:${site.phone}`" class="text-haz-400 hover:underline">{{ site.phoneDisplay }}</a></li>
                        <li><a :href="`mailto:${site.email}`" class="hover:text-haz-400">{{ site.email }}</a></li>
                    </ul>
                </div>
                <div>
                    <p class="font-display text-lg font-bold uppercase tracking-wide text-paper-50">Service Areas</p>
                    <p class="mt-3 text-sm leading-relaxed">{{ site.serviceAreas.join(' · ') }}</p>
                </div>
            </div>
            <div class="border-t border-asphalt-800 px-4 py-4 text-center text-xs text-asphalt-500">
                © {{ new Date().getFullYear() }} Mile High Haul-Off Ltd. All rights reserved.
            </div>
        </footer>
    </div>
</template>
