<template>
  <div class="mb-6 flex flex-wrap gap-2">
    <button
      v-for="tipo in tipos"
      :key="tipo"
      :class="[
        'px-4 py-1 rounded text-white font-semibold transition duration-300',
        estiloPorTipo[tipo] || 'bg-gray-400 hover:bg-gray-500'
      ]"
      @click="$emit('filtrarPorTipo', tipo)"
    >
      {{ tipo }}
    </button>
  </div>
</template>

<script>
export default {
  props: {
    tipos: Array
  },
  data() {
    return {
      estiloPorTipo: {
        Fire: 'bg-orange-500 hover:bg-orange-700',
        Water: 'bg-blue-500 hover:bg-blue-700',
        Grass: 'bg-green-500 hover:bg-green-700',
        Lightning: 'bg-yellow-500 hover:bg-yellow-700',
        Psychic: 'bg-pink-500 hover:bg-pink-700',
        Darkness: 'bg-gray-700 hover:bg-gray-900',
        Metal: 'bg-gray-500 hover:bg-gray-700',
        Fighting: 'bg-red-500 hover:bg-red-700',
        Dragon: 'bg-indigo-500 hover:bg-indigo-700',
        Fairy: 'bg-rose-500 hover:bg-rose-700',
        All: 'bg-gradient-to-r from-red-500 via-green-500 to-blue-500 hover:from-pink-600 hover:via-gray-600 hover:to-orange-600',
      }
    };
  }
};
</script>

  