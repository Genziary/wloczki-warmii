const banner = document.querySelector("#ybc-nivo-slider");


if(banner) {
	banner.addEventListener('click', function() {
    		gtag('event', 'banner_click', {
        		'event_category': 'Banner',
        		'event_label': 'Slider'
    	});
	});
}
