<head>
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<script src="{$settings->site_path}/vendors/jquery/placeholder/jquery.placeholder.min.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(function() {
				$('input, textarea').placeholder();
			});
		</script>
	<![endif]-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>{if isset($title) && $title}{$title|escape:"html"} | {/if}{$settings->site_title}</title>
	<link rel='icon' href='{$settings->site_path}/images/favicon.ico' type='image/x-icon' />

	<script type="text/javascript">
		var site_path = '{$settings->site_path}';
		var app_version = '{$settings->version}';
	</script>

	{add_js file="vendors/jquery/dist/jquery.min" prepend=true}
	{* Prepend - this scripts will be included first, even if you've added something in controller *}

	{add_js file="vendors/bootstrap-less/js/modal" prepend=true}


	{add_js file="vendors/underscore/underscore-min" prepend=true}
	{add_js file="vendors/backbone/backbone" prepend=true}
	{add_js file="vendors/backbone.paginator/lib/backbone.paginator.min" prepend=true}
	{add_js file="vendors/jsmart/jsmart"} 

	{add_js file="scripts/app"}
	{add_js file="scripts/app/view_stack"}
	{add_js file="scripts/app/settings"}
	{add_js file="scripts/app/local_storage"}
	{add_js file="scripts/app/template_manager"}

	{add_js_folder path="scripts/app/abstract/"}
	{add_js_folder path="scripts/app/models/"}
	{add_js_folder path="scripts/app/collections/"}
	{add_js_folder path="scripts/app/views/dialogs/"}
	{add_js_folder path="scripts/app/views/widgets/"}
	{add_js_folder path="scripts/app/views/pages/"}

	{add_js file="scripts/app/views/header"}

	{add_js file="scripts/app/router"}
	{add_js file="scripts/setup"}

	{include_js_files}
	<script>
	{if isset($user) && $user}
		window.App.setUser({$user->to_array()|@json_encode});
	{/if}
	</script>

	{add_css file="vendors/bootstrap-less/less/bootstrap.less" prepend=true}
	{add_css file="vendors/bootstrap-less/less/theme.less" prepend=true}

	{include_css_files}

	{add_css file="css/main.less" prepend=true}

	{include_css_files}
	
	{include_js_files} {* In case there's .less files and //cdnjs.cloudflare.com/ajax/libs/less.js/2.5.0/less.min.js script was included by last include_css_files *}
</head>