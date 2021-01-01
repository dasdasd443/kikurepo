import axios from 'axios';

const state = {
    productsData: []
};

const getters = {
    productsData: state => state.productsData
};

const actions = {
    async displayProductsData({commit}){
        const response = await axios.get('/api/products');

        commit('setProductsData',response.data);
    },
};

const mutations = {
    setProductsData: (state,products) => state.productsData = products
};

export default {
    state,
    getters,
    actions,
    mutations
};