/* Czech initialisation for the jQuery UI date picker plugin. */
/* Written by Tomas Muller (tomas@tomas-muller.net). */
jQuery(function($){
	$.datepicker.regional['cs'] = {
		closeText: 'Zavř&iacute;t',
		prevText: '&#x3c;Dř&iacute;ve',
		nextText: 'Později&#x3e;',
		currentText: 'Nyn&iacute;',
		monthNames: ['leden','únor','březen','duben','květen','červen',
        'červenec','srpen','z&aacute;ř&iacute;','ř&iacute;jen','listopad','prosinec'],
		monthNamesShort: ['led','úno','bře','dub','kvě','čer',
		'čvc','srp','z&aacute;ř','ř&iacute;j','lis','pro'],
		dayNames: ['neděle', 'ponděl&iacute;', 'úterý', 'středa', 'čtvrtek', 'p&aacute;tek', 'sobota'],
		dayNamesShort: ['ne', 'po', 'út', 'st', 'čt', 'p&aacute;', 'so'],
		dayNamesMin: ['ne','po','út','st','čt','p&aacute;','so'],
		weekHeader: 'Týd',
		dateFormat: 'dd.mm.yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['cs']);
});
