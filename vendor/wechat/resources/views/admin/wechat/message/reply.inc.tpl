<{include file="admin/wechat/depot/selector.tpl"}>
<div id="reply-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title"><i class="fa fa-pencil"></i> 回复</h2>
			</div>
			<!-- END Modal Header -->
			<!-- Modal Body -->
			<div class="modal-body">
				<form action="index.html" id="form" method="post" class="form-horizontal">
				<{csrf_field() nofilter}>
				<{method_field('PUT') nofilter}>
				<input type="hidden" id="type1" name="type" value="text">
					<div class="form-group">
						<div class="col-md-10 col-md-offset-1">
							<p class="form-control-static" id="nickname"></p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-10 col-md-offset-1 ">
							<div class="btn-toolbar" style="margin-bottom:20px;">
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-alt btn-info enable-tooltip active" data-type="text" data-original-title="文本消息">
										<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
									</button>
									<button type="button" class="btn btn-alt btn-success enable-tooltip" data-type="image" data-original-title="图片消息">
										<span class="glyphicon glyphicon-picture" aria-hidden="true"></span>
									</button>
									<button type="button" class="btn btn-alt btn-warning enable-tooltip" data-type="video" data-original-title="视频消息">
										<span class="glyphicon glyphicon-facetime-video" aria-hidden="true"></span>
									</button>
									<button type="button" class="btn btn-alt btn-danger enable-tooltip" data-type="voice" data-original-title="声音消息">
										<span class="glyphicon glyphicon-music" aria-hidden="true"></span>
									</button>
									<button type="button" class="btn btn-alt btn-primary enable-tooltip" data-type="depot" data-original-title="素材">
										<span class="fa fa-newspaper-o" aria-hidden="true"></span>
									</button>
								</div>
							</div>
							<textarea id="content1" name="content" rows="10" class="form-control" maxlength="600" placeholder="请输入需要回复的内容(600字以内)"></textarea>
							<div class="hidden" id="depot" depot-selector="#content1" selected-limit="1">
								
							</div>
						</div>
					</div>
		
					<div class="form-group form-actions">
						<div class="col-xs-12 text-right">
							<button type="submit" class="btn btn-sm btn-primary">发送给用户</button>
							<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">关闭</button>
						</div>
					</div>
				</form>
			</div>
			<!-- END Modal Body -->
		</div>
	</div>
</div>

<script>
(function($){
	$('a[name="reply"]').click(function(){
		$('#form').attr('action', $(this).attr('href'));
		$('#content1').val('');
		$('#nickname').text($(this).data('nickname'));

		$('button:eq(0)', '.btn-group').trigger('click');
		$('#reply-modal').modal({backdrop: 'static', show: true});
		return false;
	});
	$('button', '.btn-group').on('click', function(){
		$(this).addClass('active').siblings().removeClass('active');
		var type = $(this).data('type');

		$('#type1').val(type);
		$('#depot').hide();
		//$('#content1').data('original-content').val();
		switch (type) {
			case 'text':
				$('#content1').val('').show().uploader(true);
				break;
			case 'image':
				$('#content1').val('0').hide().uploader(800, 600);
				break;
			case 'video':
				$('#content1').val('0').hide().uploader(null, null, 10 * 1024 * 1024, 'mp4');
				break;
			case 'voice':
				$('#content1').val('0').hide().uploader(null, null, 5 * 1024 * 1024, 'mp3');
				break;
			case 'depot':
				$('#content1').val('0').hide().uploader(true);
				$('#depot').removeClass('hide hidden').show();

				break;
		}

	});
	$('#form').query();
})(jQuery);
</script>