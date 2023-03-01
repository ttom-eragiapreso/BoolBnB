import { reactive } from "vue";

export const store = reactive({
    filtered_type: null,
    searched_address: null,
    API_Key_TomTom: 'LyiQawx4xo4FpPG8VKyj3yHadh1WEDRM',
    BT_Token: "sandbox_csdswdwm_4vzxvdhwmxsz2ggq",
    target: {
        apartment_id: 1,
        sponsorship_id: 3,
    },
    isProcessing: false
});
