// index.js
App.Views.Pages.Index = App.Views.Abstract.Page.extend({

	templateName: 'pages/index/index',
    category: 'home',
	events: {
	},
	title: function() {
		return 'Homepage';
	},
	render: function() {
		this.renderHTML({});
	},
	wakeUp: function() {
		this.holderReady = false;
		this.render();
	},
	initialize: function() {
		this.renderLoading();		
		this.render();
	}

});