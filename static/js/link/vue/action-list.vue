<template>
	<div class="container">
		<action v-for="(v, k) in list" v-model="list[k]" :k="k" @remove="remove" :name="name + '-' + k"></action>
		<a href="javascript:void(0);" @click="create()"><i class="glyphicon glyphicon-plus"></i> 新增一条</a>
		<textarea class="form-control hidden" v-model="json" rows="10" :name="name"></textarea>
	</div>
</template>

<script>
	export default {
		props: ['value', 'name'],
		data() {
			let json = [];
			try {
				json = typeof this.value == 'string' ? JSON.parse(this.value) : [];
			} catch(e) {
				json = [];
			}
			return {
				list: json instanceof Array ? json : []
			}
		},
		computed: {
			json() {
				return JSON.stringify(this.list, null, 4);
			},
		},
		methods: {
			create() {
				this.list.push({});
			},
			remove(k) {
				this.$delete(this.list, k);
			}
		}
	};
</script>