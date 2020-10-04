<template>
	<transition name="modal">
		<div class="absolute inset-0 z-50 bg-black bg-opacity-50 flex justify-center items-center">
			<div class="bg-white rounded-lg overflow-hidden w-1/3">
				<div class="flex justify-between items-center p-4">
					<h3 class="text-lg font-bold">{{ title }}</h3>
					<button @click="$emit('close')">
						<i class="fas fa-times"></i>
					</button>
				</div>
				<div class="border-t border-b max-h-lg overflow-auto p-4">
					<slot></slot>
				</div>
				<div class="flex justify-end p-4">
					<slot name="footer"></slot>
					<button class="btn" @click="$emit('close')">Close</button>
				</div>
			</div>
		</div>
	</transition>
</template>

<script>
	export default {
		props: ["title"]
	}
</script>

<style scoped>
	.modal-enter-active, .modal-leave-active {
		transition: opacity .5s;
	}

	.modal-enter, .modal-leave-to {
		opacity: 0;
	}
</style>