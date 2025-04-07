<template>
    <div :class="['p-30 transition-colors duration-500', fondoPorTipo]">
      <TipoFiltro :tipos="tiposDisponibles" @filtrarPorTipo="filtrarCartas" />
  
      <div v-if="loading">Cargando cartas...</div>
      <div v-else-if="filteredCards.length === 0">No se encontraron cartas.</div>
      <div v-else class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        <div v-for="card in filteredCards" :key="card.id" class="rounded p-2 shadow">
          <div class="rounded overflow-hidden shadow hover:scale-105 transition-transform">
            <img :src="card.images?.small" :alt="card.name" class="w-full" />
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import TipoFiltro from './TipoFiltro.vue';
  
  export default {
    components: { TipoFiltro },
    data() {
      return {
        cards: [],
        filteredCards: [],
        loading: true,
        tiposDisponibles: [],
         tipoSeleccionado: 'Todos'
      };
    },
        methods: {
    filtrarCartas(tipo) {
        this.tipoSeleccionado = tipo;
        if (tipo === 'Todos') {
        this.filteredCards = this.cards;
        } else {
        this.filteredCards = this.cards.filter(card =>
            card.types?.includes(tipo)
        );
        }
    }
    },

    mounted() {
      axios.get('/cartas')
        .then(response => {
          this.cards = response.data;
          this.filteredCards = response.data;
  

          const tipos = new Set();
          this.cards.forEach(card => {
            (card.types || []).forEach(t => tipos.add(t));
          });
          this.tiposDisponibles = ['Todos', ...Array.from(tipos)];
  
          this.loading = false;
        })
        .catch(error => {
          console.error('Error al cargar cartas:', error);
          this.loading = false;
        });
    },

    computed: {
  fondoPorTipo() {
    switch (this.tipoSeleccionado) {
      case 'Fire':
        return 'bg-gradient-to-br from-red-400 to-yellow-300';
      case 'Water':
        return 'bg-gradient-to-br from-blue-400 to-cyan-300';
      case 'Grass':
        return 'bg-gradient-to-br from-green-400 to-lime-300';
      case 'Lightning':
        return 'bg-gradient-to-br from-yellow-300 to-yellow-100';
      case 'Psysic':
        return 'bg-gradient-to-br from-purple-400 to-pink-300';
      case 'Ground':
        return 'bg-gradient-to-br from-yellow-800 to-yellow-400';
      case 'Metal':
        return 'bg-gradient-to-br from-gray-800 to-white-400';
      case 'Fighting':
        return 'bg-gradient-to-br from-red-800 to-Red-700';
      case 'Darkness':
        return 'bg-gradient-to-br from-slate-900 to-gray-800';
      case 'Dragon':
        return 'bg-gradient-to-br from-blue-500 to-indigo-500';
      default:
        return 'bg-gradient-to-r from-gray-100 to-white';
    }
  }
}

  };
  </script>
  
  