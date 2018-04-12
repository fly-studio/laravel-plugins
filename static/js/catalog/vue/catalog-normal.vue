<template>
	<form :action="action" method="POST" class="form-horizontal form-bordered" id="form" v-show="typeof node.parent.id != 'undefined'">
	<input type="hidden" name="_token" v-model="csrf">
		<input type="hidden" name="_method" :value="method">
		<div class="form-group">
			<div class="col-sm-10 col-sm-offset-2">
				<h1>{{typeof node.id != 'undefined' ? '修改 ' + node.name : '新建子项'}}</h1>
			</div>
		</div>
		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">名称</label>
			<div class="col-sm-10">
				<input type="text" id="name" name="name" v-model="node.name" class="form-control" placeholder="请输入名称" :disabled="typeof node.id != 'undefined'">
				<span class="help-block">对内名称，同层级下唯一，只允许英文、数字、[ - ]、[ _ ]、[ . ]，<b>设置后无法修改</b></span>
			</div>
		</div>
		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">父级</label>
			<div class="col-sm-10">
				<input type="hidden" id="pid" name="pid" v-model="node.parent.id">
				<p class="form-control-static" id="p-title">{{node.parent.title}}</p>
			</div>
		</div>
		<div class="form-group">
			<label for="title" class="col-sm-2 control-label">标题</label>
			<div class="col-sm-10">
				<input type="text" id="title" name="title" v-model="node.title" class="form-control" placeholder="请输入标题">
				<span class="help-block">对外显示的标题，<b></b></span>
			</div>
		</div>
		<keep-alive>
		<component v-bind:is="catalogExtra" :node="node">
			<!-- 组件在 catalogExtra 变化时改变！ -->
		</component>
		</keep-alive>
		<div class="form-group">
			<div class="col-sm-10 col-sm-offset-2 text-center">
				<button type="submit" class="btn btn-success" :disabled="typeof node.parent.id == 'undefined'">保存</button>
			</div>
		</div>
	</form>
</template>

<script>
	export default {
		props: ['csrf', 'urlPrefix'],
		data() {
			return {
				action: '',
				method: '',
				catalogExtra: '',
				node: {
					parent: {

					},
					extra: {

					}
				}
			}
		},
		mounted() {
			let $form = jQuery('#form').query();
			jQuery('a[method]', $form).query();
		},
		methods: {
			get(id) {
				return LP.http.jQueryAjax.get(this.urlPrefix + '/' + id + '?of=json').then(json => {
					if (typeof json.data != 'undefined' && !json.data.extra)
						json.data.extra = {};
					let parents = [json.data.name];
					for(let v of json.data.parents)
						parents.push(v.name);
					parents.reverse();
					this.extraTemplate(parents);
					return json;
				});
			},
			extraTemplate(parents) {
				let components = ['catalog-extra'];
				for (let v of parents)
					components.push(components[components.length - 1] + '-' + v);
				components.reverse();
				for(let v of components)
					if (typeof Vue.options.components[v] != 'undefined')
					{
						this.catalogExtra = v;
						return;
					}
				this.catalogExtra = '';
			},
			create (pid) {
				this.get(pid).then(response => {
					this.action = this.urlPrefix;
					this.method = 'POST';
					this.node = {
						parent: response.data,
						extra: {}
					};
				});
			},
			edit(id) {
				this.get(id).then(response => {
					this.action =  this.urlPrefix + '/' + id;
					this.method = 'PUT';
					this.node = response.data;
				});
			},
			hide() {
				this.node.parent.id = undefined;
			}
		}
	};
</script>
