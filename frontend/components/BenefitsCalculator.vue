<template>
  <div class="benefits-calculator">
    <h2>Benefits Calculator</h2>
    <form @submit.prevent="calculateBenefits">
      <div class="form-group">
        <label>Income</label>
        <input v-model.number="income" type="number" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Household Size</label>
        <input v-model.number="householdSize" type="number" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-success">Calculate</button>
    </form>

    <div v-if="results" class="results mt-4">
      <h3>Eligible Benefits:</h3>
      <ul>
        <li v-for="benefit in results" :key="benefit.id">
          {{ benefit.name }}: {{ benefit.amount }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      income: 0,
      householdSize: 1,
      results: null
    }
  },
  methods: {
    async calculateBenefits() {
      try {
        const response = await this.$axios.post('/api/calculate-benefits', {
          income: this.income,
          householdSize: this.householdSize
        })
        this.results = response.data
      } catch (error) {
        console.error('Error calculating benefits:', error)
      }
    }
  }
}
</script> 