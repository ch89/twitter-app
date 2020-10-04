<template>
	<div class="p-4">
		<form @submit.prevent="login">
			<input type="text" v-model="form.email">
			<input type="text" v-model="form.password">
			<button>Login</button>
		</form>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				form: {}
			}
		},
		methods: {
			login() {
				this.$store.dispatch("auth/login", this.form)
					.then(() => this.$router.push("/"))
			}
		}
	}
</script>