<template>
	<p>{{ notification.data.user.name }} liked your tweet</p>
</template>

<script>
	export default {
		props: ["notification"]
	}
</script>