<template>
  <div
    class="modal-overlay show"
    style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1050;"
  >
    <div class="modal-dialog" style="margin: 10% auto; max-width: 500px;">
      <div class="modal-content bg-white rounded shadow">
        <div class="p-4 pb-3">
          <div class="modal-header px-0">
            <h5 class="modal-title"><slot name="title" /></h5>
            <button type="button" class="btn-close" @click="$emit('close')"></button>
          </div>
        </div>

        <!-- Full-width separator -->
        <hr class="m-0" />

        <div class="modal-body p-4 pt-3">
          <slot name="body" />
        </div>
      </div>
    </div>
  </div>
</template>
