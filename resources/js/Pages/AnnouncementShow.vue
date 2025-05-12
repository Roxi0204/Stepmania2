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
        <div class="py-12" role="main" aria-labelledby="announcement-title">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg" role="region" aria-labelledby="announcement-title">
                    <div class="p-6">
                        <h1 id="announcement-title" class="text-2xl font-bold mb-4 text-center sm:text-left">
                            {{ props.announcement.title }}
                        </h1>
                        <p id="announcement-description" class="text-gray-700 mb-4 text-justify">
                            {{ props.announcement.description }}
                        </p>
                        <p class="text-gray-700 mb-4">
                            <span class="sr-only">Correo electrónico del autor:</span>
                            {{ props.announcement.email }}
                        </p>
                        <p class="text-sm text-gray-500">
                            <span class="sr-only">Fecha de publicación:</span>
                            Publicado el: {{ formatDate(props.announcement.created_at) }}
                        </p>
                        <p class="text-gray-700 mb-4">
                            <span class="sr-only">Categoría:</span>
                            {{ props.announcement.category.name }}
                        </p>
                        <!-- Botones de Editar y Borrar -->
                        <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 mt-6">
                            <Link 
                                :href="route('announcements.edit', props.announcement.id)"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                aria-label="Editar anuncio"
                            >
                                Editar
                            </Link>
                            <Link
                                @click.prevent="deleteAnnouncement(props.announcement.id)"
                                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400"
                                aria-label="Borrar anuncio"
                            >
                            <span class="sr-only">Borrar anuncio</span>
                                Borrar
                        </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>