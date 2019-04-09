import api from "../api/all";
import conversation from "./conversation";

const state = {
    conversations: ['ss'],
    loadingConversations: false
}

const getters = {

}

const actions = {
    getConversations({dispatch, commit}, page){
        console.log('get convers')
        //api req
        // api.getConversations(1).then((res) => {
        //     commit('setConversation', res.data)
        // })
        //set conv
    }
}

const mutations = {

}

const modules = {
    conversation: conversation
}

export default {
    state,
    getters,
    actions,
    mutations,
    modules,
}