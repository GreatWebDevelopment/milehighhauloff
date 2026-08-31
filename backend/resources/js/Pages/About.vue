<script setup>
import MainLayout from '../Layouts/MainLayout.vue';
import PageHero from '../Components/PageHero.vue';

defineProps({ seo: Object });
</script>

<template>
    <MainLayout>
        <PageHero :image="'/images/gbp/owner-with-loaded-trailer.jpg'">
            <p class="font-display text-sm font-semibold uppercase tracking-widest text-haz-400">About</p>
            <h1 class="display-tight mt-2 text-5xl font-extrabold sm:text-6xl">Welcome to Mile High Haul-Off Ltd</h1>
            <p class="mt-4 max-w-2xl text-lg text-asphalt-300">
                Your trusted partner for junk removal and yard cleanup in the Denver area.
            </p>
        </PageHero>

        <section class="mx-auto max-w-4xl px-4 py-16 sm:px-6">
            <p class="text-lg leading-relaxed">
                At Mile High Haul-Off, we offer efficient, affordable solutions for clearing clutter and revitalizing
                spaces. Our team combines professionalism with eco-friendly practices to ensure satisfaction and a
                cleaner, greener Denver. We specialize in junk removal, including landscaping waste, construction
                debris, furniture, and appliances, as well as light demolition, yard cleanups, and garage clean-outs.
                Fully insured, we offer both commercial and residential services with free quotes and a 100%
                satisfaction guarantee.
            </p>

            <div class="mt-12 border-l-4 border-haz-500 bg-white p-8 shadow-sm">
                <h2 class="display-tight text-3xl font-extrabold text-asphalt-950">Jeremy Bedard, Owner and Operator</h2>
                <div class="mt-5 space-y-4 leading-relaxed text-asphalt-700">
                    <p>
                        I am originally from the Pacific Northwest but I've lived in the Denver area since 2004 when I
                        was honorably discharged from the United States Army. Joining and serving in the military was
                        one of the best decisions I ever made. It taught me discipline and allowed me to explore and
                        discover things I never would have.
                    </p>
                    <p>
                        I attended Metro State University in Denver, where I received my degree in business
                        administration while working in the hospitality industry and as a pest control technician.
                        Business ownership and entrepreneurship has always been my dream and way of life. In 2014 I
                        started my pest control business, Colorado Pest Pros LLC. While working in the pest control
                        industry, I learned that there is a major need for junk removal and yard cleanup in the Denver
                        area, so I decided to start Mile High Haul-Off in 2023 with an emphasis on providing excellent
                        customer service at an affordable rate.
                    </p>
                    <p>
                        When I am not removing junk or exterminating pests around Denver, you can find me spending time
                        with my family and enjoying everything this great state of Colorado has to offer, including
                        hiking, camping, hunting, and snowboarding.
                    </p>
                </div>
            </div>
        </section>
    </MainLayout>
</template>
