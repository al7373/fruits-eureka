<!-- assets/vue/components/App.vue -->
<template>
  <div>
    <fruit-list @favorite-changed="updateFavoriteFruits"></fruit-list>
    <favorite-fruits ref="favoriteFruits"></favorite-fruits>
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

