<template>
    <div class="mb-6 flex items-center gap-2">
      <input
        v-model="nombre"
        @keyup.enter="buscar"
        type="text"
        placeholder="Buscar por nombre..."
        class="border border-black rounded bg-white px-4 py-1 focus:outline-none focus:ring focus:border-blue-400"
      />
      <button
        @click="buscar"
        class="bg-white border border-black text-black px-4 py-1 rounded hover:bg-blue-600 transition"
      >
        Buscar
      </button>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        nombre: "",
      };
    },
    methods: {
      buscar() {
        this.$emit("buscarPokemon", this.nombre.trim());
      },
    },
  };
  </script>
  