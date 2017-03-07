<template>
<div>
	<action-parameter v-for="(settings, key, index) in parameters" :settings="settings" class="" v-model="$store.state.parameters[key]"></action-parameter>
</div>
</template>

<script>
export default {
	data() {
		return {
			parameters: {
				url: {
					title: '网址',
					placeholder: 'https://',
					type: 'url'
				},
				target: {
					title: '跳转方式',
					type: 'radio',
					value:'_self',
					//multiple: true,
					list:{
						_self: '当前页面跳转',
						_blank: '新窗口打开',
					}
				}
			}
		};
	},
	activated() {
		this.$store.commit('setParameters', this.parameters);
	}
}
</script>