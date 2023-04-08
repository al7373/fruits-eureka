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
        <button @click="toggleFavorite(fruit)">
          {{ fruit.isFavorite ? 'remove from favorite' : 'add to favorite' }}
        </button>
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
      favoriteFruits: [],
      totalNutritionFacts: {
        carbohydrates: 0,
        protein: 0,
        fat: 0,
        calories: 0,
        sugar: 0,
      },
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
      this.$emit('favorite-changed', fruit);
    },
  },
  mounted() {
    this.fetchFruits();
  },
};
</script>

