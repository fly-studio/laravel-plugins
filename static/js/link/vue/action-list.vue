<template>
	<div class="container12">
		<action v-for="(v, k) in list" :k="k" :key="k" v-model="list[k]"  @remove="remove" :name="name + '-' + k"></action>
		<a href="javascript:void(0);" @click="create" v-if="multiple"><i class="glyphicon glyphicon-plus"></i> 新增一条</a>
		<textarea class="form-control hidden" v-model="json" rows="10" :name="name"></textarea>
	</div>
</template>

<script>
	const parseValue = (v, multiple) => {
		let json = v;
		try {
			json = typeof v == 'string' ? JSON.parse(v) : v;
		} catch(e) {
			json = [];
		}
		//是单条，值不是数组，先转成数组
		if (!multiple && typeof json == 'object' && !(json instanceof Array))
			json = [].concat(json);
		//是多条 说明值有误
		else if (multiple && !(json instanceof Array))
			json = [];

		return JSON.parse(JSON.stringify(json instanceof Array ? json : []));
	};
	const store = () =>
		new Vuex.Store({
			state: {
				list: [],
				fields: [],
				multiple: false,
			},
			getters: {

			},
			mutations: {
				setMulti(state) {
					state.multiple = true;
				},
				create(state, attributes) {
					var obj = {title: '', img: '', method: 'redirect', parameters: {}};
					if (attributes)
					{
						attributes = JSON.parse(JSON.stringify(attributes));
						obj.title = attributes.title || obj.title;
						obj.img = attributes.img || obj.img;
						obj.method = attributes.method || obj.method;
						obj.parameters = attributes.parameters || obj.parameters;
					}
					console.log('create ', obj);
					state.fields.push({});
					state.list.push(obj);
				},
				remove(state, k) {
					console.log('remove ', k);
					state.fields.splice(k, 1);
					state.list.splice(k, 1);
				},
				removeAll(state) {
					console.log('removeAll');
					state.fields.splice(0, state.fields.length);
					state.list.splice(0, state.list.length);
				},
				setFields(state, {k, fields}) {
					if (typeof fields == 'undefined')
						return ;
					state.fields[k] = fields;
					let parameters = {};
					let p = JSON.parse(JSON.stringify(state.list[k].parameters));
					for(let f in fields)
					{
						parameters[f] = p && p[f] ? p[f] :
							(typeof fields[f] == 'string' ? null :
								(typeof fields[f].defaultValue != 'undefined' ? fields[f].defaultValue : null)
							);
					}
					state.list[k].parameters = parameters;
				},
			}
		});


	export default {
		props: ['value', 'name', 'multiple'],
		beforeCreate() {
			this.$store = store();
		},
		created() {
			if (this.multiple)
				this.$store.commit('setMulti');
			this.load(this.value);
		},
		computed: {
			...Vuex.mapState([
				'list',
				'fields',
			]),
			json() {
				let d = this.multiple ? this.$store.state.list : (this.$store.state.list[0] ? this.$store.state.list[0] : {});
				return JSON.stringify(d/*, null, 4*/);
			},
		},
		methods: {
			...Vuex.mapMutations([
				'create',
				'remove',
				'removeAll',
			]),
			load(v) {
				console.log('load value', v);
				let value = parseValue(v, this.multiple);
				for(let i = 0; i < value.length; ++i)
					this.$store.commit('create', value[i]);
			}
		},
		watch: {
			value(v) {
				console.log('change value', v);
				this.removeAll();
				this.load(v);
			}
		}
	};
</script>
