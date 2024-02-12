import './bootstrap';

import Vue from 'vue'
import App from '../vue/component/AppMain'

import { Icon } from 'leaflet';

import HighchartsVue from 'highcharts-vue'
import Highcharts from "highcharts";

delete Icon.Default.prototype._getIconUrl;
Icon.Default.mergeOptions({
  iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
  iconUrl: require('leaflet/dist/images/marker-icon.png'),
  shadowUrl: require('leaflet/dist/images/marker-shadow.png'),
});


Vue.use(HighchartsVue, {
  highcharts: Highcharts
})

const app = new Vue({
    el: '#app',
    components: { App, Icon }    
});