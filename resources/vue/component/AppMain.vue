<template>
    
    <div class="col-12">
        <l-map ref="skripsuMap" style="height: calc(70vh - 50px); min-height: 550px" :zoom="zoom" :center="center">

            <l-control class="example-custom-control p-2">                
                <div class="col-12">
                    <div class="mb-3 mt-1">
                        <div class="col-12">
                            <h6> Filter Periode :</h6>
                            <VueDatePicker v-model="date" type="month" placeholder="Pilih Bulan" format="MM-YYYY" format-header="MM-YYYY" />
                        </div>
                        <div class="col-12 my-1">
                            <h6> Filter Dominan</h6>  
                                <div class="d-flex flex-row my-1">
                                    <input class="form-check-input" type="checkbox" id="filterDominanParah" v-model="dominan" value="parah" checked >
                                    <label class="form-check-label" for="filterDominanParah" style="margin-left: 10px; width:50px; background: #a83232; opacity: 0.5; " >
                                            &nbsp;
                                    </label>
                                </div>                       
                                <div class="d-flex flex-row my-1">
                                    <input class="form-check-input" type="checkbox" id="filterDominanSedang" v-model="dominan" value="sedang" checked >
                                    <label class="form-check-label" for="filterDominanSedang" style="margin-left: 10px; width:50px; background: #f59631; opacity: 0.5; " >
                                            &nbsp;
                                    </label>
                                </div>                       
                                <div class="d-flex flex-row my-1">
                                    <input class="form-check-input" type="checkbox" id="filterDominanAman" v-model="dominan" value="aman" checked>
                                    <label class="form-check-label" for="filterDominanAman" style="margin-left: 10px; width:50px; background: #32a852; opacity: 0.5; " >
                                            &nbsp;
                                    </label>
                                </div>                          
                                
                        </div>
                        <button class="btn btn-primary mt-1 float-end" @click="filterMonth"> Filter </button>
                    </div>                                        
                </div>
                
            </l-control>

            <l-control class="example-custom-control p-2" position="bottomright">
                <div class="col-12" style="width: 100px">
                    <div class="mb-3 mt-1">
                        <div class="row">
                            <div class="col-6 pe-0">
                                > 30
                            </div>
                            <div class="col-6 ps-0">
                                <div style="width: 100%; height: 20px; background: #a83232; opacity: 0.5; "></div>
                            </div>                                
                        </div>
                        <div class="row">
                            <div class="col-6 pe-0">
                                16 - 30
                            </div>
                            <div class="col-6 ps-0">
                                <div style="width: 100%; height: 20px; background: #f59631; opacity: 0.5; "></div>
                            </div>                                
                        </div>
                        <div class="row">
                            <div class="col-6 pe-0">
                                0 - 15
                            </div>
                            <div class="col-6 ps-0">
                                <div style="width: 100%; height: 20px; background: #32a852; opacity: 0.5; "></div>
                            </div>                                
                        </div>                        
                    </div>     
                </div>
            </l-control>

            <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
            <!-- <l-marker :lat-lng="markerLatLng"></l-marker> -->
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
            date: null, 
            dominan: [],
            map: this
        }
    }, 
    computed: {
        options() {
            return {
                onEachFeature: this.onEachFeatureFunction, 

            };
        },
        onEachFeatureFunction() {
            return (feature, layer) => {

                parent = this

                layer.bindTooltip(
                "<div>ID:" + feature.properties.id + "</div>" +
                "<div>Provinsi:" + feature.properties.Provinsi + "</div>" +
                "<div>Kabupaten: " +feature.properties.Kabupaten +"</div>" +
                "<div>Kecamatan: " +feature.properties.Kecamatan +"</div>" +
                "<div>Desa: " +feature.properties.Desa +"</div>" +
                "<div>Jumlah Pasien: " +feature.properties.Pasien +"</div>",
                { permanent: false, sticky: false }
                );        

                layer.on('click', function(e) {                    
                    parent.$refs.skripsuMap.mapObject.fitBounds(layer.getBounds())
                })
                
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
            parent = this

            if(this.date !== null){ 
                url = url+'?date='+this.date;                                
            }

            if(this.dominan !== null){ 
                url = url+'?dominan='+this.dominan;                                
            }

            axios.get(url)
            .then(function(response){
                parent.geojson = response.data
            })
            //.catch(error => console.log(error))

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

path.leaflet-interactive:focus {
    outline: none;
}

</style>

