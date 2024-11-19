import { createStore } from 'vuex'

export const store = createStore({
    state: {
        user: null,

        loading: true,
    },

    mutations: {
        startLoading(state) {
            state.loading = true;
        },
        stopLoading(state) {
            state.loading = false;
        }
    },

    actions: {
        startLoading({ commit }, timeout = 500) {
            setTimeout(() => {
                commit('startLoading');
            }, timeout);
        },
        stopLoading({ commit }, timeout = 500) {
            setTimeout(() => {
                commit('stopLoading');
            }, timeout);
        }
    },

    getters: {
        loading(state) {
            return state.loading
        }
    },
})
