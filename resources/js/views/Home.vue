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
				<div class="flex justify-between items-center">
					<div class="text-blue text-xl">
						<a href="#" class="mr-2">
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
				form: {},
				errors: {}
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
			}
		}
	}
</script>