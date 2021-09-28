$(document).ready(function(){
    var page = window.location.href.split('/')
    $('#valorant').removeClass("active");
    $('#csgo').removeClass("active");
    $('#home').removeClass("active");
    switch (page[3]){
        case 'valorant':
            $('#valorant').addClass("active");
            valorant_ajax();
            break;
        case 'csgo':
            $('#csgo').addClass("active");
            csgo_ajax();
            break;
        case 'tournament':
            if (page[4] == "csgo"){
                tournament_csgo();
            }
            else{
                tournament_ajax();
            }
            break;
        default:
            $('#home').addClass("active");
            main_ajax();
            break;  
    }
    Date.prototype.yyyymmdd = function() {
      var mm = this.getMonth() + 1; // getMonth() is zero-based
      var dd = this.getDate();

      return [this.getFullYear(),
              (mm>9 ? '' : '0') + mm,
              (dd>9 ? '' : '0') + dd
             ].join('.');
    };
    function csgo_ajax() {
        $.ajax({
            type: "POST",
            url: "/ajax/",
            success: function(response) {
                i = 0;
                var func_start = false;
                for(var resp in response){
                    var opi = 0;
                    for(var op in response[resp].opponents){

                        if (opi == 1){
                            var image_two = response[resp].opponents[op].opponent.image_url;
                            var name_two = response[resp].opponents[op].opponent.name;
                            for (var res_score in response[resp].results){
                                if (response[resp].results[res_score].team_id == response[resp].opponents[op].opponent.id){
                                    var this_score = response[resp].results[res_score].score;
                                }
                            }
                            if (response[resp].winner.name == response[resp].opponents[op].opponent.name){
                                 var status_two = '<span class="text-success">Winner</span>';
                            }else{
                                var status_two = '<span class="text-danger">Lose</span>';
                            }
                        }else{
                            var image_one = response[resp].opponents[op].opponent.image_url;
                            var name_one = response[resp].opponents[op].opponent.name;
                            for (var res_score in response[resp].results){
                                if (response[resp].results[res_score].team_id == response[resp].opponents[op].opponent.id){
                                    var this_score = response[resp].results[res_score].score;
                                }
                            }
                            if (response[resp].winner.name == response[resp].opponents[op].opponent.name){
                                var status_one = '<span class="text-success">Winner</span>';
                            }else{
                                var status_one = '<span class="text-danger">Lose</span>';
                            }
                        }
                        func_start = true;
                        opi++;
                    }
                    if (func_start == false){
                        document.getElementById("finished_game").innerHTML = '<div class="card p-0 w-100" style="background-color: #444550;"><div class="card-body block-tour" style="white-space: nowrap;"><div class="score"><span class="text-danger">There are currently no live tournaments :(</span></div></div></div>';
                    }else{
                        document.getElementById("finished_game").innerHTML = '<div class="card p-0 w-100" style="background-color: #444550;"><div class="card-body block-tour" style="white-space: nowrap;"><div class="live"><span class="badge bg-primary rounded-pill" style="background-color: green!important;">Finished: '+new Date(response[resp].tournament.end_at).yyyymmdd()+'</span></div><div class="comand1" style="display: inline-grid;"><img src="'+ image_one +'" width="60"><p>'+name_one+'</p></div><div class="score">'+ status_one +' | '+status_two+'</div><div class="comand2" style="display: inline-grid;"><img src="'+ image_two +'" width="60" ><p>'+ name_two +'</p></div><div class="button-match"></div></div></div>';
                    }
                }
                i++;
            },
            dataType: "json",
        });
        //PARSE LIVE
        $.ajax({
            type: "POST",
            url: "/csgo/live/",
            success: function(response) {
                i = 0;
                com = "";
                var func_start = false;
                    if (response.status == "ok"){
                        for(var op in response.tours){
                                var image_two = response.tours[op].img2;
                                var name_two = response.tours[op].comand_2;
                                if (response.tours[op].score_1 == "Live"){
                                    var status_two = '';
                                }else{
                                    var status_two = '';
                                }
                                var image_one = response.tours[op].img1;
                                var name_one = response.tours[op].comand_1;
                                var status_one = 'Live';
                            func_start = true;
                            tour_id = response.tours[op].match_key
                            com = com + '<div class="card p-0 w-100" style="background-color: #444550;"><a href="/tournament/csgo/'+tour_id+'/" style="text-decoration: none;color: #fff !important;"><div class="card-body block-tour" style="white-space: nowrap;"><div class="live"><span class="badge bg-primary rounded-pill" style="background-color: red!important;">Live</span></div><div class="comand1" style="display: inline-grid;"><img src="/img/50px-CSGO_default_lightmode.png" width="60"><p>'+name_one+'</p></div><div class="score">'+ status_one +'  '+status_two+'</div><div class="comand2" style="display: inline-grid;"><img src="/img/50px-CSGO_default_lightmode.png" width="60" ><p>'+ name_two +'</p></div></div></a></div><br>';
                        }
                    }else{
                         document.getElementById("live_game").innerHTML = '<div class="card p-0 w-100" style="background-color: #444550;"><div class="card-body block-tour" style="white-space: nowrap;"><div class="score"><span class="text-danger">There are currently no live tournaments :(</span></div></div></div>';
                    }
                    if (func_start == false){
                        document.getElementById("live_game").innerHTML = '<div class="card p-0 w-100" style="background-color: #444550;"><div class="card-body block-tour" style="white-space: nowrap;"><div class="score"><span class="text-danger">There are currently no live tournaments :(</span></div></div></div>';
                    }else{
                        document.getElementById("live_game").innerHTML = com;
                    }
                i++;
            },
            dataType: "json",
        });
    }
    function valorant_ajax() {
        var game_html = "";
        var upcoming_game = "";
        $.ajax({
            type: "POST",
            url: "/valorant/data/",
            success: function(response) {
                i = 0;
                var func_start = false;
                for(var resp in response.tours){
                    var opi = 0;
                    if (response.tours[resp].status == "wait"){
                        for(var op in response.tours[resp].opponents){

                            if (opi == 1){
                                var image_two = response.tours[resp].opponents[op].logo;
                                var name_two = response.tours[resp].opponents[op].name;
                                var status_one = '<span class="">'+response.tours[resp].opponents[op].score+'</span>';
                                var match_id = response.tours[resp].id;
                            }else{
                                var image_one = response.tours[resp].opponents[op].logo;
                                var name_one = response.tours[resp].opponents[op].name;
                                var status_two = '<span class="">'+response.tours[resp].opponents[op].score+'</span>';
                                var match_id = response.tours[resp].id;
                            }
                            func_start = true;
                            opi++;
                        }
                        if (func_start != false){
                            upcoming_game = upcoming_game + '<div class="card p-0 w-100" style="background-color: #444550;"><div class="card-body block-tour p-1" style="white-space: nowrap; padding-bottom: 0px!important;padding-top: 8px!important;"><div class="live"><span class="badge bg-primary rounded-pill" style="background-color: green!important;">Upcoming '+response.tours[resp].date+'</span></div><div class="comand1" style="display: inline-grid;justify-items: center;justify-content: center;"><img src="'+image_one+'" width="60"><p>'+name_one+'</p></div><div class="score">'+status_two+':'+status_one+'</div><div class="comand2" style="display: inline-grid;justify-items: center;justify-content: center;"><img src="'+image_two+'" width="60" ><p>'+name_two+'</p></div><div class="button-match"></div></div></div><br>';
                        }else{
                            upcoming_game = upcoming_game +'<div class="card p-0 w-100" style="background-color: #444550;"><div class="card-body block-tour p-1" style="white-space: nowrap; padding-bottom: 0px!important;padding-top: 8px!important;"><div class="score"><span class="text-danger">There are currently no live tournaments :(</span></div></div></div><br>';
                        }
                    }else {
                    for(var op in response.tours[resp].opponents){

                        if (opi == 1){
                            var image_two = response.tours[resp].opponents[op].logo;
                            var name_two = response.tours[resp].opponents[op].name;
                            var status_one = '<span class="">'+response.tours[resp].opponents[op].score+'</span>';
                            var match_id = response.tours[resp].id;
                        }else{
                            var image_one = response.tours[resp].opponents[op].logo;
                            var name_one = response.tours[resp].opponents[op].name;
                            var status_two = '<span class="">'+response.tours[resp].opponents[op].score+'</span>';
                            var match_id = response.tours[resp].id;
                        }
                        func_start = true;
                        opi++;
                    }
                    if (func_start != false){
                        game_html = game_html + '<div class="card p-0 w-100" style="background-color: #444550;"><a href="/tournament/'+match_id+'" style="text-decoration: none;color: #fff !important;"><div class="card-body block-tour p-1" style="white-space: nowrap; padding-bottom: 0px!important;padding-top: 8px!important;"><div class="live"><span class="badge bg-primary rounded-pill" style="background-color: red!important;">Live</span></div><div class="comand1" style="display: inline-grid;justify-items: center;justify-content: center;"><img src="'+image_one+'" width="60"><p>'+name_one+'</p></div><div class="score">'+status_two+':'+status_one+'</div><div class="comand2" style="display: inline-grid;justify-items: center;justify-content: center;"><img src="'+image_two+'" width="60" ><p>'+name_two+'</p></div><div class="button-match"></div></div></a></div><br>';
                    }else{
                        game_html = game_html +'<div class="card p-0 w-100" style="background-color: #444550;"><div class="card-body block-tour p-1" style="white-space: nowrap; padding-bottom: 0px!important;padding-top: 8px!important;"><div class="score"><span class="text-danger">There are currently no live tournaments :(</span></div></div></div><br>';
                    }
                    }
                }
                i++;
                document.getElementById("live_game").innerHTML = game_html;
                 document.getElementById("upcoming_game").innerHTML = upcoming_game;
                setTimeout(function(){valorant_ajax();}, 500);
            },
            dataType: "json",
        });
    }
    first_start = true;
    function tournament_csgo() {
        var game_html = "";
        var url = window.location.href;
        $.ajax({
            type: "POST",
            url: "/tournament/ajax/" + url.split("/")[5],
            success: function(response) {
                    if (response.status == "none"){
                        //window.location.href = "/";
                    }
                    if (response.match_key == url.split("/")[5]){
/*                      document.getElementById("info_stat").innerHTML = "Match Statistics: " + response.tours[tour].com_1;
    
                        document.getElementById("info_stat2").innerHTML = "Match Statistics: " + response.tours[tour].com_2;
                        block_table2 = "";


                        document.getElementById("tour_score").innerHTML = block_info;*/
                        console.log(response.score_1);
                        if (response.score1 != "Wait" || first_start == true){
                            first_start = false;
                            if (response.score1 != "Live"){
                                game_html = ' <div class="card p-0 m-3 w-100" style="background-color: #444550; "><div class="card-body block-tour" style="white-space: nowrap; padding-bottom: 0px!important;padding-top: 8px!important;"><div class="live"><span class="badge bg-primary rounded-pill" style="background-color: red!important;">Live Data</span></div><div class="comand1" style="display: inline-grid;justify-items: center;justify-content: center;"><img src="/img/50px-CSGO_default_lightmode.png" width="60"><p>'+response.comand_1+'</p></div><div class="score">'+response.score1+':'+response.score2+'</div><div class="comand2" style="display: inline-grid;justify-items: center;justify-content: center;"><img src="/img/50px-CSGO_default_lightmode.png" width="60" ><p>'+response.comand2+'</p></div></div></div>';
                            }else{
                                game_html = ' <div class="card p-0 m-3 w-100" style="background-color: #444550; "><div class="card-body block-tour" style="white-space: nowrap; padding-bottom: 0px!important;padding-top: 8px!important;"><div class="live"><span class="badge bg-primary rounded-pill" style="background-color: red!important;">Live Data</span></div><div class="comand1" style="display: inline-grid;justify-items: center;justify-content: center;"><img src="/img/50px-CSGO_default_lightmode.png" width="60"><p>'+response.comand2+'</p></div><div class="score">'+response.score1+'</div><div class="comand2" style="display: inline-grid;justify-items: center;justify-content: center;"><img src="/img/50px-CSGO_default_lightmode.png" width="60" ><p>'+response.comand2+'</p></div></div></div>';
                            }
                        document.getElementById("status_game").innerHTML = game_html;
                        }
                    }
            },
            dataType: "json",
        });
        setTimeout(function(){tournament_csgo();}, 10000);
    }
    function tournament_ajax() {
        var game_html = "";
        var url = window.location.href;
        $.ajax({
            type: "POST",
            url: "/ajax/valorant/" + url.split("/")[4],
            success: function(response) {
                document.getElementById("info_stat").innerHTML = "Match Statistics: " + response.c_1;
                block_table = "";
                for(var tb in response.comand_table_1){
                    block_table = block_table+'<tr class="text-white"><td>'+response.comand_table_1[tb].name+'</td><td>'+response.comand_table_1[tb].acs+'</td><td>'+response.comand_table_1[tb].k+'</td><td>'+response.comand_table_1[tb].d+'</td><td>'+response.comand_table_1[tb].a+'</td><td>'+response.comand_table_1[tb].mp+'</td><td>'+response.comand_table_1[tb].adr+'</td><td>'+response.comand_table_1[tb].hs+'</td><td>'+response.comand_table_1[tb].fk+'</td><td>'+response.comand_table_1[tb].fd+'</td><td>'+response.comand_table_1[tb].pm+'</td></tr>';
                }
                document.getElementById("block_table").innerHTML = block_table;

                document.getElementById("info_stat2").innerHTML = "Match Statistics: " + response.c_2;
                block_table2 = "";

                block_info = "";
                for (var map in response.comand_1){
                    response.comand_1[map].comand_name;
                    response.comand_1[map].map_name;
                    response.comand_1[map].score;
                    response.comand_1[map].score_t;
                    response.comand_1[map].score_ct;
                    response.comand_1[map].score_ot;

                    response.comand_2[map].comand_name;
                    response.comand_2[map].map_name;
                    response.comand_2[map].score;
                    response.comand_2[map].score_t;
                    response.comand_2[map].score_ct;
                    response.comand_2[map].score_ot;
                    if (response.comand_1[map].score_ot != ""){
                        block_info = block_info + ' <div class="card p-0 m-3 w-100" style="background-color: #444550; "><div class="card-body block-tour" style="white-space: nowrap; padding-bottom: 0px!important;padding-top: 8px!important;"><div class="live"><span class="badge bg-primary rounded-pill" style="background-color: green!important;">CT: '+response.comand_1[map].score_ct+' | TT: '+response.comand_1[map].score_t+'| OT: '+response.comand_1[map].score_ot+'</span></div><div class="bottom_lv"><span class="badge bg-primary rounded-pill mb-3" style="background-color: green!important;">CT: '+response.comand_2[map].score_ct+' | TT: '+response.comand_2[map].score_t+'| OT: '+response.comand_2[map].score_ot+'</span></div><div class="comand1" style="display: inline-grid;justify-items: center;justify-content: center;"><img src="'+response.logo_cm1+'" width="60"><p>'+response.comand_1[map].score+'</p></div><div class="score">'+response.comand_1[map].map_name+'</div><div class="comand2" style="display: inline-grid;justify-items: center;justify-content: center;"><img src="'+response.logo_cm2+'" width="60" ><p>'+response.comand_2[map].score+'</p></div></div></div>';
                    }else{
                        block_info = block_info + ' <div class="card p-0 m-3 w-100" style="background-color: #444550; "><div class="card-body block-tour" style="white-space: nowrap; padding-bottom: 0px!important;padding-top: 8px!important;"><div class="live"><span class="badge bg-primary rounded-pill" style="background-color: green!important;">CT: '+response.comand_1[map].score_ct+' | TT: '+response.comand_1[map].score_t+'</span></div><div class="bottom_lv"><span class="badge bg-primary rounded-pill mb-3" style="background-color: green!important;">CT: '+response.comand_2[map].score_ct+' | TT: '+response.comand_2[map].score_t+'</span></div><div class="comand1" style="display: inline-grid;justify-items: center;justify-content: center;"><img src="'+response.logo_cm1+'" width="60"><p>'+response.comand_1[map].score+'</p></div><div class="score">'+response.comand_1[map].map_name+'</div><div class="comand2" style="display: inline-grid;justify-items: center;justify-content: center;"><img src="'+response.logo_cm2+'" width="60" ><p>'+response.comand_2[map].score+'</p></div></div></div>';
                    }
                }

                document.getElementById("tour_score").innerHTML = block_info;

                for(var tb in response.comand_table_2){
                    block_table2 = block_table2+'<tr class="text-white"><td>'+response.comand_table_2[tb].name+'</td><td>'+response.comand_table_2[tb].acs+'</td><td>'+response.comand_table_2[tb].k+'</td><td>'+response.comand_table_2[tb].d+'</td><td>'+response.comand_table_2[tb].a+'</td><td>'+response.comand_table_2[tb].mp+'</td><td>'+response.comand_table_2[tb].adr+'</td><td>'+response.comand_table_2[tb].hs+'</td><td>'+response.comand_table_2[tb].fk+'</td><td>'+response.comand_table_2[tb].fd+'</td><td>'+response.comand_table_2[tb].pm+'</td></tr>';
                }
                document.getElementById("block_table2").innerHTML = block_table2;
                game_html = ' <div class="card p-0 m-3 w-100" style="background-color: #444550; "><div class="card-body block-tour" style="white-space: nowrap; padding-bottom: 0px!important;padding-top: 8px!important;"><div class="live"><span class="badge bg-primary rounded-pill" style="background-color: red!important;">Live Data</span></div><div class="comand1" style="display: inline-grid;justify-items: center;justify-content: center;"><img src="'+response.logo_cm1+'" width="60"><p>'+response.c_1+'</p></div><div class="score">'+response.score_cm1+':'+response.score_cm2+'</div><div class="comand2" style="display: inline-grid;justify-items: center;justify-content: center;"><img src="'+response.logo_cm2+'" width="60" ><p>'+response.c_2+'</p></div><div class="button-match">'+response.result_date+'</div></div></div>';
                document.getElementById("status_game").innerHTML = game_html;
                setTimeout(function(){tournament_ajax();}, 500);
            },
            dataType: "json",
        });
    }
});