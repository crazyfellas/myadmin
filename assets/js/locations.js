//province
$(document)
.on('change', '#region-select', function(){
	var reg_code = this.value;
	$.ajax({
		url: $(this).attr('href') + '/' + reg_code,
		dataType: 'json',
		success:function(data){
			console.log(data);
			var html = "";
			for (var i = 0; i < data.length; i++) {
				html += "<option value='"+data[i].key+"'>"+data[i].value+"</option>";
			};
			$('#province-select').html(html);
		}
	});
});


//muncity
$(document)
.on('change', '#province-select', function(){
	var prov_code = this.value;
	$.ajax({
		url: $(this).attr('href') + '/' + prov_code,
		dataType: 'json',
		success:function(data){
			console.log(data);
			var html = "";
			for (var i = 0; i < data.length; i++) {
				html += "<option value='"+data[i].key+"'>"+data[i].value+"</option>";
			};
			$('#muncity-select').html(html);
		}
	});
});


//brgy
$(document)
.on('change', '#muncity-select', function(){
	var city_code = this.value;
	$.ajax({
		url: $(this).attr('href') + '/' + city_code,
		dataType: 'json',
		success:function(data){
			console.log(data);
			var html = "";
			for (var i = 0; i < data.length; i++) {
				html += "<option value='"+data[i].key+"'>"+data[i].value+"</option>";
			};
			$('#brgy-select').html(html);
		}
	});
});


//maincrop
$('.croptype-select').on('change', function(){
	var reg_code = this.value;
	$.ajax({
		url: $(this).attr('href') + '/' + reg_code,
		dataType: 'json',
		success:function(data){
			console.log(data);
			var html = "";
			for (var i = 0; i < data.length; i++) {
				html += "<option value='"+data[i].key+"'>"+data[i].value+"</option>";
			};
			$('#maincrop-select').html(html);
		}
	});
});
