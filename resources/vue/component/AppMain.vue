<template>
  <div class="col-12">
    <l-map
      ref="skripsuMap"
      style="height: calc(70vh - 50px); min-height: 550px"
      :zoom="zoom"
      :center="center"
    >
      <l-control class="example-custom-control p-2">
        <div class="col-12">
          <div class="mb-3 mt-1">
            <div class="col-12">
              <h6>Filter Periode :</h6>
              <VueDatePicker
                v-model="date"
                type="month"
                placeholder="Pilih Bulan"
                format="MM-YYYY"
                format-header="MM-YYYY"
              />
            </div>
            <div class="col-12 my-1">
              <h6>Filter Dominan</h6>
              <div class="d-flex flex-row my-1">
                <input
                  class="form-check-input"
                  type="checkbox"
                  id="filterDominanParah"
                  v-model="dominan"
                  value="parah"
                  checked
                />
                <label
                  class="form-check-label"
                  for="filterDominanParah"
                  style="
                    margin-left: 10px;
                    width: 50px;
                    font-size:14px; 
                    color: #a83232;
                  "
                >
                  Tinggi
                </label>
              </div>
              <div class="d-flex flex-row my-1">
                <input
                  class="form-check-input"
                  type="checkbox"
                  id="filterDominanSedang"
                  v-model="dominan"
                  value="sedang"
                  checked
                />
                <label
                  class="form-check-label"
                  for="filterDominanSedang"
                  style="
                    margin-left: 10px;
                    width: 50px;
                    font-size:14px;
                    color:#f59631;
                  "
                >
                  Sedang
                </label>
              </div>
              <div class="d-flex flex-row my-1">
                <input
                  class="form-check-input"
                  type="checkbox"
                  id="filterDominanAman"
                  v-model="dominan"
                  value="aman"
                  checked
                />
                <label
                  class="form-check-label"
                  for="filterDominanAman"
                  style="
                    margin-left: 10px;
                    width: 50px;
                    font-size:14px;
                    color:#32a852;
                  "
                >
                Rendah
                </label>
              </div>
            </div>
            <button
              class="btn btn-primary btn-sm mt-1 mx-1 float-end"
              @click="filterMonth"
            >
              Filter
            </button>
            <button
              class="btn btn-secondary btn-sm mt-1 mx-1 float-end"
              @click="resetFilter"
            >
              Reset
            </button>
          </div>
        </div>
      </l-control>

      <l-control class="example-custom-control p-2" position="bottomright">
        <div class="col-12" style="width: 100px">
          <div class="mb-3 mt-1">
            <div class="row">
              <div class="col-6 pe-0" >{{  '> '+parah  }}</div>
              <div class="col-6 ps-0">
                <div
                  style="
                    width: 100%;
                    height: 20px;
                    background: #a83232;
                    opacity: 0.5;
                  "
                ></div>
              </div>
            </div>
            <div class="row">
              <div class="col-6 pe-0">{{  sedang+' - '+parah  }} </div>
              <div class="col-6 ps-0">
                <div
                  style="
                    width: 100%;
                    height: 20px;
                    background: #f59631;
                    opacity: 0.5;
                  "
                ></div>
              </div>
            </div>
            <div class="row">
              <div class="col-6 pe-0">{{ rendah+' - '+sedang }}</div>
              <div class="col-6 ps-0">
                <div
                  style="
                    width: 100%;
                    height: 20px;
                    background: #32a852;
                    opacity: 0.5;
                  "
                ></div>
              </div>
            </div>
          </div>
        </div>
      </l-control>

      <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
      <!-- <l-marker :lat-lng="markerLatLng"></l-marker> -->
      <l-geo-json
        :geojson="geojson"
        :options="options"
        :options-style="layerStyle"
      ></l-geo-json>
    </l-map>

    <div class="d-flex justify-content-center py-3" style="height: 500px">
      <div class="col-6">
        <div class="row">
          <div class="col-6">
            <select
              class="form-select"
              aria-label="Default select example"
              v-model="chartFilterTahun"
            >
              <option value="">- Pilih Tahun -</option>
              <option value="2022">2022</option>
              <option value="2023">2023</option>              
              <option value="2024">2024</option>              
            </select>
          </div>
          <div class="col-6">
            <select
              class="form-select"
              aria-label="Default select example"
              v-model="chartFilterDesa"
            >
              <option value="">- Pilih Desa -</option>
              <option v-for="option in lokasi_desa" v-bind:value="option.id">
                {{ option.Desa }}
              </option>
            </select>
            <button
              class="btn btn-primary btn-sm mt-1 mx-1 float-end"
              style="max-width: 100px"
              @click="filterChart"
            >
              Filter Grafik
            </button>
          </div>
        </div>

        <highcharts class="hc" :options="chartOptions" ref="chart"></highcharts>
      </div>
    </div>

    <div
      class="modal fade"
      id="exampleModal"
      ref="modal"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" style="max-width: 1000px">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Pasien</h1>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Jenis Kelamin</th>
                  <th scope="col">Umur</th>
                  <th scope="col">Tanggal Periksa</th>
                  <th scope="col">Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(value, key) in detailPasien">
                  <th scope="row">{{ key + 1 }}</th>
                  <td>{{ value.jenis_kelamin }}</td>
                  <td>{{ value.umur }}</td>
                  <td>{{ value.tanggal_periksa }}</td>
                <td>{{ value.keterangan }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Close
            </button>            
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Chart } from "highcharts-vue";
import { mapGetters } from 'vuex';
import { LMap, LTileLayer, LMarker, LGeoJson, LControl } from "vue2-leaflet";
import "leaflet/dist/leaflet.css";
import { VueDatePicker } from "@mathieustan/vue-datepicker";
import "@mathieustan/vue-datepicker/dist/vue-datepicker.min.css";

export default {
  components: {
    LMap,
    LTileLayer,
    LMarker,
    LGeoJson,
    LControl,
    VueDatePicker,
    highcharts: Chart,
  },
  data() {
    return {
      url: "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
      attribution:
        '&copy; <a target="_blank" href="http://osm.org/copyright">OpenStreetMap</a> contributors',
      zoom: 12,
      center: [-1.9608189, 102.4151335],
      markerLatLng: [-1.9608189, 102.4151335],
      geojson: null,
      date: null,
      yearPeriode: null,
      lokasi_desa: [],
      dominan: [],      
      chartFilterTahun: '',
      chartFilterDesa: '',
      detailPasien: [
        {
          nama_pesien: "",
          umur: "",
          jenis_kelamin: "",
          tanggal_periksa: "",
        },
      ],
      map: this,
      chartOptions: {
        title: {
          text: "Chart",
        },
        chart: {
          type: "column",
        },
        plotOptions: {
          column: {
            dataLabels: {
              enabled: true,
            },
          },
        },
        yAxis: {
          title: {
            text: "Jumlah Pasien",
          },
        },
        xAxis: {
          title: {
            text: "Desa",
          },
          categories: []
        },
        series: {
          // name: "Jumlah Pasien",
          // data: [],
          // zones: [
          //   {
          //     value: this.rendah,
          //     color: "#32a852", // hijau
          //   },
          //   {
          //     value: this.sedang,
          //     color: "#f59631", // oren
          //   },
          //   {
          //     color: "#a83232", //merah
          //   },
          // ],
        },
      },
    };
  },
  computed: {
    ...mapGetters(['parah', 'sedang', 'rendah']),
    options() {
      return {
        onEachFeature: this.onEachFeatureFunction,
      };
    },
    onEachFeatureFunction() {
      return (feature, layer) => {
        parent = this;

        layer.bindTooltip(
          "<div>ID:" +
            feature.properties.id +
            "</div>" +
            "<div>Provinsi:" +
            feature.properties.Provinsi +
            "</div>" +
            "<div>Kabupaten: " +
            feature.properties.Kabupaten +
            "</div>" +
            "<div>Kecamatan: " +
            feature.properties.Kecamatan +
            "</div>" +
            "<div>Desa: " +
            feature.properties.Desa +
            "</div>" +
            "<div>Jumlah Pasien: " +
            feature.properties.Pasien +
            "</div>",
          { permanent: false, sticky: false }
        );

        layer.on("click", function (e) {          
          parent.$refs.skripsuMap.mapObject.fitBounds(layer.getBounds());
          parent.showModal(feature.properties.id);
        });
      };
    },
    layerStyle() {
      return (feature) => {
        return {
          weight: 2,
          color: "#ECEFF1",
          opacity: 1,
          fillColor: this.setLayerFillColor(
            parseInt(feature.properties.Pasien)
          ),
          fillOpacity: 0.5,
        };
      };
    },
  },
  async created() {
    await this.$store.dispatch('getRange');

    let year = new Date().getFullYear();
    year = year-1;
    const response = await fetch("/getMainMap?yearPeriod=" + year);
    this.geojson = await response.json();

    this.lokasi_desa = this.getLocationFromFilterMonth(this.geojson.features);

    this.chartOptions.title.text = this.geojson.chartTitle;
    this.chartOptions.xAxis = {
      crosshair: true,
      categories: this.geojson.chartXSeries,
    };
    
    // this.chartOptions.series.zones = [
    //         {
    //           value: this.sedang,
    //           color: "#32a852", // hijau
    //         },
    //         {
    //           value: this.parah,
    //           color: "#f59631", // oren
    //         },
    //         {
    //           color: "#a83232", //merah
    //         }
    //       ]    

    this.chartOptions.series = this.geojson.chartSeries; 
    console.log(this.chartOptions)
  },
  methods: {    
    filterMonth(idDesa) {
      
      var url = "/getMainMap";
      var param = {
        date: null,
        dominan: null,
      };
      parent = this;

      if(typeof idDesa === "string" ) {
        param.id_desa = idDesa
        this.chartFilterDesa = idDesa
      } else {
        this.chartFilterDesa = null
        this.chartFilterTahun = null
      }

      if (this.date !== null) {
        param.date = this.date;
      } else {
        param.yearPeriod = this.yearPeriode;
      }

      if (this.dominan !== null) {
        param.dominan = this.dominan;
      }
      
      axios.get(url, { params: param }).then(function (response) {
        parent.geojson = response.data;        
        
        if(parent.chartFilterDesa === null) {
            parent.$refs.chart.chart.update({
            xAxis: {
              crosshair: true,
              categories: parent.geojson.chartXSeries,
              title: {
                text: 'Desa'
              }
            }, 
            series: parent.geojson.chartSeries
          })
        }        
        
      });
      console.log(this.chartOptions)
    },
    getLocationFromFilterMonth(features) {
      var location = [];

      features.forEach((element) => location.push(element.properties));
      return location;
    },
    setLayerFillColor(d) {
      console.log('parah ' + this.parah)
      return d > this.parah
        ? "#a83232" // merah
        : d > this.sedang
        ? "#f59631" // oren
        : "#32a852"; // hijau
    },
    resetFilter() {
      let year = new Date().getFullYear();
      year = year-1;
      this.dominan = [];
      this.date = null;
      this.yearPeriode = year;

    },
    showModal(idDesa) {
      var parent = this;
      var url = "/getDetailMap";
      var param = {
        idDesa: idDesa,
      };

      if (this.date !== null) param.date = this.date
      else { 
        let year = new Date().getFullYear();
        year = year-1;
        param.yearPeriode = year
      }

      axios.get(url, { params: param }).then(function (response) {
        parent.detailPasien = response.data;
      });

      $("#exampleModal").modal("show");
    },
    filterChart() {

      var url = "/getChartSeries";
      var parent = this;
      var param = {
        tahun: this.chartFilterTahun,
        idDesa: this.chartFilterDesa,
      };

      if(param.tahun) this.date = null

      axios.get(url, { params: param }).then(function (response) {
        
        parent.$refs.chart.chart.update({
            xAxis: {
              crosshair: true,
              categories: response.data.chartXSeries,
              title: {
                text: "Bulan"
              }
            },
            series: response.data.chartSeries
        })

      });
      
      this.yearPeriode = this.chartFilterTahun
      if(param.idDesa !== null) this.filterMonth(param.idDesa)
      
    },
  },
};
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

