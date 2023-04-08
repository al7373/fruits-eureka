<!-- assets/vue/components/App.vue -->
<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col">
        <fruit-list @favorite-changed="updateFavoriteFruits"></fruit-list>
      </div>
      <div class="col">
        <favorite-fruits ref="favoriteFruits"></favorite-fruits>
      </div>
    </div>
  </div>
</template>

<script>
import FruitList from './FruitList';
import FavoriteFruits from './FavoriteFruits';

export default {
  components: {
    FruitList,
    FavoriteFruits,
  },
  methods: {
    updateFavoriteFruits() {
      this.$refs.favoriteFruits.fetchFavoriteFruits();
    },
  },
};
</script>

