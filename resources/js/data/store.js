import { reactive } from "vue";

export const store = reactive({
    filtered_type: null,
    searched_address: null,
    BT_Token: "sandbox_csdswdwm_4vzxvdhwmxsz2ggq",
    target: {
        apartment_id: 1,
        sponsorship_id: 3,
    },
    isProcessing: false
});
