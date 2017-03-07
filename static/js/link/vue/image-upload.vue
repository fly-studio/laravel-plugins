<template>
	<div class="image-upload">
		<div :id="options.pick_id" class="pick">
			
		</div>
		<div class="thumb" :id="'thumb-' + options.pick_id">
			<img src="plugins/img/select-img.png" alt="">
			<div class="progress" v-if="progress > 0" :style="{height: ~~(100 - progress) + '%'}"></div>
			<div class="progress-text" v-if="progress > 0">{{~~progress}}%</div>
		</div>
		<a :href="src" target="_blank" v-if="src && !progress"><i class="glyphicon glyphicon-zoom-in"></i> 新窗口打开</a>
	</div>
</template>

<style>
	.image-upload {position: relative;}
	.image-upload .webuploader-container {z-index: 3;}
	.image-upload .webuploader-pick {background-color:transparent;border: 0 none;padding:0;width: 200px;height: 200px;}
	.image-upload .pick {height: 200px;width: 200px;display: block;}
	.image-upload .thumb {width: 200px;height: 200px;position: absolute;left: 0;top: 0;z-index: 1;display: table-cell;vertical-align:middle;line-height: 200px;background-color: transparent;padding:0;margin: 0;text-align: center;}
	.image-upload .thumb img{max-width: 200px;max-height: 200px;vertical-align:middle;}
	.image-upload .thumb .progress{width: 100%; position: absolute; left: 0; top: 0;height: 100%;background-color: rgba(0, 0, 0, 0.8);}
	.image-upload .thumb .progress-text{width: 100%; position: absolute; left: 0; top: 0;height: 100%;color:#fff;line-height: 200px;z-index: 2;text-align: center}

</style>

<script>
	export default {
		props: ['value', 'maxsize'],
		data() {
			return {
				uploader: null,
				src: this.value,
				progress: false,
			};
		},
		computed:{
			options() {
				return {
					filesize: this.maxsize ? this.maxsize : 2 * 1024 * 1024,
					pick_id: ~~(Math.random() * 1000000),
					filetype: 'jpg,jpeg,png,gif,bmp,webp,svg'
				}
			}
			
		},
		mounted() {
			this.setThumb(this.src);
			this.uploader = WebUploader.create({
				// swf文件路径
				swf: LP.baseuri+"static/js/webuploader/Uploader.swf",
				// 文件接收服务端。
				server: LP.baseuri+"attachment/uploader?of=json",
				// 选择文件的按钮。可选。内部根据当前运行是创建，可能是input元素，也可能是flash
				pick: {
					id: document.getElementById(this.options.pick_id),
					multiple: false
				},
				//表单附加数据
				formData: {},
				//文件表单name
				fileVal: 'Filedata',
				//METHOD
				method: 'POST',
				//二进制上传，php://input都为文件内容，其他参数在$_GET中
				sendAsBinary: false,
				//可提交文件数量限制
				fileNumLimit: 0,
				//总文件大小限制
				//fileSizeLimit: 1024 * 1024 * 1024, //1G
				//单文件大小限制
				fileSingleSizeLimit: this.options.filesize,
				//是否去重
				duplicate: false,
				// 文件选择筛选。
				accept: {
					title: '请选择图片',
					extensions: this.options.filetype,
				},
				//是否分片上传。
				chunked: false,
				thumb: {// 缩略图
					width: 200,
					height: 200,
					// 图片质量，只有type为`image/jpeg`的时候才有效。
					quality: 70,
					// 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
					allowMagnify: false,
					// 是否允许裁剪。
					crop: true,
					// 为空的话则保留原有图片格式。
					// 否则强制转换成指定的类型。
					//type: 'image/jpeg'
				},
				// 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
				resize: false,
				compress: null
			});
			
			this.uploader.on('beforeFileQueued', this.beforeFileQueued);
			this.uploader.on('fileQueued', this.fileQueued);
			this.uploader.on('uploadBeforeSend', this.uploadBeforeSend);
			this.uploader.on('uploadStart', this.uploadStart);
			this.uploader.on('uploadProgress', this.uploadProgress);
			this.uploader.on('uploadSuccess', this.uploadSuccess);
			this.uploader.on('uploadError', this.uploadError);
			this.uploader.on('uploadComplete', this.uploadComplete);
			this.uploader.on('error', this.error);
		},
		watch: {
			src(v) {
				this.$emit('input', v);
			}
		},
		methods: {
			setThumb(src)
			{
				if (!src) src = LP.baseuri + 'plugins/img/select-img.png';
				jQuery('#thumb-' + this.options.pick_id + ' img').attr('src', src);
			},
			beforeFileQueued(file)
			{
				if (this.options.filetype.split(',').indexOf(file.ext.toLowerCase()) == -1) {
					jQuery.alert('只能上传图片文件');
					return false;
				}
			},
			fileQueued(file)
			{
				var t = this;
				this.uploader.makeThumb( file, function( error, ret ) {
					if (!error) t.setThumb(ret);
					t.uploader.upload(file);
				});
				return true;
			},
			uploadBeforeSend(obj, data, headers)
			{

			},
			uploadStart(file)
			{
				this.progress = false;
			},
			uploadProgress(file, percentage)
			{
				this.progress = percentage * 100;

			},
			uploadSuccess(file, json)
			{
				if (json.result == 'success' || json.result == 'api') {
					this.src = json.data.url;
				}
				this.setThumb(this.src);
				this.progress = false;
			},
			uploadError(file, reason)
			{
				jQuery.alert(reason);
				this.setThumb(this.src);
				this.uploader.cancelFile(file);
				this.progress = false;
			},
			uploadComplete(file)
			{
				this.uploader.cancelFile(file);
				this.progress = false;
			},
			error(code, max, file)
			{
				switch(code)
				{
					case 'Q_EXCEED_NUM_LIMIT':
						jQuery.alert('同时上传的文件数量超出限制。');
						break;
					case 'Q_EXCEED_SIZE_LIMIT':
						jQuery.alert('文件总大小超出限制。');
						break;
					case 'F_EXCEED_SIZE':
						jQuery.alert('文件超出' + (this.options.filesize / 1024 / 1024) + 'MB');
						break;
					case 'F_DUPLICATE':
						jQuery.alert('重复文件');
						break;
					case 'Q_TYPE_DENIED':
						jQuery.alert('只能是如下类型的文件：' + this.options.filetype);
						break;
					default:
						jQuery.alert(code);
						break;
				}
				this.setThumb(this.src);
				this.uploader.cancelFile(file);
			}
			
		}

	};
</script>