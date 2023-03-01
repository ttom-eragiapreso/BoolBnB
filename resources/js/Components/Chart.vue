<template>
    <Line :data="data" :options="options" />
  </template>

  <script>
  import {
    Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
  Colors
  } from 'chart.js'
  import { Line } from 'vue-chartjs'

  ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
  Colors
)

  export default {
    name: 'Chart',
    components: {
      Line
    },
    props:{
        my_data: Object
    },
    data() {
      return {
        data : {
            datasets: []
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            parsing: {
                xAxisKey: 'date',
                yAxisKey: 'total'
            }
        },

      }
    },
    created(){


        for(let apartment in this.my_data){
            this.data.datasets.push({
                data: this.my_data[apartment],
                label: this.decodeSlug(apartment),
            })
        }


    },
    methods:{
        decodeSlug(string){
            const res = string.replace( /-/g , ' ');
            return res.charAt(0).toUpperCase() + res.slice(1);
        }
    }
  }
  </script>

