<template>

    <form id="my-sample-form" method="post" class="flex justify-center flex-col items-center">
        <label for="card-number">Card Number</label>
        <div id="card-number"></div>

        <label for="cvv">CVV</label>
        <div id="cvv"></div>

        <label for="expiration-date">Expiration Date</label>
        <div id="expiration-date"></div>

        <input @click="$emit('closeMyself')"  type="submit" value="Pay" disabled class="px-12 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer disabled:opacity-25 disabled:cursor-not-allowed"/>
    </form>

</template>

<script>

import { router } from "@inertiajs/vue3";
import { store } from "../data/store";

export default {
    name: "Payment",
    data() {
        return {
            store,
        };
    },
    methods:{
    },
    mounted() {

        let submit = document.querySelector('input[type="submit"]');
        let form = document.querySelector("#my-sample-form");

        braintree.client.create(
            {
                authorization: this.store.BT_Token,
            },
            function (clientErr, clientInstance) {

                if (clientErr) {
                    console.error(clientErr);
                    return;
                }

                braintree.hostedFields.create(
                    {
                        client: clientInstance,
                        styles: {
                            // Style all elements
                            input: {
                                "font-size": "16px",
                                color: "#3A3A3A",

                            },

                            // Styling a specific field
                            // Custom web fonts are not supported. Only use system installed fonts.
                            ".number": {
                                "font-family": "monospace",
                            },
                            ".cvv": {
                                "padding-left": "12px"
                            },
                            ".expirationDate": {
                                "padding-left": "12px"
                            },

                            // Styling element state
                            ":focus": {
                                color: "blue",
                            },
                            ".valid": {
                                color: "green",
                            },
                            ".invalid": {
                                color: "red",
                            },

                            // Media queries
                            // Note that these apply to the iframe, not the root window.
                            "@media screen and (max-width: 700px)": {
                                input: {
                                    "font-size": "14px",
                                },
                            },
                        },
                        fields: {
                            number: {
                                container: "#card-number",
                                placeholder: "4111 1111 1111 1111",
                            },
                            cvv: {
                                container: "#cvv",
                                placeholder: "123",
                            },
                            expirationDate: {
                                container: "#expiration-date",
                                placeholder: "10/2022",
                            },
                        },
                    },(hostedFieldsErr, hostedFieldsInstance) => {

                        if (hostedFieldsErr) {
                            console.error(hostedFieldsErr);
                            return;
                        }

                        submit.removeAttribute("disabled");

                        form.addEventListener("submit",(event) => {

                            event.preventDefault();

                            hostedFieldsInstance.tokenize((tokenizeErr,payload) => {

                                if (tokenizeErr) {
                                    console.error(tokenizeErr);
                                    return;
                                }

                                router.post(
                                    route("dashboard.transaction"),
                                    {
                                        payload: payload,
                                        target: store.target,
                                    }
                                );
                            });

                        },false);
                    }
                );
            }
        );
    },
};
</script>
<style lang="scss" scoped>
    #card-number, #cvv, #expiration-date {
        overflow: hidden;
        border: 1px solid #333;
        border-radius: 10px;
        height: 2.5rem;
        margin-bottom: 1rem;
        width: 35%;
        }
</style>
