<{extends file="admin/extends/create.block.tpl"}>

<{block "head-plus"}>
<script src="<{'js/vue/vue.min.js'|static nofilter}>"></script>
<script src="<{'js/vue/vuex.min.js'|static nofilter}>"></script>
<script src="<{'js/vue/json_editor/vue-json-editor-block-view.min.js'|static nofilter}>"></script>
<{/block}>

<script>
<{block "inline-script-plus"}>
Vue.use(vue_json_editor_block_view.default)
new Vue({
	el:'#json-editor',
	data:{
		editable: true,
		myData: {}
	}
})
<{/block}>
</script>

<{block "title"}>社交平台<{/block}>

<{block "name"}>socialite<{/block}>

<{block "fields"}>
<{include file="[socialite]admin/socialite/fields.inc.tpl"}>
<{/block}>
