<template>
	<p>{{ notification.data.user.name }} is now following you</p>
</template>

<script>
	export default {
		props: ["notification"]
	}
</script>