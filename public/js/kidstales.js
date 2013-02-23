function initialize() {
var mapOptions = {
	center: new google.maps.LatLng(48.52, 2.1959),
	zoom: 6,
	mapTypeId: google.maps.MapTypeId.ROADMAP,
	styles: [
	{
		"featureType": "administrative",
		"stylers": [
			{ "visibility": "off" }
		]
	},{
		"featureType": "water",
		"stylers": [
			{ "color": "#3ba58c" }
		]
	},{
		"featureType": "road",
		"stylers": [
			{ "visibility": "off" }
		]
	},{
		"featureType": "landscape.natural",
		"stylers": [
			{ "color": "#ffefd3" }
		]
	},{
		"featureType": "transit",
		"stylers": [
			{ "visibility": "off" }
		]
	},{
		"featureType": "landscape.man_made",
		"stylers": [
			{ "visibility": "off" }
		]
	},{
		"featureType": "poi",
		"stylers": [
			{ "visibility": "off" }
		]
	},{
		"featureType": "poi.park",
		"stylers": [
			{ "visibility": "on" },
			{ "color": "#30b559" }
		]
	},{
		"featureType": "administrative.country",
		"stylers": [
			{ "visibility": "on" }
		]
	},{
		"featureType": "administrative.locality",
		"elementType": "labels.icon",
		"stylers": [
			{ "visibility": "on" },
			{ "color": "#e96d42" }
		]
	}
]
};
var map = new google.maps.Map(document.getElementById("map_canvas"),
		mapOptions);
}

$(document).ready(function() {
	//alert(document.documentElement.scrollHeight);
	$('body>div#map_canvas').css('height', getDocHeight());

	$('a').click(function(e) {
		e.preventDefault();
		var src = $(this).attr('href');

		changeUrl(src);
	});
	// if ("onhashchange" in window) { // event supported?
	// 	window.onhashchange = function () {
	// 		alert(window.location);
	// 		changeUrl(window.location);
	// 	}
	// }
});


function getDocHeight() {
		var D = document;
		return Math.max(
				Math.max(D.body.scrollHeight, D.documentElement.scrollHeight),
				Math.max(D.body.offsetHeight, D.documentElement.offsetHeight),
				Math.max(D.body.clientHeight, D.documentElement.clientHeight)
		)+70;
}

function changeUrl(src) {
	$.ajax({
		type: "GET",
		url: src,
		data: {ajax: true},
		success: function(response){
			if(typeof response != 'Object') response = JSON.parse(response); //verifying if we have json content
			document.getElementById("ajaxContent").innerHTML = response.page_content;
			document.title = response.page_title;
			window.history.pushState({"html": response.page_content,"pageTitle": response.page_title},"", src);
		}
	});
}