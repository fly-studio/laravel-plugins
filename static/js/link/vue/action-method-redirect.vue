<template>
<div>
	<action-parameter v-for="(settings, key) in fields" :settings="settings" class="" v-model="value[key]"></action-parameter>
</div>
</template>

<script>
export default {
	props: ['value'],
	data() {
		return {
			fields: {
				url: {
					title: '网址',
					placeholder: 'https://',
					type: 'url'
				},
				target: {
					title: '跳转方式',
					type: 'radio',
					defaultValue:'_self',
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
		console.log('change to redirect');
		this.$emit('fieldsChanged', this.fields);
	}
}
</script>