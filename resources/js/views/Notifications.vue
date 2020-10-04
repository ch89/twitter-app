<template>
	<div>
		<div class="bg-white border-b sticky top-0 z-10">
			<div class="flex justify-between items-center p-4">
				<h3 class="text-lg font-bold">Notifications</h3>
				<i class="fas fa-cog text-xl text-blue"></i>
			</div>
			<nav class="flex">
				<a href="#" class="flex-1 text-center font-bold text-dark p-4 hover:text-blue hover:bg-light-blue">All</a>
				<a href="#" class="flex-1 text-center font-bold text-dark p-4 hover:text-blue hover:bg-light-blue">Mentions</a>
			</nav>
		</div>
		<router-link :to="{ name: 'tweets', params: { name: notification.data.user.name } }" v-for="notification in notifications" :key="notification.id" class="flex border-b p-4 hover:bg-gray-100">
			<img :src="notification.data.user.avatar" alt="Avatar" class="w-12 rounded-full mr-4">
			<div>
				<component :is="notification.type" :notification="notification"></component>
				<span class="text-sm text-dark" v-text="notification.created_at"></span>
			</div>
		</router-link>
	</div>
</template>

<script>
	import TweetLiked from "../components/notifications/TweetLiked"
	import UserFollowed from "../components/notifications/UserFollowed"

	export default {
		components: { TweetLiked, UserFollowed },
		data() {
			return {
				notifications: []
			}
		},
		async beforeRouteEnter(to, from, next) {
			let response = await axios.get("/api/notifications")

			next(vm => vm.notifications = response.data)	
		}
	}
</script>