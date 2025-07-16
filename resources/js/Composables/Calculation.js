import { watch } from 'vue'

export function useCostCalculator(form) {
  const calculateCost = (mp) => 
    (mp.no_of_people || 0) * (mp.total_day || 0) * (mp.rate_per_day || 0)

  // Watch manpower and calculate total cost
  watch(
    () => form.manpower,
    () => {
      let total = 0

      form.manpower.forEach((mp) => {
        const cost = calculateCost(mp)
        mp.total_cost = parseFloat(cost.toFixed(2))
        total += cost
      })

      form.total_cost = total.toFixed(2)
    },
    { deep: true }
  )

  // Watch markup and total_cost to update final_cost
  watch(
    () => [form.total_cost, form.markup],
    ([total_cost, markup]) => {
      const cost = parseFloat(total_cost)
      const percent = parseFloat(markup)

      if (!isNaN(cost) && !isNaN(percent)) {
        form.final_cost = ((100 + percent) / 100 * cost).toFixed(2)
      } else {
        form.final_cost = null
      }
    }
  )

  return {
    calculateCost
  }
}
