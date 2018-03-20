<{extends file="admin/extends/edit.block.tpl"}>

<{block "head-plus"}>
<script src="<{'js/vue/json_editor/vue-json-editor-block-view.min.js'|static nofilter}>"></script>
<{/block}>

<script>
<{block "inline-script-plus"}>
Vue.use(vue_json_editor_block_view.default)
new Vue({
	el:'#json-editor',
	data:{
		editable: true,
		myData: <{$_data.client_extra|json_encode:384 nofilter}>
	}
})
<{/block}>
</script>

<{block "title"}>社交平台<{/block}>
<{block "subtitle"}><{$_data.name}><{/block}>

<{block "name"}>socialite<{/block}>

<{block "id"}><{$_data->id}><{/block}>

<{block "fields"}>
<{include file="[socialite]admin/socialite/fields.inc.tpl"}>
<{/block}>
