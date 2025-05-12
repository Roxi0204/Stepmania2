<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import Axios from 'axios';
import { defineProps } from 'vue';
import { router } from '@inertiajs/vue3'; 

const props = defineProps({
    announcement: {
        type: Object,
        required: true,
    },
});

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};

const deleteAnnouncement = (id) => {
    if (confirm('¿Estás seguro de que deseas eliminar este anuncio?')) {
        Axios.post(route('announcements.destroy', id))
            .then(() => {
                router.get(route('announcements.index')); // Redirige a la lista de anuncios
            })
            .catch((error) => {
                console.error('Error al eliminar el anuncio:', error);
            });
    }
};
</script>

<template>
    <Head :title="`Anuncio - ${props.announcement.title}`" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h1 class="text-2xl font-bold mb-4">{{ props.announcement.title }}</h1>
                        <p class="text-gray-700 mb-4">{{ props.announcement.description }}</p>
                        <p class="text-gray-700 mb-4">{{ props.announcement.email }}</p>
                        <p class="text-sm text-gray-500">Publicado el: {{ formatDate(props.announcement.created_at) }}</p>
                        <p class="text-gray-700 mb-4">{{ props.announcement.category.name }}</p>
                        <!-- Botones de Editar y Borrar -->
                        <div class="flex space-x-4 mt-6">
                            <Link :href="route('announcements.edit', props.announcement.id)"
                                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                            >
                                Editar
                            </Link>
                            <button
                                @click.prevent="deleteAnnouncement(props.announcement.id)"
                                class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600"
                            >
                                Borrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>