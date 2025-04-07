<template>
    <div class="mb-6 flex flex-wrap gap-2">
      <button
        v-for="tipo in tipos"
        :key="tipo"
        class="px-4 py-1 rounded bg-blue-100 hover:bg-blue-300 transition"
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
    }
  };
  </script>
  