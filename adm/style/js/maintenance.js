$(function() {
	var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
	elems.forEach(function(html) {
		var switchery = new Switchery(html, { color: '#7c8bc7', secondaryColor: '#C74564', jackColor: '#9decff', size: 'small' });

	});

	$('#dmzx_maintenance_timer').on('click init_toggle', function () {
		$('.dmzx_maintenance_timer_toggle').toggle($('#dmzx_maintenance_timer').prop('id="dmzx_maintenance_timer" checked="checked"'));
	}).trigger('init_toggle');

	$('#dmzx_maintenance_enable_social').on('click init_toggle', function () {
		$('.dmzx_maintenance_social_toggle').toggle($('#dmzx_maintenance_enable_social').prop('id="dmzx_maintenance_enable_social" checked="checked"'));
	}).trigger('init_toggle');

	$('#dmzx_maintenance_enable_facebook').on('click init_toggle', function () {
		$('.dmzx_maintenance_facebook_toggle').toggle($('#dmzx_maintenance_enable_facebook').prop('id="dmzx_maintenance_enable_facebook" checked="checked"'));
	}).trigger('init_toggle');

	$('#dmzx_maintenance_enable_twitter').on('click init_toggle', function () {
		$('.dmzx_maintenance_twitter_toggle').toggle($('#dmzx_maintenance_enable_twitter').prop('id="dmzx_maintenance_enable_twitter" checked="checked"'));
	}).trigger('init_toggle');

	$('#dmzx_maintenance_enable_rss').on('click init_toggle', function () {
		$('.dmzx_maintenance_rss_toggle').toggle($('#dmzx_maintenance_enable_rss').prop('id="dmzx_maintenance_enable_rss" checked="checked"'));
	}).trigger('init_toggle');

	$('#dmzx_maintenance_enable_youtube').on('click init_toggle', function () {
		$('.dmzx_maintenance_youtube_toggle').toggle($('#dmzx_maintenance_enable_youtube').prop('id="dmzx_maintenance_enable_youtube" checked="checked"'));
	}).trigger('init_toggle');

	$('#dmzx_maintenance_enable_linkedin').on('click init_toggle', function () {
		$('.dmzx_maintenance_linkedin_toggle').toggle($('#dmzx_maintenance_enable_linkedin').prop('id="dmzx_maintenance_enable_linkedin" checked="checked"'));
	}).trigger('init_toggle');

	$('#dmzx_maintenance_enable_github').on('click init_toggle', function () {
		$('.dmzx_maintenance_github_toggle').toggle($('#dmzx_maintenance_enable_github').prop('id="dmzx_maintenance_enable_github" checked="checked"'));
	}).trigger('init_toggle');

	$('#dmzx_maintenance_enable_email').on('click init_toggle', function () {
		$('.dmzx_maintenance_email_toggle').toggle($('#dmzx_maintenance_enable_email').prop('id="dmzx_maintenance_enable_email" checked="checked"'));
	}).trigger('init_toggle');
});