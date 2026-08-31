<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import MainLayout from '../Layouts/MainLayout.vue';

const props = defineProps({
    services: { type: Array, default: () => [] },
    seo: Object,
});

const site = computed(() => usePage().props.site);

const testimonials = [
    {
        name: 'Karyn Cassio',
        quote: 'I was very impressed with the service Jeremy and his crew provided. For a cost effective price they were able to come in and remove my large/heavy motorized reclining couch and arm chair. They were so respectful of my property and made extra effort to not hit walls as they exited the house. Definitely recommend.',
    },
    {
        name: 'Timothy Durgin',
        quote: 'Jeremy and his team were quick, efficient, and professional! He communicated about having to arrive a little late due to weather, so he and his team could arrive safely. Overall great experience and I would recommend if you need your junk hauled off!',
    },
    {
        name: 'Jared Threw',
        quote: 'Jeremy and his team were super nice and professional to work with. Having Jeremy nearby to remove the junk a tenant left was a big help. I highly recommend this team if you need something removed in a timely and professional manner.',
    },
];

const steps = [
    { n: '01', title: 'Free Quote', text: 'Contact us online or by phone to discuss your project and receive a no-obligation quote.' },
    { n: '02', title: 'Schedule a Pickup', text: 'We work around your schedule, offering same-day or next-day service when available.' },
    { n: '03', title: 'We Haul It Off', text: 'Our crew arrives on time, handles all the heavy lifting, and leaves your space clean.' },
];
</script>

<template>
    <MainLayout>
        <!-- Hero -->
        <section class="relative overflow-hidden bg-asphalt-950 text-paper-50">
            <div class="absolute inset-0" aria-hidden="true">
                <img
                    :src="'/wp-content/uploads/2024/12/Denco-male-sorter-with-a-protective-vest-gloves-unloads-2024-11-27-09-50-44-utc.jpg'"
                    alt=""
                    class="h-full w-full object-cover object-[75%_center] opacity-35"
                    fetchpriority="high"
                />
                <div class="absolute inset-0 bg-gradient-to-r from-asphalt-950 via-asphalt-950/85 to-asphalt-950/40"></div>
            </div>
            <div
                class="pointer-events-none absolute inset-0 opacity-[0.06]"
                style="background-image: repeating-linear-gradient(-45deg, #fff 0, #fff 2px, transparent 2px, transparent 24px)"
            ></div>
            <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:py-28">
                <p class="mb-4 inline-flex items-center gap-2 border border-haz-500/60 px-3 py-1 font-display text-sm font-semibold uppercase tracking-widest text-haz-400">
                    <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 2l2.9 6.3 6.9.8-5.1 4.7 1.4 6.8L12 17.3l-6.1 3.3 1.4-6.8L2.2 9.1l6.9-.8z"/></svg>
                    Veteran-Owned · Denver, CO
                </p>
                <h1 class="display-tight max-w-4xl text-5xl font-extrabold sm:text-6xl lg:text-7xl">
                    Junk removal &amp; yard cleanup,<br />
                    <span class="text-haz-400">done right the first time.</span>
                </h1>
                <p class="mt-6 max-w-2xl text-lg leading-relaxed text-asphalt-300">
                    Mile High Haul-Off is a veteran-owned junk removal service based in Denver, CO, specializing in
                    swift, reliable hauling for both residential and commercial needs. From construction debris to
                    hoarder cleanouts, we handle the heavy lifting so you don't have to.
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <Link
                        href="/get-started"
                        class="bg-haz-500 px-8 py-3.5 font-display text-xl font-bold uppercase tracking-wide text-asphalt-950 transition hover:bg-haz-400"
                    >
                        Get Started
                    </Link>
                    <Link
                        href="/services"
                        class="border-2 border-paper-50/30 px-8 py-3.5 font-display text-xl font-bold uppercase tracking-wide text-paper-50 transition hover:border-haz-400 hover:text-haz-400"
                    >
                        Our Services
                    </Link>
                </div>
            </div>
            <div class="hazard-stripe"></div>
        </section>

        <!-- The Mile High Difference -->
        <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:py-20">
            <div class="grid items-start gap-10 lg:grid-cols-2">
                <div>
                    <h2 class="display-tight text-4xl font-extrabold text-asphalt-950 sm:text-5xl">
                        The Mile High <span class="text-haz-600">difference</span>
                    </h2>
                    <p class="mt-5 text-lg leading-relaxed">
                        Whether you're clearing out a construction site, removing unwanted items, or restoring order
                        to your yard or home, Mile High Haul-Off is here to provide fast, efficient, and eco-friendly
                        junk removal services.
                    </p>
                    <p class="mt-4 text-lg leading-relaxed">
                        With a focus on reliable service and attention to detail, you can trust us to handle the
                        heavy lifting while you focus on what matters most.
                    </p>
                </div>
                <ul class="grid gap-4 sm:grid-cols-2">
                    <li v-for="perk in ['Same-Day Service Available', 'Fully Insured Crew', 'Free, Transparent Quotes', 'Eco-Friendly Disposal']" :key="perk" class="flex items-center gap-3 border border-paper-200 bg-white p-4">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center bg-haz-500">
                            <svg class="h-5 w-5 stroke-asphalt-950" fill="none" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                        </span>
                        <span class="font-display text-lg font-semibold uppercase tracking-wide text-asphalt-800">{{ perk }}</span>
                    </li>
                </ul>
            </div>
        </section>

        <!-- Services grid -->
        <section class="bg-paper-100 py-16 lg:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <h2 class="display-tight text-4xl font-extrabold text-asphalt-950 sm:text-5xl">Our Services</h2>
                    <Link href="/services" class="font-display text-lg font-bold uppercase tracking-wide text-haz-600 hover:underline">
                        View all services →
                    </Link>
                </div>
                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <Link
                        v-for="service in services.slice(0, 6)"
                        :key="service.slug"
                        :href="`/services/${service.slug}`"
                        class="group flex flex-col overflow-hidden border border-paper-200 bg-white transition hover:-translate-y-1 hover:border-haz-500 hover:shadow-lg"
                    >
                        <img
                            v-if="service.og_image"
                            :src="service.og_image"
                            :alt="service.name"
                            loading="lazy"
                            class="aspect-[16/9] w-full object-cover"
                        />
                        <div class="flex grow flex-col p-6">
                            <h3 class="font-display text-2xl font-bold uppercase leading-tight tracking-tight text-asphalt-900 group-hover:text-haz-600">
                                {{ service.name }}
                            </h3>
                            <p class="mt-3 line-clamp-3 grow text-asphalt-700">{{ service.meta_description }}</p>
                            <p class="mt-4 font-display font-bold uppercase tracking-wide text-haz-600">View Service →</p>
                        </div>
                    </Link>
                </div>
            </div>
        </section>

        <!-- Process -->
        <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:py-20">
            <h2 class="display-tight text-center text-4xl font-extrabold text-asphalt-950 sm:text-5xl">How it works</h2>
            <div class="mt-12 grid gap-8 md:grid-cols-3">
                <div v-for="step in steps" :key="step.n" class="relative border-t-4 border-haz-500 bg-white p-6 shadow-sm">
                    <span class="display-tight absolute -top-8 right-4 text-7xl font-extrabold text-paper-200">{{ step.n }}</span>
                    <h3 class="relative font-display text-2xl font-bold uppercase text-asphalt-900">{{ step.title }}</h3>
                    <p class="relative mt-3 text-asphalt-700">{{ step.text }}</p>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section class="bg-asphalt-950 py-16 text-paper-50 lg:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                <h2 class="display-tight text-4xl font-extrabold sm:text-5xl">What Denver says</h2>
                <div class="mt-10 grid gap-6 lg:grid-cols-3">
                    <figure v-for="t in testimonials" :key="t.name" class="flex flex-col justify-between border border-asphalt-700 bg-asphalt-900 p-6">
                        <blockquote class="leading-relaxed text-asphalt-300">"{{ t.quote }}"</blockquote>
                        <figcaption class="mt-5 flex items-center gap-2 font-display text-lg font-bold uppercase tracking-wide text-haz-400">
                            <span aria-hidden="true">★★★★★</span> {{ t.name }}
                        </figcaption>
                    </figure>
                </div>
            </div>
        </section>

        <!-- Service areas -->
        <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6">
            <h2 class="display-tight text-4xl font-extrabold text-asphalt-950">Proudly serving the Denver metro</h2>
            <p class="mt-4 max-w-2xl text-lg">
                We proudly serve Denver, Lakewood, and the surrounding areas, providing reliable junk removal
                services to both residential and commercial customers.
            </p>
            <ul class="mt-6 flex flex-wrap gap-3">
                <li v-for="area in site.serviceAreas" :key="area" class="border border-paper-200 bg-white px-4 py-1.5 font-display font-semibold uppercase tracking-wide text-asphalt-700">
                    {{ area }}
                </li>
            </ul>
        </section>
    </MainLayout>
</template>
