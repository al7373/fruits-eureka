<!-- assets/vue/components/FruitList.vue -->
<template>
  <div>
    <h1>Fruits List</h1>

    <div>
      <label for="name">Fruit name:</label>
      <input type="text" id="name" v-model="filters.name" @input="fetchFruits">
    </div>

    <div>
      <label for="family">Family:</label>
      <input type="text" id="family" v-model="filters.family" @input="fetchFruits">
    </div>

    <ul>
      <li v-for="fruit in fruits" :key="fruit.id">
        {{ fruit.name }} - {{ fruit.family }}
        <button @click="toggleFavorite(fruit)">Add to favorites</button>
      </li>
    </ul>

    <div>
      <button @click="changePage(-1)" :disabled="currentPage === 1">Previous</button>
      Page {{ currentPage }}
      <button @click="changePage(1)">Next</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      fruits: [],
      filters: {
        name: '',
        family: '',
      },
      currentPage: 1,
    };
  },
  methods: {
    async fetchFruits() {
      const response = await axios.get('http://localhost:3000/api/fruits', {
        params: {
          ...this.filters,
          page: this.currentPage,
        },
      });

      this.fruits = response.data;
    },
    changePage(delta) {
      this.currentPage += delta;
      this.fetchFruits();
    },
    async toggleFavorite(fruit) {
      await axios.post(`http://localhost:3000/api/fruits/${fruit.fruit_id}/favorite`);
      fruit.isFavorite = !fruit.isFavorite;
    },
  },
  mounted() {
    this.fetchFruits();
  },
};
</script>

