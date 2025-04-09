<template>
    <div @click="handleClick" class="cursor-pointer rounded p-2 shadow hover:scale-105 transition-transform">
      <div class="rounded overflow-hidden shadow">
        <img :src="card.images?.small" :alt="card.name" class="w-full" />
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: ['card'],
    methods: {
      handleClick() {
        this.$emit('ver-info', this.card);
      }
    }
  };
  </script>
  