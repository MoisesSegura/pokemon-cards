<template>
    <div :class="['min-h-screen p-30 transition-colors duration-500', fondoPorTipo]">
      <BuscadorPokemon @buscarPokemon="buscarPorNombre" />
      <TipoFiltro :tipos="tiposDisponibles" @filtrarPorTipo="filtrarCartas" />
  
      <div v-if="loading" class="flex flex-col items-center justify-center py-10">
    <img
    src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/items/poke-ball.png"
    alt="Pokeball loader"
    class="w-16 h-16 animate-spin"/>
    <p class="mt-4 text-lg text-gray-700 font-semibold">Loading cards...</p>
    </div>

      <div v-else-if="filteredCards.length === 0">No cards found.</div>
      <div v-else class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
  <PokemonCard
    v-for="card in filteredCards"
    :key="card.id"
    :card="card"
    @ver-info="mostrarDetalle"
  />
</div>


<div
v-if="cartaSeleccionada"
  class="fixed inset-0 flex items-center justify-center z-50"
  style="perspective: 1000px;"
>
  <div
    class="absolute inset-0 bg-black opacity-50"
    @click="cartaSeleccionada = null"
  ></div>

  <div
  ref="cartaTilt"
  @mousemove="moverCarta"
  @mouseleave="resetearCarta"
  class="relative bg-white rounded-lg shadow-lg p-6 max-w-md w-full z-10 transition-transform duration-300 ease-out"
  :style="{ transform: tiltTransform, willChange: 'transform', transformStyle: 'preserve-3d' }"
  >
  
  <div
    class="absolute inset-0 pointer-events-none transition-opacity duration-300"
    :style="lightStyle"
  ></div>
      <img :src="cartaSeleccionada.images?.large" alt="" class="w-full mb-4" />
      <div v-if="cartaSeleccionada.tcgplayer?.prices?.holofoil">
      <p><strong>Market: ${{ cartaSeleccionada.tcgplayer.prices.holofoil.market }}</strong></p>
      <p class="text-green-500"><strong>Low: ${{ cartaSeleccionada.tcgplayer.prices.holofoil.low }}</strong></p>
      <p class="text-yellow-500"><strong>Mid: ${{ cartaSeleccionada.tcgplayer.prices.holofoil.mid }}</strong></p>
      <p class="text-red-500"><strong>High: ${{ cartaSeleccionada.tcgplayer.prices.holofoil.high }}</strong></p>
      <p><strong>Direct Low: ${{ cartaSeleccionada.tcgplayer.prices.holofoil.directLow }}</strong></p>
    </div>
    <div v-else>
      <p class="text-gray-500 text-sm">There is no price data for this card.</p>
    </div>

  </div>
  
</div>

    </div>
    
  </template>
  
  <script>
  import axios from 'axios';
  import BuscadorPokemon from "./BuscadorPokemon.vue";
  import TipoFiltro from './TipoFiltro.vue';
  import PokemonCard from './PokemonCard.vue';

  
  export default {
    components: { TipoFiltro, PokemonCard, BuscadorPokemon },
    data() {
      return {
        cards: [],
        filteredCards: [],
        cartas: [],
        loading: true,
        tiposDisponibles: [],
         tipoSeleccionado: 'All',
         cartaSeleccionada: null, 
           tiltTransform: 'scale(1)',

      };
    },
        methods: {
    filtrarCartas(tipo) {
        this.tipoSeleccionado = tipo;
        if (tipo === 'All') {
        this.filteredCards = this.cards;
        } else {
        this.filteredCards = this.cards.filter(card =>
            card.types?.includes(tipo)
        );
        }
    },

    mostrarDetalle(card) {
    this.cartaSeleccionada = card;
  },


  moverCarta(e) {
    const card = this.$refs.cartaTilt;
    const rect = card.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    const centerX = rect.width / 2;
    const centerY = rect.height / 2;
    const rotateX = ((y - centerY) / centerY) * -10;
    const rotateY = ((x - centerX) / centerX) * 10;

    this.tiltTransform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`;

    const percentX = (x / rect.width) * 100;
  const percentY = (y / rect.height) * 100;

  this.lightStyle = {
    backgroundImage: `radial-gradient(circle at ${percentX}% ${percentY}%, rgba(255,255,255,0.3), transparent 60%)`,
  };

  },
  resetearCarta() {
  this.tiltTransform = 'rotateX(0deg) rotateY(0deg) scale(1)';
  this.lightStyle = {};
},
async buscarPorNombre(nombre) {
  this.loading = true;
  try {
    const response = await fetch(`/buscar?nombre=${encodeURIComponent(nombre)}`);
    const data = await response.json();
    this.filteredCards = data.data || [];
  } catch (error) {
    console.error("Error al buscar:", error);
  } finally {
    this.loading = false;
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
          this.tiposDisponibles = ['All', ...Array.from(tipos)];
  
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
      case 'Psychic':
        return 'bg-gradient-to-br from-purple-400 to-pink-300';
      case 'Ground':
        return 'bg-gradient-to-br from-yellow-800 to-yellow-400';
      case 'Metal':
        return 'bg-gradient-to-br from-gray-700 to-gray-400';
      case 'Fighting':
        return 'bg-gradient-to-br from-red-800 to-Red-700';
      case 'Darkness':
        return 'bg-gradient-to-r from-slate-900 to-slate-700';
      case 'Dragon':
        return 'bg-gradient-to-br from-blue-300 to-indigo-200';
      case 'Fairy':
        return 'bg-gradient-to-br from-pink-300 to-pink-100';
      case 'Colorless':
        return 'bg-gradient-to-br from-white to-grey-100';
      default:
        return 'bg-gradient-to-r from-red-300 via-green-300 to-blue-300';
    }
  }
}

  };
  </script>
  
  