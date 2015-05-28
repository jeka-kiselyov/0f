<ul class="breadcrumb">
  <li><a href="{$settings->site_path}/admin/">Admin Panel</a> </li>
  <li class="active">Dashboard</li>
</ul>

<script>
(function(w,d,s,g,js,fs){
  g=w.gapi||(w.gapi={ });g.analytics={ q:[],ready:function(f){ this.q.push(f);}};
  js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
  js.src='https://apis.google.com/js/platform.js';
  fs.parentNode.insertBefore(js,fs);js.onload=function(){ g.load('analytics');};
}(window,document,'script'));
</script>

<div class="panel panel-default">
	<div class="panel-body">
		<div id="embed-api-auth-container"></div>
		<div id="chart-container"></div>
		<div id="view-selector-container"></div>
	</div>
</div>

<script>

gapi.analytics.ready(function() {
  
	gapi.analytics.auth.on('success', function(response) {
		var viewSelector = new gapi.analytics.ViewSelector({
			container: 'view-selector-container'
		});
		viewSelector.execute();

		var dataChart = new gapi.analytics.googleCharts.DataChart({
			query: {
				metrics: 'ga:pageviews',
				dimensions: 'ga:date',
				'start-date': '30daysAgo',
				'end-date': 'yesterday'
			},
			chart: {
				container: 'chart-container',
				type: 'LINE',
				options: {
					width: '100%'
				}
			}
		});

		viewSelector.on('change', function(ids) {
			dataChart.set({ query: { ids: ids}}).execute();
		});
	});

	gapi.analytics.auth.authorize({
		container: 'embed-api-auth-container',
		clientid: '623255759333-g35sg2d92ebd9430hvv2eb8ovevic7qc.apps.googleusercontent.com',
	});

});
</script>