<?php
    include "dbConnection.php";
    
    getDatabaseConnection("extra_credit");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Youtube Search</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function() {
                $("#nextPage").on( "click", function( event ) {
                    $("#page").val($("#nextPage").val());
                    youtubeApiCall();
                });
                $("#prevPage").on( "click", function( event ) {
                    $("#page").val($("#prevPage").val());
                    youtubeApiCall();
                });
                $("#searchBtn").on( "click", function( event ) {
                    youtubeApiCall();
                    $.ajax({
                            type : "post",
                            url : "check.php",
                            dataType : "json",
                            data : {"search" : $("#search").val().trim()},
                            success : function(data){
                                $("#searchResult").html("You have searched for '<i>" + data.keyword + "</i>' " + data.timesSearched + " time(s).");
                            }
                    });
                    return false;
                });
                
                function getVideoDetails(ids){
                    $.ajax({
                        cache: false,
                        data: $.extend({
                            key: 'AIzaSyBuyyx7UQvzUy6TP319nwRgrcI-g5rnJf8',
                            part: 'snippet,contentDetails,statistics'
                        }, {id: ids}),
                        dataType: 'json',
                        type: 'GET',
                        timeout: 5000,
                        fields: "items(id,contentDetails,statistics,snippet(publishedAt,channelTitle,channelId,title,description,thumbnails(medium)))",
                        url: 'https://www.googleapis.com/youtube/v3/videos'
                    })
                    .done(function(data) {
                        var items = data.items, videoList = "";
                        $.each(items, function(index,e) {
                            videoList = videoList + '<li class="videoList-item"><div class="hyv-content-wrapper"><a rel="'+e.id+'" data-toggle="modal" data-target="#videoModal" class="hyv-content-link" title="'+e.snippet.title+'"><span class="title">'+e.snippet.title+'</span><span class="stat attribution">by <span>'+e.snippet.channelTitle+'</span></span></a></div><div class="hyv-thumb-wrapper"><a  rel="'+e.id+'" data-toggle="modal" data-target="#videoModal" class="hyv-thumb-link"><span class="hyv-simple-thumb-wrap"><img alt="'+e.snippet.title+'" src="'+e.snippet.thumbnails.default.url+'" width="120" height="90"></span></a></div></li>';
                        });
                        $("#watchRelated").html(videoList);
                    });
                }//end getVideoDetails
                
                function youtubeApiCall(){
                    $.ajax({
                        cache: false,
                        data: $.extend({
                            key: 'AIzaSyBuyyx7UQvzUy6TP319nwRgrcI-g5rnJf8',
                            q: $('#search').val().trim(),
                            part: 'snippet'
                        }, {maxResults:8,pageToken:$("#page").val()}),
                        dataType: 'json',
                        type: 'GET',
                        timeout: 5000,
                        fields: "pageInfo,items(id(videoId)),nextPageToken,prevPageToken",
                        url: 'https://www.googleapis.com/youtube/v3/search'
                    })
                    .done(function(data) {
                        $('.btn-group').show();
                        if (typeof data.prevPageToken === "undefined") {$("#prevPage").hide();}else{$("#prevPage").show();}
                        if (typeof data.nextPageToken === "undefined") {$("#nextPage").hide();}else{$("#nextPage").show();}
                        var items = data.items, videoids = [];
                        $("#nextPage").val(data.nextPageToken);
                        $("#prevPage").val(data.prevPageToken);
                        $.each(items, function(index,e) {
                            videoids.push(e.id.videoId);
                        });
                        getVideoDetails(videoids.join());
                    });
                }//end youtubeApiCall 
        
                var $midLayer = $('.modal-body');
                $('#videoModal').on('show.bs.modal', function (event) {
                    var vid = event.relatedTarget.rel;
                    var url = "//youtube.com/embed/"+vid+"?autoplay=0&autohide=1&modestbranding=1&rel=1&hd=1";
                    var iframe = '<iframe />';
                    var width_f = '100%';
                    var height_f = 400;
                    var frameborder = 0;
                    jQuery(iframe, {
                        name: 'videoframe',
                        id: 'videoframe',
                        src: url,
                        width:  width_f,
                        height: height_f,
                        frameborder: 0,
                        class: 'youtube-player',
                        type: 'text/html',
                        allowfullscreen: true
                    }).appendTo($midLayer);   
                });
                
                $('#videoModal').on('hide.bs.modal', function (event) {
                    $('div.modal-body').html('');
                });
                
            });//end document.ready
        </script>
        <style type="text/css">
            .container-4 input#search {
                width: 500px;
                height: 30px;
                border: 1px solid #c6c6c6;
                font-size: 10pt;
                float: left;
                padding-left: 15px;
                border-top-left-radius: 5px;
                border-bottom-left-radius: 5px;
            }
            .container-4 button#searchBtn {
                height: 30px;
                background: #f0f0f0 10px 1px;
                background-size: 24px;
                border-top-right-radius: 5px;
                border-bottom-right-radius: 5px;
                border: 1px solid #c6c6c6;
                width: 75px;
                margin-left: -45px;
                font-size: 10pt;
            }
        </style>
    </head>

    <body>
        <h1>Youtube Video Search</h1>
        <span id="searchResult"></span><br><br>
        <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModal" aria-hidden="true">    
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <main id="content" role="main" class="span12">
                <div id="pageContainer" style="clear:both;">
                    <div id="pageContent" style="overflow:hidden;">
                        <div class="container-4">
                            <form method="post" name="searchForm" id="searchForm">
                                <input type="text" name="search" id="search" placeholder="Search">
                                <button id="searchBtn">Search</button>
                            </form>
                        </div>
                        <br>
                        <div>
                            <input type="hidden" id="page" value="">
                            <div class="btn-group" role="group" aria-label="..." style="display:none;">
                              <button type="button" id="prevPage" value="" class="btn btn-default">Prev</button>
                              <button type="button" id="nextPage" value="" class="btn btn-default">Next</button>
                            </div>
                        </div>
                        <br>
                        <div id="watchContent">
                            <ul id="watchRelated" class="videoList">
                            </ul>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>