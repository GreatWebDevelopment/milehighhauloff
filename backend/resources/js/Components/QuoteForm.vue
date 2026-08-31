<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { computed, ref, onBeforeUnmount } from 'vue';

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
    photos: [],
    website: '', // honeypot
});

const MAX_PHOTOS = 6;
const fileInput = ref(null);
const previews = ref([]); // { url, name } parallel to form.photos

function addFiles(fileList) {
    for (const file of Array.from(fileList)) {
        if (form.photos.length >= MAX_PHOTOS) break;
        if (!file.type.startsWith('image/')) continue;
        form.photos.push(file);
        previews.value.push({ url: URL.createObjectURL(file), name: file.name });
    }
}

function onFileChange(e) {
    addFiles(e.target.files);
    e.target.value = '';
}

function onDrop(e) {
    addFiles(e.dataTransfer.files);
}

function removePhoto(i) {
    URL.revokeObjectURL(previews.value[i].url);
    previews.value.splice(i, 1);
    form.photos.splice(i, 1);
}

function clearPreviews() {
    previews.value.forEach(p => URL.revokeObjectURL(p.url));
    previews.value = [];
}

onBeforeUnmount(clearPreviews);

function submit() {
    form.post(props.endpoint, {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            form.reset();
            clearPreviews();
        },
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

        <div>
            <label class="mb-1 block font-display font-semibold uppercase tracking-wide text-asphalt-700">
                Add photos <span class="font-sans normal-case text-asphalt-500">(optional, up to {{ MAX_PHOTOS }})</span>
            </label>
            <p class="mb-2 text-sm text-asphalt-500">
                📸 Snap a few photos of what needs to go — seeing the job lets us send you a faster, more accurate
                quote, often without a site visit.
            </p>
            <button
                type="button"
                class="flex w-full cursor-pointer flex-col items-center gap-1 border-2 border-dashed border-paper-200 bg-white px-4 py-6 text-center transition hover:border-haz-500"
                @click="fileInput.click()"
                @dragover.prevent
                @drop.prevent="onDrop"
            >
                <svg class="h-8 w-8 stroke-asphalt-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.8 7.5h.9l1-1.7c.3-.5.8-.8 1.4-.8h3.8c.6 0 1.1.3 1.4.8l1 1.7h.9A2.8 2.8 0 0 1 20 10.3v6.4a2.8 2.8 0 0 1-2.8 2.8H6.8A2.8 2.8 0 0 1 4 16.7v-6.4a2.8 2.8 0 0 1 2.8-2.8Z" />
                    <circle cx="12" cy="13" r="3" />
                </svg>
                <span class="font-display font-semibold uppercase tracking-wide text-asphalt-700">
                    Tap to add photos or drag them here
                </span>
                <span class="text-sm text-asphalt-500">JPG, PNG, WebP or HEIC — up to 10MB each</span>
            </button>
            <input
                ref="fileInput"
                type="file"
                accept="image/*"
                multiple
                class="hidden"
                @change="onFileChange"
            />
            <div v-if="previews.length" class="mt-3 flex flex-wrap gap-3">
                <div v-for="(p, i) in previews" :key="p.url" class="relative">
                    <img :src="p.url" :alt="p.name" class="h-20 w-20 border border-paper-200 object-cover" />
                    <button
                        type="button"
                        class="absolute -right-2 -top-2 flex h-6 w-6 items-center justify-center rounded-full bg-haz-600 text-sm font-bold text-white shadow hover:bg-red-700"
                        :aria-label="`Remove ${p.name}`"
                        @click="removePhoto(i)"
                    >
                        ×
                    </button>
                </div>
            </div>
            <p v-if="form.errors.photos" class="mt-1 text-sm text-red-600">{{ form.errors.photos }}</p>
            <p v-for="(err, key) in form.errors" v-show="String(key).startsWith('photos.')" :key="key" class="mt-1 text-sm text-red-600">
                {{ err }}
            </p>
        </div>

        <input v-model="form.website" type="text" name="website" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true" />

        <button
            type="submit"
            :disabled="form.processing"
            class="w-full bg-haz-500 px-8 py-3.5 font-display text-xl font-bold uppercase tracking-wide text-asphalt-950 transition hover:bg-haz-400 disabled:opacity-60 sm:w-auto"
        >
            {{ form.processing ? (form.progress ? `Uploading… ${form.progress.percentage}%` : 'Sending…') : 'Request Free Quote' }}
        </button>
    </form>
</template>
