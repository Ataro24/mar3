$(function(){
    ;(function(Mar){
	//日付の計算
	function computeDate(year, month, day, addDays) {
	    var dt = new Date(year, month - 1, day);
	    var baseSec = dt.getTime();
	    var addSec = addDays * 86400000;//日数 * 1日のミリ秒数
	    var targetSec = baseSec + addSec;
	    dt.setTime(targetSec);
	    return dt;
	}

	Mar.Engine = function() {
	    var self = this;
	};
	
	Mar.Engine.prototype = {
	    time_range:15,
	    point_range:160,
	    point_minus:40,
	    //日付取得
	    getDateList: function(){
		//日付用配列の生成
		var self = this;
		var range=self.time_range;
		var date_list = new Array(range);
		var now = new Date();
		var y = now.getFullYear();
		var m = now.getMonth()+1;
		var d = now.getDate();
		var j = 0;
		for (var i=0; i<(date_list.length); i++) {
		    var date = computeDate(y, m, d, j)
		    date_list[i] = date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate();
		    j--;
		}
		return date_list;
	    },
	    //点数用の配列取得
	    getPointArray: function(){
		var self = this;
		var num = new Array((self.point_range+1));
		var j=self.point_range - self.point_minus;
		for (var i=0; i<num.length; i++) {
		    num[i] = j;
		    j--;
		}
		return num;
	    },
	    //入力した(n人目の)対局結果の取得
	    getSelectedGameResult: function(n){
		var target = "player_" + n;
		var target_dom = $('#' + target);
		var name = target_dom.find('.user_name_list').val();
		var point = target_dom.find('.user_point_num').val();
		return {
		    name:name,
		    point:point
		};
	    },
	    //入力した対局結果の日付
	    getSelectedDate: function(){
		return $('#add_game_date_selector').val();
	    },
	    sendData: function(api, data){
		$.ajax({
		    type: "POST",
		    cache: false,
		    url: api,
		    data: JSON.stringify(data),
		    success: function(data, status, xhr) {
			console.log('success');
		    },
		    error: function(xhr, status, errorThrow) {
			console.log('error');
		    }
		});
	    },
	    // ユーザ一覧と対局結果一覧を取得する
	    loadInit: function(){
		var self = this;
		self.loadUsers();
		self.loadGames();
	    },
	    loadUsers: function(){
		var self = this;
		$.ajax({
		    type: "POST",
		    cache: false,
		    url: "api/front/get_user.php",
		    data: {},
		    success: function(data, status, xhr) {
			console.log('success');		
			Mar.user_list = data;
			self.renderUserSelector();
			self.renderDateSelector();
			self.renderPointSelector();
		    },
		    error: function(xhr, status, errorThrow) {
			console.log('error');
		    }
		});
	    },
	    loadGames: function(){
		var self = this;
		$.ajax({
		    type: "POST",
		    cache: false,
		    url: "api/front/get_game.php",
		    dat: {},
		    success: function(data, status, xhr) {
			console.log('success');
			Mar.game_list = data;
		    },
		    error: function(xhr, status, errorThrow) {
			console.log('error');
		    }
		});
	    },
	    renderUserSelector: function(){
		var self = this;
		var user_list = $('#tpl_all_user_list').render(Mar.user_list);

		$(".user_selector").html(
		    $('#tpl_user_selector').render()
		);
		$(".user_name_list").html(
		    user_list
		);
	    },
	    renderDateSelector: function(){
		var self = this;
		var date_list = self.getDateList();
		$(".date_selector").html(
		    $("#tpl_date_list").render(date_list)
		);
	    },
	    renderPointSelector: function(){
		var self = this;
		var point_array = self.getPointArray();
		$(".user_point_num").html(
		    $('#tpl_numbers').render(point_array)
		);
	    },
	    renderGameSelector: function(){
	    },

	    /*
	     *  イベント登録
	     */
	    registerEvent: function(){
		var self = this;
		//対局結果の送信
		$("#send_game_info").click(function(){
		    var game_info = {
			date: self.getSelectedDate(),
			1: self.getSelectedGameResult(1),
			2: self.getSelectedGameResult(2),
			3: self.getSelectedGameResult(3),
			4: self.getSelectedGameResult(4)
		    };
		    self.sendData('api/front/edit_game.php', game_info);
		});
		//対局者の追加
		$("#send_new_player_name").click(function(){
		    var name = $("#new_player_name_input_field").val();
		    self.sendData('api/front/add_user.php', {name:name});
		});
		//役満履歴の追加
		$("#send_yakuman_info").click(function(){
		    var name = $("#add_yakuman_player_name").val();
		    var yakuman = $("#yakuman_list").val();
		    var yakuman_info = {
			date: $('#add_yakuman_date_selector').val(),
			name: name,
			yaku: yakuman
		    };
		    self.sendData('api/front/edit_yakuman.php', yakuman_info);
		});

	    },
	}


	var mar = new Mar.Engine();
	mar.loadInit();
	mar.registerEvent();

    }(mar_engine));
});
