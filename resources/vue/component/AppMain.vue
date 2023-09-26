<template>

    <l-map style="height: 600px" :zoom="zoom" :center="center">
        <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
        <l-marker :lat-lng="markerLatLng"></l-marker>
        <l-geo-json :geojson="geojson" :options="options"></l-geo-json>
    </l-map>
</template>

<script>
import { LMap, LTileLayer, LMarker, LGeoJson } from 'vue2-leaflet';
import 'leaflet/dist/leaflet.css';

export default {    
    components:{        
        LMap, LTileLayer, LMarker, LGeoJson
    }, 
    data() {
        return {
            url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            attribution:
                '&copy; <a target="_blank" href="http://osm.org/copyright">OpenStreetMap</a> contributors',
            zoom: 12,
            center: [-1.9608189, 102.4151335 ],
            markerLatLng: [-1.9608189, 102.4151335 ], 
            geojson: null
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
                "<div>Provinsi:" + feature.properties.Provinsi + "</div>" +
                "<div>Kecamatan: " +feature.properties.Kecamatan +"</div>" +
                "<div>Kelurahan: " +feature.properties.Kelurahan +"</div>" +
                "<div>Desa: " +feature.properties.Desa +"</div>",
                { permanent: false, sticky: true }
                );
            };
        }
    },
    async created () {
        const response = await fetch('/getMainMap');
        this.geojson = await response.json();
    }
}

</script>

