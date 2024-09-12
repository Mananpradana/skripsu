import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

// Pastikan Vuex diinisialisasi
Vue.use(Vuex);

const store = new Vuex.Store({
  state() {
    return {
      parah: 0,
      sedang: 0,
      rendah: 0
    };
  },
  mutations: {
    setParah(state, data) {
      state.parah = data;
    },
    setSedang(state, data) {
      state.sedang = data;
    },
    setRendah(state, data) {
      state.rendah = data;
    }
  },
  actions: {
    async getRange({ commit }) {
      try {
        const response = await axios.get('/config_range/get'); // Gunakan endpoint API Laravel Anda        
        const data = response.data;        
        commit('setParah', data.parah);
        commit('setSedang', data.sedang);
        commit('setRendah', data.rendah);
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    }
  },
  getters: {
    parah: (state) => state.parah,
    sedang: (state) => state.sedang,
    rendah: (state) => state.rendah
  }
});

export default store;