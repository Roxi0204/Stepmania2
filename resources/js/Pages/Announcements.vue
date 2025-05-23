<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { ref ,onMounted,computed,watch} from 'vue';
import { useForm } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import AnnouncementFormulari from './AnnouncementFormulari.vue';
import axios from 'axios';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

const props = defineProps({
    announcements: {
        type: Object,
        required: true,
    },
    pagination: {
        type: Object,
        required: true,
    },
    categories: {
        type: Object,
        required: true,
    },
});

const selectedCategory = ref('all')
const announcements = ref(props.pagination.data)
const pagination = ref(props.pagination)
const selectedPagination = ref(props.pagination.per_page)

const paginationOptions = [
        { value: 5, label: '5 per pàgina' },
        { value: 10, label: '10 per pàgina' },
        { value: 15, label: '15 per pàgina' },
        { value: 20, label: '20 per pàgina' }
    ]

const fetchAnnouncements = async (categoryId, page = 1) => {
        try {
            const response = await axios.post('/announcements/category', {
                params: {
                    category_id: categoryId,
                    page: page,
                    per_page: selectedPagination.value
                }
            })
            announcements.value = response.data.data
            pagination.value = {
                current_page: response.data.current_page,
                last_page: response.data.last_page,
                per_page: response.data.per_page,
                total: response.data.total,
                links: response.data.links
            }
        } catch (error) {
            console.error('Error al cargar los anuncios:', error)
        }
    }

watch([selectedCategory, selectedPagination], ([newCategory, newPagination]) => {
    fetchAnnouncements(newCategory, 1)
})

const changePage = (url) => {
    if (!url) return;

    const page = new URL(url).searchParams.get('page');
    fetchAnnouncements(selectedCategory.value, page);

}

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row justify-end items-center mb-4 gap-2">
                    <Link 
                        :href='route("announcements.create")'
                        class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 focus:ring-2 focus:ring-blue-300 focus:outline-none transition duration-300 text-center"
                        aria-label="Agregar un nuevo anuncio"
                    >
                        Agregar Anuncio
                    </Link>
                </div>
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">

                    <!-- Lista de anuncios -->
                    <div class="p-6">
                        <h2 class="text-lg font-bold mb-4">Anuncios</h2>
                        <div class="flex flex-col md:flex-row gap-4 mb-6">
                            <!-- Selector de categorías -->
                            <label for="category-select" class="sr-only">Seleccionar categoría</label>
                            <select 
                                id="category-select"
                                v-model="selectedCategory"
                                class="w-full md:w-64 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                aria-label="Seleccionar categoría"
                            >
                                <option value="all">Totes les categories</option>
                                <option v-for="category in props.categories" :key="category.id" :value="category.id">
                                    {{ category.name }}
                                </option>
                            </select>

                            <!-- Selector de paginación -->
                            <label for="pagination-select" class="sr-only">Seleccionar cantidad por página</label>
                            <select 
                                id="pagination-select"
                                v-model="selectedPagination"
                                class="w-full md:w-48 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                aria-label="Seleccionar cantidad de anuncios por página"
                            >
                                <option v-for="option in paginationOptions" :key="option.value" :value="option.value">
                                    {{ option.label }}
                                </option>
                            </select>
                        </div>
                        <ul>
                            <Link 
                                v-for="announcement in announcements" 
                                :key="announcement.id"
                                :href="route('announcements.show', announcement.id)" 
                                class="block"
                                aria-label="Ver detalles del anuncio {{ announcement.title }}"
                            >
                                <li class="p-4 bg-gray-100 rounded shadow mb-4">
                                    {{ announcement.title }}
                                </li>
                            </Link>
                        </ul>
                    </div>
                </div>
                <!-- Paginación -->
                <div class="mt-6 flex justify-center">
                    <nav class="inline-flex rounded-md shadow" aria-label="Navegación de paginación">
                        <template v-for="(link, key) in pagination.links" :key="key">
    <button 
        v-if="link.url" 
        @click="changePage(link.url)" 
        v-html="link.label"
        class="px-4 py-2 text-sm border border-gray-300 focus:ring-2 focus:ring-blue-300 focus:outline-none"
        :class="{
            'bg-blue-50 text-blue-600': link.active,
            'bg-white text-gray-700 hover:bg-gray-50': !link.active
        }"
        :aria-label="'Ir a la página ' + (link.label || key)"
    ></button>
    <span 
        v-else 
        v-html="link.label"
        class="px-4 py-2 text-sm text-gray-500 bg-white border border-gray-300"
        aria-hidden="true"
    ></span>
</template>
                    </nav>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>