<!DOCTYPE HTML>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="robots" content="noindex" />
  <title>{t}Admin Panel at{/t} {$settings->site_title}</title>
  <link rel='icon' href='{$settings->site_path}/images/favicon.ico' type='image/x-icon' />
  {add_js file="vendors/jquery/dist/jquery.min" prepend=true} 
  {add_js file="vendors/bootstrap/dist/js/bootstrap.min" prepend=true}
  {add_css file="vendors/bootstrap/dist/css/bootstrap.min" prepend=true}
  {add_js file="vendors/bootstrap-multiselect/dist/js/bootstrap-multiselect" prepend=true}
  {add_css file="vendors/bootstrap-multiselect/dist/css/bootstrap-multiselect" prepend=true}

  {add_js file="scripts/table_helper" prepend=true} 

  {add_css file="css/admin"}


  {include_js_files}
  {include_css_files}

  <script type="text/javascript">
  $(function(){
    $('.multiselect').multiselect();
  });
  </script>
  <script src="{$settings->site_path}/vendors/ckfinder/ckfinder.js" type="text/javascript"></script>
  <script src="{$settings->site_path}/vendors/ckeditor/ckeditor.js" type="text/javascript"></script>
  <script>
    if (typeof(CKFinder) !== 'undefined')
      CKFinder.setupCKEditor( null, '{$settings->site_path}/vendors/ckfinder/');
    else
      console.error('CKFinder is not installed');
  </script>
  <style>
  {literal}
  .cke_reset_all textarea,.cke_reset_all input[type="text"],.cke_reset_all input[type="password"]{cursor:text; padding: 0; margin:0;font-size: 12px;height: 20px;line-height: 20px;}
  {/literal}
  </style>
</head>
<body>

<div class="wrapper">


  <div class="navbar navbar-default" id="header" role="navigation">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="{$settings->site_path}/admin/">{$settings->site_title} {t}Admin Panel{/t}</a>
        {if isset($user) && $user}
        <button class="navbar-toggle-admin" type="button" data-toggle="collapse" data-target="#admin_panel_menu">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        {/if}
      </div>
    </div> 
  </div>

  <div class="container-fluid">

    <div class="row">
    <div class="col-md-2">
      <div class="collapse" id="admin_panel_menu">
      {if isset($user) && $user}
       {include file="admin/menu.tpl"}
      {/if}
      </div>
    </div>
    <div class="col-md-10" style="padding-bottom: 40px;">
      {include file="{$page_tpl}.tpl"}
    </div>
    </div>

  </div>

  <div class="push"></div>
</div>

<div class="footer">
  <div class="container-fluid">
     <p>{$settings->site_title} &copy; {current_year}</p>
  </div>
</div>

</body>
</html>