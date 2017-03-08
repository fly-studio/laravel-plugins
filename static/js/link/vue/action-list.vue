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
			return {
				list: this.parseValue(this.value)
			}
		},
		computed: {
			json() {
				return JSON.stringify(this.list/*, null, 4*/);
			},
		},
		methods: {
			parseValue(v) {
				let json = v;
				try {
					json = typeof v == 'string' ? JSON.parse(v) : v;
				} catch(e) {
					json = [];
				}
				return JSON.parse(JSON.stringify(json instanceof Array ? json : []));
			},
			create() {
				this.list.push({});
			},
			remove(k) {
				this.list.splice(k, 1);
			}
		},
		watch: {
			value(v) {
				this.$set(this, 'list', this.parseValue(v));
				if(this.$refs.action instanceof Array)
					this.$refs.action.forEach((v, k) =>{
						v.load(this.list[k]);
					});
			}
		}
	};
</script>