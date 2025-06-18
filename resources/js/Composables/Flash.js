import { ref, watchEffect } from "vue";

export function useFlash(props) {
    const successMessage = ref(null)

    watchEffect(() => {
        if (props.flash?.success) {
        successMessage.value = props.flash.success
        setTimeout(() => {
            successMessage.value = null
        }, 4000)
        }
    })

    return {
        successMessage
    }
}
