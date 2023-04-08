<!-- assets/vue/components/FruitList.vue -->
<template>
  <div class="container">
    <h1 class="my-4">Fruits List</h1>

    <form>
      <div class="form-group">
        <label for="name">Fruit name:</label>
        <input
          type="text"
          id="name"
          v-model="filters.name"
          @input="fetchFruits"
          class="form-control"
        />
      </div>

      <div class="form-group">
        <label for="family">Family:</label>
        <input
          type="text"
          id="family"
          v-model="filters.family"
          @input="fetchFruits"
          class="form-control"
        />
      </div>
    </form>

    <ul class="list-group mb-4">
      <li
        class="list-group-item d-flex justify-content-between align-items-center"
        v-for="fruit in fruits"
        :key="fruit.id"
      >
        {{ fruit.name }} - {{ fruit.family }}
        <button
          class="btn btn-sm"
          :class="{ 'btn-primary': !fruit.isFavorite, 'btn-danger': fruit.isFavorite }"
          @click="toggleFavorite(fruit)"
        >
          {{ fruit.isFavorite ? 'Remove from favorite' : 'Add to favorite' }}
        </button>
      </li>
    </ul>

    <div class="d-flex justify-content-center">
      <button
        class="btn btn-primary mx-2"
        @click="changePage(-1)"
        :disabled="currentPage === 1"
      >
        Previous
      </button>
      <span>Page {{ currentPage }}</span>
      <button class="btn btn-primary mx-2" @click="changePage(1)">Next</button>
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
      this.$emit('favorite-changed', fruit);
    },
  },
  mounted() {
    this.fetchFruits();
  },
};
</script>

