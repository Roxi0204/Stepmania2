<script setup>
import { reactive } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const form = useForm({
    title: '',
    description: '',
    category: '', // Aquí se almacenará el ID de la categoría
    email: '',
});

const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },
    announcement: {
        type: Object,
        required: true,
    },
});

console.log(props.announcement);

onMounted(() => {
    form.category = props.announcement.category.id; // Asignar el ID de la categoría
    form.title = props.announcement.title;
    form.description = props.announcement.description;
    form.email = props.announcement.email;
});

function submitForm($id) {
    form.post(route('announcements.update',$id), {});
}
</script>

<template>
    <div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded mt-16">
        <h1 class="text-2xl font-bold mb-4">Editar Anuncio</h1>
        <form @submit.prevent="submitForm(props.announcement.id)">
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
                <input
                    type="text"
                    id="title"
                    v-model="form.title"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Escribe el título del anuncio"
                    required
                />
            </div>
            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700">Contenido</label>
                <textarea
                    id="content"
                    v-model="form.description"
                    rows="4"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Escribe el contenido del anuncio"
                    required
                ></textarea>
            </div>
            <div class="mb-4">
                <label for="category" class="block text-sm font-medium text-gray-700">Categoría</label>
                <select
                    id="category"
                    v-model="form.category"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    required
                >
                    <option value="" disabled>Selecciona una categoría</option>
                    <option v-for="category in props.categories" :key="category.id" :value="category.id">
                        {{ category.name }}
                    </option>
                </select>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input
                    type="text"
                    id="email"
                    v-model="form.email"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Escribe el email"
                    required
                />
            </div>
            <button
                type="submit"
                class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded hover:bg-indigo-700"
            >
                Guardar Cambios
            </button>
        </form>
    </div>
</template>

