<template>
	<div>
		<div class="flex items-center bg-white border-b p-4 sticky top-0 z-10">
			<a href="#" class="text-lg text-blue mr-4" @click.prevent="$router.back()">
				<i class="fas fa-arrow-left"></i>
			</a>
			<h3 class="text-lg font-bold">{{ user.name }}</h3>
			<span class="text-sm text-dark ml-auto">{{ user.tweets.length }} Tweets</span>
		</div>

		<div>
			<div class="relative">
				<img src="https://placeimg.com/640/480/any" alt="Banner" class="h-48 w-full object-cover object-center">
				<img :src="user.avatar" alt="Avatar" class="w-32 rounded-full border-4 border-white absolute left-1/2 transform -translate-x-1/2 -translate-y-1/2">
			</div>
			<div class="flex justify-between p-4">
				<div>
					<div class="flex items-center">
						<h3 class="font-bold mr-2">{{ user.name }}</h3>
						<i class="fas fa-check-circle text-blue mr-2"></i>
					</div>
					<span class="text-sm text-dark">@{{ user.name }}</span>
					<div class="flex items-center">
						<i class="far fa-clock mr-2"></i>
						<span class="text-sm text-dark">Joined {{ user.created_at }}</span>
					</div>
					<div class="flex text-sm">
						<div class="mr-2">
							<span class="font-bold" v-text="user.following_count"></span>
							<span class="text-dark">Following</span>
						</div>
						<div>
							<span class="font-bold" v-text="user.followers_count"></span>
							<span class="text-dark">Followers</span>
						</div>
					</div>
				</div>
				<div>
					<button class="text-blue rounded-full border border-blue font-bold px-4 py-2 focus:outline-none" v-if="user.can.update" @click="edit">Set up profile</button>
					<button class="rounded-full border border-blue font-bold px-4 py-2 focus:outline-none" :class="user.followed ? 'bg-blue text-white' : 'text-blue'" v-else @click="follow">Follow</button>
				</div>
			</div>
			<nav class="border-b flex">
				<router-link :to="{ name: 'tweets' }" class="p-4 flex-auto text-center font-bold text-dark hover:text-blue hover:bg-light-blue">Tweets</router-link>
				<router-link :to="{ name: 'replies' }" class="p-4 flex-auto text-center font-bold text-dark hover:text-blue hover:bg-light-blue">Tweets & Replies</router-link>
				<router-link :to="{ name: 'media' }" class="p-4 flex-auto text-center font-bold text-dark hover:text-blue hover:bg-light-blue">Media</router-link>
				<router-link :to="{ name: 'likes' }" class="p-4 flex-auto text-center font-bold text-dark hover:text-blue hover:bg-light-blue">Likes</router-link>
			</nav>
		</div>

		<transition mode="out-in">
			<router-view :user="user"></router-view>
		</transition>
		
		<modal v-show="show" @close="close" title="Edit Profile">
			<form id="edit-form" @submit.prevent="update">
				<div class="mb-4">
					<label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
					<input type="text" name="name" class="block border border-gray-300 rounded-lg py-2 px-4 w-full focus:outline-none focus:shadow-outline" v-model="form.name">
				</div>
				<div>
					<label for="avatar" class="block text-gray-700 text-sm font-bold mb-2">Avatar</label>
					<input type="file" name="avatar" class="block border border-gray-300 rounded-lg py-2 px-4 w-full focus:outline-none focus:shadow-outline">
				</div>
			</form>

			<button class="btn mr-2" form="edit-form" slot="footer">Update</button>
		</modal>
	</div>
</template>

<script>
	import { mapState } from "vuex"

	export default {
		props: ["name"],
		computed: mapState(["auth"]),
		data() {
			return {
				user: {
					tweets: [],
					can: {}
				},
				show: false,
				form: {}
			}
		},
		async beforeRouteEnter(to, from, next) {
			let response = await axios.get(`/api/users/${to.params.name}`)
			
			next(vm => vm.user = response.data)
		},
		async beforeRouteUpdate(to, from, next) {
			let response = await axios.get(`/api/users/${to.params.name}`)
			
			this.user = response.data

			next()
		},
		methods: {
			follow() {
				axios.post(`/api/users/${this.user.id}/follow`)
					.then(() => this.user.followed = ! this.user.followed)
			},
			edit() {
				this.show = true

				this.form = { ...this.auth.user }
			},
			close() {
				this.show = false

				this.form = {}
			},
			update(e) {
				axios.post(`/api/users/${this.user.id}`, new FormData(e.target))
					.then(response => {
						Object.assign(this.user, response.data)

						this.close()

						this.$router.replace({ 
							name: "tweets", 
							params: { 
								name: this.user.name 
							} 
						})
					})
			}
		}
	}
</script>

<style scoped>
	.v-enter-active, .v-leave-active {
		transition: opacity .5s;
	}

	.v-enter, .v-leave-to {
		opacity: 0;
	}
</style>