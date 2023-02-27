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
  Legend
  } from 'chart.js'
  import { Line } from 'vue-chartjs'

  ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
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
        colors: ['red', 'yellow', 'blue', 'green', 'burlywood', 'cornflowerblue', 'coral', 'darkblue'],
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

        console.log(this.data.datasets);

        for(let apartment in this.my_data){
            this.data.datasets.push({
                data: this.my_data[apartment],
                label: apartment,
                borderColor: this.colors[Math.floor(Math.random()* this.colors.length)],
                backgroundColor: this.colors[Math.floor(Math.random()* this.colors.length)],

            })
        }


    }
  }
  </script>

