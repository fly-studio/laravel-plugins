<template>
<div>
	<div class="form-group">
		<label for="extra-description" class="col-sm-2 control-label">栏目介绍</label>
		<div class="col-sm-10">
			<textarea id="extra-description" name="extra[description]" v-model="node.extra.description" class="form-control" placeholder="请输入栏目介绍" rows="10"></textarea>
			<span class="help-block">选填，本栏目的文字介绍<b></b></span>
		</div>
	</div>
</div>
</template>

<script>
export default {
	props: ['node'],
	data(){
		return {

		};
	},
	mounted() {
		let $form = jQuery('#form');
		jQuery('a[method]', $form).query();
	}
};
</script>