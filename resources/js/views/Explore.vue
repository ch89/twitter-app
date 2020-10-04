<template>
	<div>
		<div class="flex justify-between items-center bg-white border-b p-4 sticky top-0 z-10">
			<h3 class="text-lg font-bold">Explore</h3>
			<i class="fas fa-cog text-xl text-blue"></i>
		</div>
		<router-link :to="`/profile/${user.name}`" v-for="user in users" :key="user.id" class="flex border-b p-4 hover:bg-gray-100">
			<img :src="user.avatar" alt="Avatar" class="w-12 rounded-full mr-4">
			<div>
				<div class="flex items-center">
					<h3 class="font-bold mr-2">{{ user.name }}</h3>
					<i class="fas fa-check-circle text-blue"></i>
				</div>
				<span class="text-sm text-dark">{{ user.tweets_count }} Tweets</span>
			</div>
			<i class="fas fa-angle-down text-dark ml-auto"></i>
		</router-link>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				users: []
			}
		},
		async beforeRouteEnter(to, from, next) {
			let response = await axios.get("/api/users")

			next(vm => vm.users = response.data)	
		},
	}
</script>