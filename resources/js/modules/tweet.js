export default {
	namespaced: true,
    state: {
    	tweets: []
    },
    mutations: {
    	get(state, tweets) {
    		state.tweets = tweets
    	},
    	add(state, tweet) {
    		state.tweets.unshift(tweet)
    	},
    	remove(state, tweet) {
    		state.tweets.splice(state.tweets.indexOf(tweet), 1)
    	}
    },
    actions: {
    	async get({ commit }) {
    		let response = await axios.get("/api/tweets")

    		commit("get", response.data)
    	},
    	add({ commit }, form) {
    		return axios.post("/api/tweets", form)
    			.then(response => commit("add", response.data))
    	},
    	remove({ commit }, tweet) {
    		axios.delete(`/api/tweets/${tweet.id}`)
    			.then(() => commit("remove", tweet))
    	}
    }
}