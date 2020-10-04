<template>
	<div>
		<div class="flex justify-between items-center bg-white border-b p-4 sticky top-0 z-10">
			<h3 class="text-lg font-bold">Home</h3>
			<i class="far fa-star text-xl text-blue"></i>
		</div>
		<div class="border-b-8 p-4 flex items-start">
			<img :src="user.avatar" alt="Avatar" class="w-12 rounded-full mr-4">
			<form class="flex-1" @submit.prevent="add">
				<div class="mb-4">
					<textarea class="block w-full rounded focus:outline-none" :class="{ 'border border-red-500': errors.content }" placeholder="What's up?" v-model="form.content"></textarea>
					<span class="text-red-500 text-sm" v-if="errors.content" v-text="errors.content[0]"></span>
				</div>
				<div v-if="form.gif" class="relative">
					<img :src="form.gif" class="w-full rounded-xl mb-4">
					<a href="#" class="absolute top-4 right-4 bg-black bg-opacity-50 text-white rounded-full w-12 h-12 flex items-center justify-center" @click.prevent="form.gif = null">
						<i class="fas fa-times"></i>
					</a>
				</div>
				<div class="flex justify-between items-center">
					<div class="text-blue text-xl">
						<a href="#" class="mr-2" @click.prevent="show = true">
							<i class="far fa-image"></i>
						</a>
						<a href="#" class="mr-2">
							<i class="fas fa-film"></i>
						</a>
						<a href="#" class="mr-2">
							<i class="far fa-chart-bar"></i>
						</a>
						<a href="#">
							<i class="far fa-smile"></i>
						</a>
					</div>
					<button class="bg-blue text-white rounded-full font-bold px-4 py-2 hover:bg-dark-blue focus:outline-none">Tweet</button>
				</div>
			</form>
		</div>
		<tweet v-for="tweet in tweets" :key="tweet.id" :tweet="tweet"></tweet>
		<p v-if="! tweets.length" class="p-4">No tweets yet.</p>

		<modal title="Gif" v-show="show" @close="show = false">
			<input type="text" class="block border border-gray-300 rounded-lg py-2 px-4 w-full focus:outline-none focus:shadow-outline" placeholder="Search for gifs" v-model="key" @keyup.enter="search">

			<div class="grid grid-cols-3 gap-4 mt-4" v-if="gifs.length">
				<a href="#" v-for="(gif, index) in gifs" :key="index" @click.prevent="pick(gif)">
					<img :src="gif.images.original.url" class="rounded-lg">
				</a>
			</div>
		</modal>
	</div>
</template>

<script>
	import Tweet from "../components/Tweet"
	import { mapState } from "vuex"
	import store from "../store"

	export default {
		components: { Tweet },
		computed: {
			...mapState("tweet", ["tweets"]),
			...mapState("auth", ["user"])
		},
		data() {
			return {
				form: {
					gif: null
				},
				errors: {},
				show: false,
				key: "",
				gifs: []
			}
		},
		async beforeRouteEnter(to, from, next) {
			await store.dispatch("tweet/get")

			next()	
		},
		methods: {
			add() {
				this.$store.dispatch("tweet/add", this.form)
					.then(() => this.form = {})
					.catch(errors => this.errors = errors.response.data.errors)
			},
			async search() {
				let response = await axios.get(`https://api.giphy.com/v1/gifs/search?api_key=vU42qDdnpaBPLiU9ZQeQdH6edsj83DD9&q=${this.key}`)

				this.gifs = response.data.data
			},
			pick(gif) {
				this.show = false

				this.form.gif = gif.images.original.url
			}
		}
	}
</script>