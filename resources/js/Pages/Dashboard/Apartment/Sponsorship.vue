<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { store } from "@/data/store";

export default {
    name: "Sponsorship",
    data() {
        return {
            store,
            submit: null,
            form: null,
            deviceData: null,
        };
    },
    components: {
        AuthenticatedLayout,
        Head,
    },
    mounted() {
        let submit = document.querySelector('input[type="submit"]');
        let form = document.querySelector("#my-sample-form");
        let deviceData;
        braintree.client.create(
            {
                authorization: this.store.BT_Token,
            },
            function (clientErr, clientInstance) {
                braintree.dataCollector.create(
                    {
                        client: clientInstance,
                    },
                    function (err, dataCollectorInstance) {
                        if (err) {
                            console.log(err);
                            return;
                        }
                        deviceData = dataCollectorInstance.deviceData;
                    }
                );

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
                    },
                    function (hostedFieldsErr, hostedFieldsInstance) {
                        if (hostedFieldsErr) {
                            console.error(hostedFieldsErr);
                            return;
                        }

                        submit.removeAttribute("disabled");

                        form.addEventListener(
                            "submit",
                            function (event) {
                                event.preventDefault();

                                hostedFieldsInstance.tokenize(function (
                                    tokenizeErr,
                                    payload
                                ) {
                                    if (tokenizeErr) {
                                        console.error(tokenizeErr);
                                        return;
                                    }

                                    // If this was a real integration, this is where you would
                                    // send the nonce to your server.

                                    router.post(
                                        route("dashboard.transaction"),
                                        {
                                            payload: payload,
                                            deviceData: deviceData,
                                        }
                                    );
                                    console.log(payload);
                                });
                            },
                            false
                        );
                    }
                );
            }
        );
    },
};
</script>

<template>
    <Head title="Sponsorship" />

    <AuthenticatedLayout>
        <template v-slot:header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Sponsorships
            </h2>
        </template>

        <div
            class="py-6 mt-12 max-w-[76rem] mx-auto sm:px-6 lg:px-8 bg-white sm:rounded-xl my-4"
        >
            <form
                :action="route('dashboard.transaction')"
                id="my-sample-form"
                method="post"
            >
                <label for="card-number">Card Number</label>
                <div id="card-number"></div>

                <label for="cvv">CVV</label>
                <div id="cvv"></div>

                <label for="expiration-date">Expiration Date</label>
                <div id="expiration-date"></div>

                <input type="submit" value="Pay" disabled />
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<style></style>
