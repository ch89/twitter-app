<template>
	<div class="flex items-start border-b p-4 hover:bg-gray-100">
		<img :src="tweet.user.avatar" alt="Avatar" class="w-12 rounded-full mr-4">
		<div class="flex-1">
			<div class="flex items-center">
				<!-- <span class="font-bold mr-2">{{ tweet.user.name }}</span> -->
				<router-link :to="`/users/${tweet.user.name}`" class="font-bold mr-2">{{ tweet.user.name }}</router-link>
				<i class="fas fa-check-circle text-blue mr-2"></i>
				<span class="text-sm text-dark mr-2">@kalleanka</span>
				<span class="text-sm text-dark">{{ tweet.created_at }}</span>
				<i class="fas fa-angle-down text-dark ml-auto"></i>
			</div>
			<p class="my-2">{{ tweet.content }}</p>
			<img :src="tweet.gif" alt="gif" v-if="tweet.gif" class="w-full rounded-xl mb-4">
			<div class="flex justify-between items-center text-dark text-sm">
				<a href="#">
					<i class="far fa-comment"></i>
					<span>3</span>
				</a>
				<a href="#">
					<i class="fas fa-retweet"></i>
					<span>3</span>
				</a>
				<a href="#" :class="{ 'text-red': tweet.liked }" @click.prevent="like">
					<i class="fas fa-heart"></i> {{ tweet.likes_count }}
				</a>
				<a href="#" @click.prevent="remove(tweet)">
					<i class="fas fa-share-square"></i>
					<span>3</span>
				</a>
			</div>
		</div>
	</div>
</template>

<script>
	import { mapActions } from "vuex"

	export default {
		props: ["tweet"],
		methods: {
			...mapActions("tweet", ["remove"]),
			like() {
				axios.post(`/api/tweets/${this.tweet.id}/like`)
					.then(() => {
						this.tweet.liked = ! this.tweet.liked
						this.tweet.liked ? this.tweet.likes_count++ : this.tweet.likes_count--
					})
			}
		}
	}
</script>