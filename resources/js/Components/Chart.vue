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
        my_data: Object,
        yname: String,
        slug: String
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
            },
            scales: {
                y: {
                    title: {
                        display: true,
                        text: 'Number'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Day'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: '',
                    font: {
                        size: 28,
                        family: 'arial',
                        padding: 6
                    }
                }
            }
        },

      }
    },
    created(){

        if(this.slug != null){
            for(let apartment in this.my_data){
                if(this.slug == apartment){
                    this.data.datasets.push({
                        data: this.my_data[apartment],
                        label: this.decodeSlug(apartment),
                        borderColor: '#EF4444',
                        backgroundColor: '#EF4444',
                        tension: 0.3
                    })
                } else {
                    this.data.datasets.push({
                        data: this.my_data[apartment],
                        label: this.decodeSlug(apartment),
                        borderColor: '#a1a1aa',
                        backgroundColor: '#a1a1aa',
                        tension: 0.3
                    })
                }
            }
        } else {
            for(let apartment in this.my_data){
                this.data.datasets.push({
                    data: this.my_data[apartment],
                    label: this.decodeSlug(apartment),
                    tension: 0.3
                })
            }
        }

        this.options.scales.y.title.text = this.yname;

        this.options.plugins.title.text = 'Number of ' + this.yname + ' per days'


    },
    methods:{
        decodeSlug(string){
            const res = string.replace( /-/g , ' ');
            return res.charAt(0).toUpperCase() + res.slice(1);
        }
    }
  }
  </script>

