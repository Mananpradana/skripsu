<template>
    
    <div class="col-12">
        <l-map style="height: calc(100vh - 50px);" :zoom="zoom" :center="center">

            <l-control class="example-custom-control p-2">                
                <div class="col-12">
                    <div class="mb-3 mt-1">
                        <h6> Filter Bulan :</h6>
                        <VueDatePicker v-model="date" type="month" placeholder="Pilih Bulan" format="MM-YYYY" format-header="MM-YYYY" />                                                            
                        <button class="btn btn-primary mt-1 float-end" @click="filterMonth"> Filter </button>
                    </div>                                        
                </div>
                
            </l-control>

            <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
            <l-marker :lat-lng="markerLatLng"></l-marker>
            <l-geo-json :geojson="geojson" :options="options" :options-style="layerStyle"></l-geo-json>
            
        </l-map>
    </div>
</template>

<script>
import { LMap, LTileLayer, LMarker, LGeoJson, LControl } from 'vue2-leaflet';
import 'leaflet/dist/leaflet.css';
import { VueDatePicker } from '@mathieustan/vue-datepicker';
import '@mathieustan/vue-datepicker/dist/vue-datepicker.min.css';

export default {    
    components:{        
        LMap, LTileLayer, LMarker, LGeoJson, LControl, VueDatePicker
    }, 
    data() {
        return {
            url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            attribution:
                '&copy; <a target="_blank" href="http://osm.org/copyright">OpenStreetMap</a> contributors',
            zoom: 12,
            center: [-1.9608189, 102.4151335 ],
            markerLatLng: [-1.9608189, 102.4151335 ], 
            geojson: null, 
            date: null
        }
    }, 
    computed: {
        options() {
            return {
                onEachFeature: this.onEachFeatureFunction
            };
        },
        onEachFeatureFunction() {           
            return (feature, layer) => {
                layer.bindTooltip(
                "<div>ID:" + feature.properties.id + "</div>" +
                "<div>Provinsi:" + feature.properties.Provinsi + "</div>" +
                "<div>Kabupaten: " +feature.properties.Kabupaten +"</div>" +
                "<div>Kecamatan: " +feature.properties.Kecamatan +"</div>" +
                "<div>Desa: " +feature.properties.Desa +"</div>" +
                "<div>Jumlah Pasien: " +feature.properties.Pasien +"</div>",
                { permanent: false, sticky: true }
                );
            };
        },     
        layerStyle() {            
            return (feature) => {
                return {
                    weight: 2,
                    color: "#ECEFF1",
                    opacity: 1,
                    fillColor: this.setLayerFillColor(parseInt(feature.properties.Pasien)),
                    fillOpacity: 0.5
                };
            };
        }       
    },    
    async created () {
        const response = await fetch('/getMainMap');
        this.geojson = await response.json();
    },
    methods: {
        filterMonth() {
            var url = '/getMainMap';

            if(this.date !== null){ 
                url = url+'?date='+this.date;
                parent = this
                axios.get(url)
                .then(function(response){
                    parent.geojson = response.data
                })
                .catch(error => console.log(error))
            }
        }, 
        setLayerFillColor(d) {
            return d > 30  ? '#a83232' : // merah
                d > 15   ? '#f59631' :  // oren
                '#32a852'    // hijau
        }
    }
}

</script>


<style>
.example-custom-control {
  background: #fff;
  padding: 0 0.5em;
  border: 1px solid #aaa;
  border-radius: 0.1em;
}

</style>

