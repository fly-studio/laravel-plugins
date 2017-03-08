<template>
<div class="">
	<div class="page-header">
		<h3>
			{{$store.state.title ? $store.state.title : '未命名'}}
			<span class="pull-right action-remove" v-if="k != undefined">
				<a href="javascript:" @click="remove()">&times;</a>
			</span>
		</h3>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<label for="" class="col-sm-2 control-label">标题：</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" v-model="$store.state.title">
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="form-group">
			<label for="" class="col-sm-2 control-label">图片：</label>
			<div class="col-sm-10">
				<image-upload v-model="$store.state.img"></image-upload>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<div class="action-parameter col-sm-6">
		<div class="form-group">
			<label for="" class="col-sm-2">类型：</label>
			<div class="col-sm-10">
				<select class="form-control" v-model="$store.state.method">
					<option :value="key" v-for="(name, key) in methods">{{name}}</option>
				</select>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="form-group">
			<div class="col-sm-12">
				<h5 class="page-header">参数：</h5>
			</div>
			<div class="clearfix"></div>
			<keep-alive>
				<component :is="'action-method-' + method" :parameters="parameters"></component>
			</keep-alive>
		</div>
	</div>
	<div class="clearfix"></div>
	<textarea class="form-control hidden" v-model="json" rows="10" :name="name"></textarea>
</div>
</template>

<style>
.action-parameter .page-header {margin: 0 0 5px 0}
.action-remove {margin-right: 25px;}
</style>

<script>
	const methods = {
		'redirect': '跳转链接'
	};
	for(let key in methods)
		Vue.component(
			'action-method-'+ key,
			require('./action-method-'+key+'.vue')
		);
	export default {
		props: ['value', 'k', 'name'],
		beforeCreate() {
			this.$store = new Vuex.Store({
				state: {
					title:  '',
					img: '',
					method: '',
					parameters: {},
					fields: {}
				},
				mutations: {
					fill(state, attributes) {
						attributes = JSON.parse(JSON.stringify(attributes)); 

						console.log('fill ', attributes);
						Vue.set(state, 'title', attributes.title || null );
						Vue.set(state, 'img', attributes.img || null);
						Vue.set(state, 'parameters', attributes.parameters || {});
						Vue.set(state, 'method', attributes.method || 'redirect'); //第一个
					},
					setFields(state) {
						let parameters = {};
						let p = JSON.parse(JSON.stringify(state.parameters)); 
						for(let k in state.fields)
						{
							parameters[k] = p && p[k] ? p[k] : 
								(typeof state.fields[k] == 'string' ? null : 
									(typeof state.fields[k].defaultValue != 'undefined' ? state.fields[k].defaultValue : null)
								);
						}
						Vue.set(state, 'parameters', parameters);
					},
				}
			});
		},
		data() {
			return {
			};
		},
		created() {
			//初始化读取value的值
			this.$store.commit('fill', this.parseValue(this.value));
		},
		computed: {
			...Vuex.mapState([
				'title',
				'img',
				'parameters',
				'method',
				'fields'
			]),
			json() {
				return JSON.stringify( this.returnValue()/*, null, 4*/);
			},
			methods() {
				return methods;
			}
		},
		methods : {
			...Vuex.mapMutations([
				'fill',
			]),
			parseValue(v) {
				if (typeof v == 'string')
				{
					try	{
						return JSON.parse(v);
					} catch (e) {
						return {};
					}
				} else if (typeof v == 'object')
					return JSON.parse(JSON.stringify(v));
				return {};
			},
			returnValue() {
				let d = {};
				['title', 'img', 'method', 'parameters'].forEach(v => d[v] = this.$store.state[v]);
				return d;
			},
			remove() {
				this.$emit('remove', this.k);
			},
			load(v) {
				//重新设置数据，当method相同时候，重新setfields
				this.$store.commit('fill', v);
				if (v.method == this.method)
					this.$store.commit('setFields');
			}
		},
		watch: {
			title(v) {
				console.log('trigger title');
				this.$emit('input', this.returnValue());
			},
			img() {
				console.log('trigger img');
				this.$emit('input', this.returnValue());
			},
			method(v) {
				console.log('trigger method');
				this.$emit('input', this.returnValue());
			},
			parameters() {
				console.log('trigger parameters');
				this.$emit('input', this.returnValue());
			},
			fields() {
				//fields值改变时候，setFields
				this.$store.commit('setFields');
			}
		}
	};
</script>