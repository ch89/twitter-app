export default {
	namespaced: true,
    state: {
    	token: null,
    	user: null
    },
    mutations: {
    	add(state, auth) {
            Object.assign(state, auth)

            localStorage.setItem("auth", JSON.stringify(auth))

            axios.defaults.headers.common["Authorization"] = `Bearer ${auth.token}`
    	},
        remove(state) {
            Object.assign(state, {
                token: null,
                user: null
            })

            localStorage.removeItem("auth")

            axios.defaults.headers.common["Authorization"] = null
        }
    },
    actions: {
    	login({ commit }, form) {
            return axios.post("/api/login", form)
                .then(response => commit("add", response.data))
        },
        logout({ commit }) {
            return axios.post("/api/logout")
                .then(() => commit("remove"))
        }
    }
}