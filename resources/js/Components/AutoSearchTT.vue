<script>

import * as ttServices from "@tomtom-international/web-sdk-services";
import SearchBox from '@tomtom-international/web-sdk-plugin-searchbox';

export default{
    name: 'AutoSearchTT',
    data(){
        return{
            searchBoxOptions: {
                idleTimePress: 200,
                minNumberOfCharacters: 3,
                searchOptions: {
                    key: 'LyiQawx4xo4FpPG8VKyj3yHadh1WEDRM',
                    language: 'en-GB',
                    limit: 20,
                    idxSet: this.idxSet
                },
                labels: {
                    noResultsMessage: 'No results found.'
                }
            }
        }
    },
    props:{
        idxSet: String,
        address: {
            type: String,
            required: false,
            default: null,
        }
    },
    methods:{
        handleResultSelection(e){

            const results = e.data.result;

            this.$emit('geodata', {
                city: results.address.municipality,
                country: results.address.country,
                full_address: results.address.freeformAddress,
                lat: results.position.lat,
                lng: results.position.lng
            })

        },
        handleResultsCleared(){
            this.$emit('geodata', {
                    city: null,
                    country: null,
                    full_address: null,
                    lat: null,
                    lng: null
                })
        },
        createSearchBox(){
            // creo il mio searchbox
            const mySearchBox = new SearchBox(ttServices.services, this.searchBoxOptions);
            // lo scrivo nel dom
            document.querySelector('#searchbox').appendChild(mySearchBox.getSearchBoxHTML());
            // prendo l'evento quando io seleziono una opzione
            mySearchBox.on('tomtom.searchbox.resultselected', this.handleResultSelection);
            // quando noi cancelliamo i dati dall'input
            mySearchBox.on('tomtom.searchbox.resultscleared', this.handleResultsCleared);
            // Se ho gia qualcosa da mettere dentro
            if (this.address) mySearchBox.setValue(this.address);
        }
    },
    mounted(){
        this.createSearchBox();

        document.querySelector('.tt-search-box-input').placeholder = 'Ex. Rome, Italy'
    }
}

</script>

<template>

    <div id="searchbox"></div>

</template>

<style>

@import '../../../node_modules/@tomtom-international/web-sdk-plugin-searchbox/dist/SearchBox.css';

/* Edit Search box like default ones */
#searchbox .tt-search-box{
    border: 1px solid #6b7280;
    font-family: inherit !important;
    margin-block: 8px;
    border-radius: 20px;
}

#searchbox .tt-search-box input{
    font-size: 1rem;
}

#searchbox .tt-search-box-input-container{
    padding: 0.5rem 0.75rem;
    border-radius: 20px;
}

#searchbox .tt-search-box-input-container.-focused{
    border: 1px solid #6b7280;
    border-radius: 20px;
    box-shadow: none;
}

#searchbox .tt-search-box-result-list-container{
    transform: translateY(5px) translateX(-2px);
    width: calc(100% + 4px);
}

</style>
