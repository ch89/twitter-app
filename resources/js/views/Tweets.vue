<template>
	<div>
		<tweet v-for="tweet in user.tweets" :key="tweet.id" :tweet="tweet"></tweet>
		<p v-if="! user.tweets.length" class="p-4">No tweets yet.</p>
	</div>
</template>

<script>
	import Tweet from "../components/Tweet"

	export default {
		props: ["user"],
		components: { Tweet }
	}
</script>