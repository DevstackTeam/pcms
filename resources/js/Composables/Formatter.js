// resources/js/composables/useSanitizeInput.js

export function useSanitizeInput() {
  /**
   * Sanitizes input to accept only valid decimal numbers up to 2 places
   * and assigns the result to the specified key in the model.
   * 
   * @param {Event} event - Input event
   * @param {Object} model - Reactive object (e.g., manpower)
   * @param {String} key - Property to update (e.g., 'rate_per_day')
   */
  const sanitizeDecimalInput = (event, model, key) => {
    let val = event.target.value;
    val = val.replace(/[^0-9.]/g, '');

    if (val.includes('.')) {
      const [int, dec] = val.split('.');
      val = `${int}.${dec.slice(0, 2)}`;
    }

    model[key] = val;
    if (key === 'rate_per_day') {
      model.rate_locked = true;
    }
  };

  return { sanitizeDecimalInput };
}
