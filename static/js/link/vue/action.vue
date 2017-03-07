<template>
<div class="">
	<div class="page-header">
		<h3>
			{{$store.state.title ? $store.state.title : '未命名'}}
			<span class="pull-right action-remove" v-if="k != undefined">
				<a href="javascript:" @click="remove">&times;</a>
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
					method: 'redirect',
					parameters: [],
				},
				mutations: {
					setParameters(state, parameters) {
						Vue.set(state, 'parameters', {});
						for(let k in parameters)
							Vue.set(state.parameters, k, 
								state.parameters[k] ? state.parameters[k] : 
									(typeof parameters[k] == 'string' ? null : 
										(typeof parameters[k].value != 'undefined' ? parameters[k].value : null)
									)
							);
					}
				}
			});
	    },
	    created() {

	    	['title', 'img', 'parameters', 'method'].forEach(v => this.$store.state[v] = this.parsedValue[v] ? this.parsedValue[v] : this.$store.state[v])
	    },
		computed: {
			...Vuex.mapState([
				'title',
				'img',
				'parameters',
				'method',
			]),
			json() {
				return JSON.stringify(this.$store.state, null, 4);
			},
			parsedValue() {
				if (typeof this.value == 'string')
				{
					try	{
						return JSON.parse(this.value);
					} catch (e) {
						return {};
					}
				} else if (typeof this.value == 'object')
					return this.value;
				return {};
			},
			methods() {
				return methods;
			}
		},
		methods : {
			...Vuex.mapMutations([
				'setParameters'
			]),
			remove() {
				this.$emit('remove', this.k);
			},
		},
		watch: {
			title(v) {
				this.$emit('input', this.$store.state);
			},
			img() {
				this.$emit('input', this.$store.state);
			},
			method() {
				this.$emit('input', this.$store.state);
			},
			parameters() {
				this.$emit('input', this.$store.state);
			}
		}
	};
</script>