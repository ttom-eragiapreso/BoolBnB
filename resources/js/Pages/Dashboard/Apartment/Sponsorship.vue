<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { store } from "@/data/store";

export default {
    name: "Sponsorship",
    layout: AuthenticatedLayout,
    data() {
        return {
            store,
        };
    },
    mounted() {
        braintree.dropin.create(
            {
                authorization: store.BT_Token,
                container: "#dropin-container",
            },
            function (err, dropinInstance) {
                if (err) {
                    // Handle any errors that might've occurred when creating Drop-in
                    console.error(err);
                    return;
                }
                document
                    .getElementById("submit-button")
                    .addEventListener("click", function () {
                        dropinInstance.requestPaymentMethod(function (
                            err,
                            payload
                        ) {
                            if (err) {
                                console.log(err);
                                // Handle errors in requesting payment method
                            }
                            console.log(payload);
                            // Send payload.nonce to your server
                        });
                    });
            }
        );
    },
};
</script>

<template>
    <div class="max-w-screen-lg mx-auto">
        <div id="dropin-container"></div>
        <button
            id="submit-button"
            class="p-3 bg-blue-400 rounded-lg text-white"
        >
            Request payment method
        </button>
    </div>
</template>

<style></style>
