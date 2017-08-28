<template>
<div class="">
	<div class="page-header">
		<h3>
			{{title ? title : '未命名'}}
			<span class="pull-right action-remove" v-if="$store.state.multiple">
				<a href="javascript:" @click="remove()">&times;</a>
			</span>
		</h3>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<label for="" class="col-sm-2 control-label">标题：</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" v-model="title">
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="form-group">
			<label for="" class="col-sm-2 control-label">图片：</label>
			<div class="col-sm-10">
				<image-upload v-model="img"></image-upload>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<div class="action-parameter col-sm-6">
		<div class="form-group">
			<label for="" class="col-sm-2">类型：</label>
			<div class="col-sm-10">
				<select class="form-control" v-model="method">
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
				<component :is="'action-method-' + method" v-model="parameters" @fieldsChanged="fieldsChanged"></component>
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
		'redirect': '跳转链接',
	};
	for(let key in methods)
		Vue.component(
			'action-method-'+ key,
			require('./action-method-'+key+'.vue')
		);
	export default {
		props: ['value', 'k', 'name'],
		data() {
			return {
			};
		},
		created() {
		},
		computed: {
			title: {
				set(v) {
					this.value.title = v;
				},
				get() {
					return this.value.title || '';
				}
			},
			img: {
				set(v) {
					this.value.img = v;
				},
				get() {
					return this.value.img;
				}
			},
			method: {
				set(v) {
					this.value.method = v;
				},
				get() {
					return this.value.method;
				}
			},
			parameters: {
				set(v) {
					this.value.parameters = v;
				},
				get() {
					return this.value.parameters;
				}
			},
			json() {
				return JSON.stringify( this.returnValue()/*, null, 4*/);
			},
			methods() {
				return methods;
			}
		},
		methods: {
			fieldsChanged(v) {
				console.log('change fields');
				this.$store.commit('setFields', {k: this.k, fields: v});
			},
			returnValue() {
				let d = {};
				['title', 'img', 'method', 'parameters'].forEach(v => d[v] = this[v]);
				return d;
			},
			remove() {
				this.$emit('remove', this.k);
			},
		},
		watch: {
			
		}
	};
</script>