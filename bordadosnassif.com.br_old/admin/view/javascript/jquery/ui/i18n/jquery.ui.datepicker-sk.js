/* Slovak initialisation for the jQuery UI date picker plugin. */
/* Written by Vojtech Rinik (vojto@hmm.sk). */
jQuery(function($){
	$.datepicker.regional['sk'] = {
		closeText: 'Zavrieť',
		prevText: '&#x3c;Predch&aacute;dzajúci',
		nextText: 'Nasledujúci&#x3e;',
		currentText: 'Dnes',
		monthNames: ['Janu&aacute;r','Febru&aacute;r','Marec','Apr&iacute;l','M&aacute;j','Jún',
		'Júl','August','September','Október','November','December'],
		monthNamesShort: ['Jan','Feb','Mar','Apr','M&aacute;j','Jún',
		'Júl','Aug','Sep','Okt','Nov','Dec'],
		dayNames: ['Nedeľa','Pondelok','Utorok','Streda','Štvrtok','Piatok','Sobota'],
		dayNamesShort: ['Ned','Pon','Uto','Str','Štv','Pia','Sob'],
		dayNamesMin: ['Ne','Po','Ut','St','Št','Pia','So'],
		weekHeader: 'Ty',
		dateFormat: 'dd.mm.yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['sk']);
});
