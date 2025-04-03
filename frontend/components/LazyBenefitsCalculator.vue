<template>
  <div>
    <button @click="loadCalculator" class="btn btn-primary">
      Calculate Benefits
    </button>
    <component :is="calculatorComponent" v-if="showCalculator" />
  </div>
</template>

<script>
export default {
  data() {
    return {
      showCalculator: false,
      calculatorComponent: null
    }
  },
  methods: {
    async loadCalculator() {
      this.calculatorComponent = await import('~/components/BenefitsCalculator.vue')
      this.showCalculator = true
    }
  }
}
</script> 