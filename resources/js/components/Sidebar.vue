<template>
	<div class="w-1/4 p-4">
		<div class="flex items-center bg-gray-200 rounded-full px-4 py-3 mb-4">
			<i class="fas fa-search text-dark mr-2"></i>
			<input type="text" placeholder="Search Twitter" class="flex-1 bg-transparent focus:outline-none">
		</div>
		<div class="bg-gray-100 rounded-xl overflow-hidden mb-4">
			<div class="flex justify-between items-center p-4">
				<h3 class="text-lg font-bold">Trends for you</h3>
				<i class="fas fa-cog text-lg text-blue"></i>
			</div>
			<a href="#" class="flex justify-between border-t p-4 hover:bg-gray-200" v-for="(trend, index) in trending" :key="index">
				<div>
					<span class="block text-sm text-dark" v-text="trend.top"></span>
					<span class="block text-sm font-bold" v-text="trend.title"></span>
					<span class="block text-sm text-dark" v-text="trend.bottom"></span>
				</div>
				<i class="fas fa-angle-down text-dark"></i>
			</a>
		</div>
		<div class="bg-gray-100 rounded-xl overflow-hidden">
			<h3 class="text-lg font-bold p-4">Who to Follow</h3>
			<router-link :to="{ name: 'profile', params: { name: user.name } }" class="flex items-center border-t p-4 hover:bg-gray-200" v-for="user in users" :key="user.id">
				<img :src="user.avatar" alt="Avatar" class="w-12 rounded-full mr-4">
				<div>
					<div class="flex items-center">
						<span class="block text-sm font-bold mr-2" v-text="user.name"></span>
						<i class="fas fa-check-circle text-blue"></i>
					</div>
					<span class="block text-sm text-dark">@{{ user.name }}</span>
				</div>
				<button class="text-sm font-bold rounded-full border border-blue px-4 py-1 ml-auto focus:outline-none" :class="user.followed ? 'bg-blue text-white' : 'text-blue'" @click.prevent="follow(user)">Follow</button>
			</router-link>
			<a href="#" class="block text-blue border-t p-4 hover:bg-gray-200">Show More</a>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				trending: [
        			{top: 'Trending in TX', title: 'Gigi', bottom: 'Trending with: Rip Gigi'},
        			{top: 'Music', title: 'We Won', bottom: '135K Tweets'},
        			{top: 'Pop', title: 'Blue Ivy', bottom: '40k tweets'}
      			],
      			users: []
			}
		},
		async created() {
			let response = await axios.get("/api/users")

			this.users = response.data
		},
		methods: {
			follow(user) {
				axios.post(`/api/users/${user.id}/follow`)
					.then(() => user.followed = ! user.followed)
			}
		}
	}
</script>