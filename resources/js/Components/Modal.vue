
<template>
  <div
    class="modal-overlay show d-flex justify-content-center align-items-center"
    style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1050;"
  >
    <div
      class="modal-content p-3 p-sm-4 bg-white rounded shadow"
      style="width: 90%; max-width: 500px;"
    >
      <div class="modal-header border-bottom mb-3">
        <h5 class="modal-title fs-6 fs-sm-5">
          <slot name="title" />
        </h5>
        <button type="button" class="btn-close" @click="$emit('close')"></button>
      </div>

      <div class="modal-body">
        <slot name="body" />
      </div>
    </div>
  </div>
</template>
