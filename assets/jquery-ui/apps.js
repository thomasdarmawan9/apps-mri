$(document).ready(function(){
	$("#id_bank").autocomplete({
		source: [
			"Apple",
			"Banana",
			"Manggo"
		],
		select: function( event, selectedData){
			console.log(selectedData);
		}
	});
});