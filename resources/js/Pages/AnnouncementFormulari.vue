<script setup>
import { reactive } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';

const form = useForm({
    title: '',
    description: '',
    category: '',
    email: '',
   
});
const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },
});

function submitForm() {
   form.post(route('announcements.store'), {
       
    });
    form.title = '';
    form.content = '';

}
</script>
<template>
    <div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded mt-16">
        <h1 class="text-2xl font-bold mb-4 text-center">Crear un nuevo anuncio</h1>
        <form @submit.prevent="submitForm" class="space-y-4">
            <!-- Título -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
                <input
                    type="text"
                    id="title"
                    v-model="form.title"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Escribe el título del anuncio"
                    required
                    aria-required="true"
                />
            </div>

            <!-- Contenido -->
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700">Contenido</label>
                <textarea
                    id="content"
                    v-model="form.description"
                    rows="4"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Escribe el contenido del anuncio"
                    required
                    aria-required="true"
                ></textarea>
            </div>

            <!-- Categoría -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700">Categoría</label>
                <select
                    id="category"
                    v-model="form.category"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    required
                    aria-required="true"
                >
                    <option value="" disabled>Selecciona una categoría</option>
                    <option v-for="category in props.categories" :key="category.id" :value="category.id">
                        {{ category.name }}
                    </option>
                </select>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input
                    type="email"
                    id="email"
                    v-model="form.email"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Escribe el email"
                    required
                    aria-required="true"
                />
            </div>

            <!-- Botón de envío -->
            <div class="flex justify-center">
                <button
                    type="submit"
                    class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition duration-300"
                    aria-label="Crear un nuevo anuncio"
                >
                    Crear Anuncio
                </button>
            </div>
        </form>
    </div>
</template>

