<template>

    <form id="my-sample-form" method="post">
        <label for="card-number">Card Number</label>
        <div id="card-number"></div>

        <label for="cvv">CVV</label>
        <div id="cvv"></div>

        <label for="expiration-date">Expiration Date</label>
        <div id="expiration-date"></div>

        <input type="submit" value="Pay" disabled />
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
