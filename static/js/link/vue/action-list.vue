<template>
	<div class="container12">
		<action v-for="(v, k) in list" v-model="list[k]" :k="k" @remove="remove" :name="name + '-' + k" ref="action"></action>
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
				json = typeof this.value == 'string' ? JSON.parse(this.value) : value;
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
				this.list.splice(k, 1);
				//this.$delete(this.list, k);
			},
			reload(v) {
				let json = v;
				try {
					json = typeof v == 'string' ? JSON.parse(v) : v;
				} catch(e) {
					json = [];
				}
				//this.list.splice(0, this.list.length);
				this.$set(this, 'list', json instanceof Array ? json : []);
			}
		},
		watch: {
		}
	};
</script>