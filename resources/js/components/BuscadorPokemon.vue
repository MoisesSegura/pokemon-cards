<template>
    <div class="mb-6 flex items-center gap-2">
      <input
        v-model="nombre"
        @keyup.enter="buscar"
        type="text"
        placeholder="Search by name..."
        class="border border-black rounded bg-white px-4 py-1 focus:outline-none focus:ring focus:border-blue-400"
      />
      <button
        @click="buscar"
        class="bg-white border border-black text-black px-4 py-1 rounded hover:bg-neutral-300 transition"
      >
        Search
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
  