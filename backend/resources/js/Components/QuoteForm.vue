<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    services: { type: Array, default: () => [] },
    endpoint: { type: String, default: '/submit/quote' },
});

const flash = computed(() => usePage().props.flash?.success);

const form = useForm({
    name: '',
    email: '',
    phone: '',
    service: '',
    message: '',
    website: '', // honeypot
});

function submit() {
    form.post(props.endpoint, {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
}
</script>

<template>
    <form class="space-y-4" @submit.prevent="submit">
        <div v-if="flash" class="border-l-4 border-olive-600 bg-olive-600/10 p-4 font-semibold text-olive-700">
            {{ flash }}
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label for="qf-name" class="mb-1 block font-display font-semibold uppercase tracking-wide text-asphalt-700">Name *</label>
                <input
                    id="qf-name"
                    v-model="form.name"
                    type="text"
                    required
                    autocomplete="name"
                    class="w-full border border-paper-200 bg-white px-4 py-2.5 focus:border-haz-500 focus:outline-none"
                />
                <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
            </div>
            <div>
                <label for="qf-phone" class="mb-1 block font-display font-semibold uppercase tracking-wide text-asphalt-700">Phone</label>
                <input
                    id="qf-phone"
                    v-model="form.phone"
                    type="tel"
                    autocomplete="tel"
                    class="w-full border border-paper-200 bg-white px-4 py-2.5 focus:border-haz-500 focus:outline-none"
                />
                <p v-if="form.errors.phone" class="mt-1 text-sm text-red-600">{{ form.errors.phone }}</p>
            </div>
        </div>

        <div>
            <label for="qf-email" class="mb-1 block font-display font-semibold uppercase tracking-wide text-asphalt-700">Email</label>
            <input
                id="qf-email"
                v-model="form.email"
                type="email"
                autocomplete="email"
                class="w-full border border-paper-200 bg-white px-4 py-2.5 focus:border-haz-500 focus:outline-none"
            />
            <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
        </div>

        <div v-if="services.length">
            <label for="qf-service" class="mb-1 block font-display font-semibold uppercase tracking-wide text-asphalt-700">What do you need hauled off?</label>
            <select
                id="qf-service"
                v-model="form.service"
                class="w-full border border-paper-200 bg-white px-4 py-2.5 focus:border-haz-500 focus:outline-none"
            >
                <option value="">Select a service…</option>
                <option v-for="s in services" :key="s.slug" :value="s.name">{{ s.name }}</option>
                <option value="Other">Something else</option>
            </select>
        </div>

        <div>
            <label for="qf-message" class="mb-1 block font-display font-semibold uppercase tracking-wide text-asphalt-700">Tell us about the job</label>
            <textarea
                id="qf-message"
                v-model="form.message"
                rows="4"
                class="w-full border border-paper-200 bg-white px-4 py-2.5 focus:border-haz-500 focus:outline-none"
            ></textarea>
            <p v-if="form.errors.message" class="mt-1 text-sm text-red-600">{{ form.errors.message }}</p>
        </div>

        <input v-model="form.website" type="text" name="website" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true" />

        <button
            type="submit"
            :disabled="form.processing"
            class="w-full bg-haz-500 px-8 py-3.5 font-display text-xl font-bold uppercase tracking-wide text-asphalt-950 transition hover:bg-haz-400 disabled:opacity-60 sm:w-auto"
        >
            {{ form.processing ? 'Sending…' : 'Request Free Quote' }}
        </button>
    </form>
</template>
