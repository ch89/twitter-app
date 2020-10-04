<template>
	<div class="w-1/4 p-4 flex flex-col">
		<router-link to="/login" class="text-blue text-3xl ml-4">
			<i class="fab fa-twitter"></i>
		</router-link>
		<div class="my-4">
			<router-link :to="link.path ? link.path : '#'" v-for="(link, index) in links" :key="index" class="flex items-center p-4 rounded-full hover:text-blue hover:bg-light-blue">
				<i class="fa-fw text-2xl mr-4" :class="link.icon"></i>
				<span class="text-lg font-bold" v-text="link.title"></span>
			</router-link>
		</div>
		<button class="bg-blue text-white w-full rounded-full font-bold p-3 hover:bg-dark-blue focus:outline-none">Tweet</button>
		<button class="flex items-center w-full rounded-full p-4 mt-auto hover:bg-light-blue focus:outline-none" v-if="user" @click="logout">
			<img :src="user.avatar" alt="Avatar" class="w-12 rounded-full mr-4">
			<div>
				<span class="block text-sm font-bold text-left">{{ user.name }}</span>
				<span class="block text-sm">@{{ user.name }}</span>
			</div>
			<i class="fas fa-angle-down ml-auto"></i>
		</button>
	</div>
</template>

<script>
	import { mapState } from "vuex"

	export default {
		computed: mapState("auth", ["user"]),
		data() {
			return {
				links: [
					{icon: 'fas fa-home', title: 'Home', id:'home', path: "/"},
					{icon: 'fas fa-hashtag', title: 'Explore', id: 'explore', path: "/explore"},
					{icon: 'far fa-bell', title: 'Notifications', id: 'notifications'},
					{icon: 'far fa-envelope', title: 'Messages', id: 'messages'},
					{icon: 'far fa-bookmark', title: 'Bookmarks', id: 'bookmarks'},
					{icon: 'fas fa-clipboard-list', title: 'Lists', id: 'lists'},
					{icon: 'far fa-user', title: 'Profile', id: 'profile'},
					{icon: 'fas fa-ellipsis-h', title: 'More', id: 'more'}
				]
			}
		},
		methods: {
			async logout() {
				await this.$store.dispatch("auth/logout")

				if(this.$route.meta.auth) this.$router.push("/login")
			}
		}
	}
</script>