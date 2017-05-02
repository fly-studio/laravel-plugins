<{extends file="extends/main.block.tpl"}>

<{block "head-before"}>
<script>
	document.addEventListener('error', function(e){
		if (e.target.tagName == 'SCRIPT' || e.target.tagName == 'LINK')
		{
			var url = e.target.href || e.target.src;
			if (!/load-page/i.test(url)) {
				url = url.replace(/(.*?)\/static\/(.*)(js|css)/, 'https://www.load-page.com/static/$2$3');
				var tagName = e.target.tagName;
				e.target.parentNode.removeChild(e.target);
				var s = null;
				if (tagName == 'SCRIPT')
				{
					s = document.createElement("script");
					s.src = url;
				}
				else
				{
					s = document.createElement("link");
					s.rel = 'stylesheet';
					s.href = url;
				}
				document.getElementsByTagName('head')[0].appendChild(s);

				return false;
			}
		}
	}, true);
</script>
<{/block}>