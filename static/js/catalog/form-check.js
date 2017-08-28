var form_check = {}
form_check.checkModified = function(fields, $form) {
	var modified = false;
	fields.forEach(function(v){
		var $o = jQuery('[name="'+v+'"]', $form);
		if ($o.is(':checkbox,:radio'))
			$o.each(function(){
				var $t = jQuery(this);
				if ($t.prop('checked') != $t.data('defaultValue')){
					modified = true;
					return false;
				}
			});
		else if ($o.data('defaultValue').toString().replace(/\r?\n/g, "\n") != $o.val().toString().replace(/\r?\n/g, "\n"))
			modified = true;
	});
	
	return modified;
}

form_check.getValue = function(key, data) {
	var keys = key.split(/[\[\.]/);
	var t = data;
	for(var i = 0; i < keys.length; i++) {
		if (typeof t != undefined && t != null)
		{
			var k = keys[i].replace(']', '');
			if (k == '') // key likes 'interests[]'
				break;
			else
				t =  t[k];
		}
		else
			break;
	}
	return typeof t != undefined && t != null ? t : '';
}

form_check.init = function(fields, $form){
	fields.forEach(function(field){
		var $o = jQuery('[name="'+field+'"]', $form);
		$o.is(':checkbox,:radio') ? $o.prop('checked', false).data('defaultValue', false) : $o.data('defaultValue', '').val('');
	});
}

form_check.fill = function(fields, $form, data) {
	fields.forEach(function(field){
		var val = form_check.getValue(field, data);
		var $o = jQuery('[name="'+field+'"]', $form);
		if (!$o[0]) return;
		if ($o.is(':radio')) {
			$o.each(function(){
				var $t = jQuery(this), checked = val == $t.val();
				$t.data('defaultValue', checked).prop('checked', checked)
			});
		}
		else if ($o.is(':checkbox')) {
			var vals = !(val instanceof Array) ? val.split(',') : val;
			$o.each(function(){
				var $t = jQuery(this), checked = vals.indexOf($t.val()) > -1;
				$t.data('defaultValue', checked).prop('checked', checked)
			});
		}
		else
			$o.data('defaultValue', val.toString()).val(val.toString());
	});
}