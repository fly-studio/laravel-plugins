<template>
	<form :action="action" method="POST" class="hidden form-horizontal form-bordered" id="form">
	<input type="hidden" name="_token" v-model="csrf">
		<input type="hidden" name="_method" :value="method">
		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">名称</label>
			<div class="col-sm-10">
				<input type="text" id="name" name="name" v-model="node.name" class="form-control" placeholder="请输入名称">
				<span class="help-block">对内名称，同层级下唯一，只允许英文、下划线、数字，<b>设置后无法修改</b></span>
			</div>
		</div>
		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">父级</label>
			<div class="col-sm-10">
				<input type="hidden" id="pid" name="pid" v-model="node.parent.id">
				<p class="form-control-static" id="p-title">{{parent.title}}</p>
			</div>
		</div>
		<div class="form-group">
			<label for="title" class="col-sm-2 control-label">标题</label>
			<div class="col-sm-10">
				<input type="text" id="title" name="title" v-model="node.title" class="form-control" placeholder="请输入标题">
				<span class="help-block">对外显示的标题，<b></b></span>
			</div>
		</div>
		<component v-bind:is="catalog-extra">
			<!-- 组件在 vm.currentview 变化时改变！ -->
		</component>
		<div class="form-group">
			<div class="col-sm-10 col-sm-offset-2 text-center">
				<button type="submit" class="btn btn-success">保存</button>
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
				csrf,
				node: {

				}
			}
		},
		methods: {
			get(id) {
				$this.
				return $.GET(this.urlPrefix + '/' + id + '?of=json');
			},
			create (pid) {
				this.get(pid).then(response => {
					this.action = this.urlPrefix;
					this.method = 'POST';
					this.node = {
						parent: response.data
					};
				});
			},
			edit(id) {
				this.get(pid).then(response => {
					this.action =  + id;
					this.method = 'PUT';
					this.node = response.data;
				});
			}
		}
	};
</script>