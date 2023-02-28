<template>
    <Pie :data="data" :options="options" />
</template>
1
<script>
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from "chart.js";
import { Pie } from "vue-chartjs";

ChartJS.register(ArcElement, Tooltip, Legend);

export default {
    name: "PieChart",
    props: {
        my_data: Object,
    },
    data() {
        return {
            data: {
                labels: [],
                datasets: [
                    {
                        backgroundColor: [
                            "#41B883",
                            "#E46651",
                            "#00D8FF",
                            "#DD1B16",
                        ],
                        data: [],
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRation: false,
            },
        };
    },
    components: {
        Pie,
    },
    methods: {
        decodeSlug(slug) {
            const res = slug.replace(/-/g, " ");
            return res.charAt(0).toUpperCase() + res.slice(1);
        },
    },

    created() {
        console.log(this.my_data);

        for (let apartment in this.my_data) {
            this.data.labels.push(this.decodeSlug(apartment));
            let total = 0;
            this.my_data[apartment].forEach((element) => {
                total += element.total;
            });
            this.data.datasets[0].data.push(total);
        }
    },
};
</script>
