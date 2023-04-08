<!-- assets/vue/components/FavoriteFruits.vue -->
<template>
  <div>
    <h1>Fruits favoris</h1>
    <ul>
      <li v-for="fruit in favoriteFruits" :key="fruit.fruit_id">
        {{ fruit.name }} - {{ fruit.family }}
      </li>
    </ul>
    <div>
      <h2>Sum of nutritions facts</h2>
      <p>Carbohydrates: {{ totalNutritionFacts.carbohydrates }} g</p>
      <p>Protein: {{ totalNutritionFacts.protein }} g</p>
      <p>Fat: {{ totalNutritionFacts.fat }} g</p>
      <p>Calories: {{ totalNutritionFacts.calories }} kcal</p>
      <p>Sugar: {{ totalNutritionFacts.sugar }} g</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
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
    async fetchFavoriteFruits() {
      const response = await axios.get('http://localhost:3000/api/fruits/favorites');
      this.favoriteFruits = response.data.favoriteFruits;
      this.totalNutritionFacts = response.data.totalNutritionFacts;
    },
  },
  mounted() {
    this.fetchFavoriteFruits();
  },
};
</script>

