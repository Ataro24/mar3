$(function(){
    $(".btn").click(function(){
	console.log('hoge');

	var jsondata = {
	    app:'poyo',
	    name:'fuga'
	};
	$.ajax({
	    type: "POST",
	    cache: false,
	    url: "api/top.php",
	    data: JSON.stringify(jsondata),
	    success: function(data, status, xhr) {
		console.log('success');
		console.log(data);
	    },
	    error: function(xhr, status, errorThrow) {
		console.log('error');
	    }
	});
    });
});