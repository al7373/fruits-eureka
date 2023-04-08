<!-- assets/vue/components/FavoriteFruits.vue -->
<template>
  <div class="container">
    <h1 class="my-4">Favorite Fruits</h1>
    <ul class="list-group mb-4">
      <li
        class="list-group-item d-flex justify-content-between align-items-center"
        v-for="fruit in favoriteFruits"
        :key="fruit.fruit_id"
      >
        <span>{{ fruit.name }} - {{ fruit.family }}</span>
      </li>
    </ul>
    <div>
      <h2>Sum of nutritions facts</h2>
      <table class="table table-striped">
        <tbody>
          <tr>
            <th scope="row">Carbohydrates</th>
            <td>{{ totalNutritionFacts.carbohydrates }} g</td>
          </tr>
          <tr>
            <th scope="row">Protein</th>
            <td>{{ totalNutritionFacts.protein }} g</td>
          </tr>
          <tr>
            <th scope="row">Fat</th>
            <td>{{ totalNutritionFacts.fat }} g</td>
          </tr>
          <tr>
            <th scope="row">Calories</th>
            <td>{{ totalNutritionFacts.calories }} kcal</td>
          </tr>
          <tr>
            <th scope="row">Sugar</th>
            <td>{{ totalNutritionFacts.sugar }} g</td>
          </tr>
        </tbody>
      </table>
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

