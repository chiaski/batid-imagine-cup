<html lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="css/normalize.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/report.css">
        <link rel="stylesheet" href="css/etc.css">

        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

        <link rel="stylesheet" href="css/lightbox.min.css">
        
        <script src="js/fetch.js"></script>
        <script src="js/upvote-downvote.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.js"><\/script>')</script>

        <script>
            <?php
            if(session_id() == '' || !isset($_SESSION)) {
              session_start();
              $curusername = $_SESSION['username'];
            } else {
              $curusername = "";
            }
            ?>
            function validate() {
                if($('#title').val() == "") {
                    alert("What happened? Make it short and concise.");
                    return false;
                }

                if($('#report-desc').val().length < 10) {
                    alert("Please describe the incident more.");
                    return false;
                }
                if($('input[type=radio][name=severity]:checked').val() == undefined) {
                    alert("Please select a severity.\nYou may refer to the severity ranking chart.");
                    return false;
                }

                if($('#name').val() == "") {
                    alert("What is your name?");
                }
                return true;

            }


                function getLocation() {
                    var geo_options = {
                        enableHighAccuracy: false,
                        maximumAge        : 5 * 60 * 1000,
                        timeout           : 60 * 1000
                    }
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(reportPosition, null, geo_options);

                    } else {
                        alert("Geolocation is not supported by this browser or is not allowed by the client");
                    }
                }

                function reportPosition(position) {
                    document.getElementById('lat').value = position.coords.latitude;
                    document.getElementById('lng').value = position.coords.longitude;
                    // alert(position.coords.latitude + position.coords.longitude + "waaa");
                    batid.panTo(new L.LatLng(position.coords.latitude, position.coords.longitude));
                    return position.coords.latitude + position.coords.longitude
                }


            function addReport(){
                if("<?php echo $curusername; ?>".length == 0) {
                    location.assign("login.php");
                }
                else {
                    $(".batid-report").fadeToggle();
                    $(".batid-report-behind").fadeToggle();
                    $("#report").fadeToggle();
                    getLocation();
                }
            }


            function switchFeed(what){
                $(".feed-wall").fadeOut();
                $(".feed-" + what).fadeIn("fast");
            }



        </script>

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css"/>
        <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>
    </head>

    <body>
      <?php
          require_once "php/config.php";
          $id = $_GET['id'];
      ?>

    <div id="batid-header">
        <center>
            <button class="header-button" onclick="viewFeed();"><i class="fas fa-list"></i><br />View Feed</button>
            <button class="header-button" onclick="addReport();"><i class="fas fa-pencil-alt"></i><br />Add Report</button>
        </center>
        <div class="header-icon"><img src="https://i.imgur.com/MB30klE.png" /></div>
    </div>

    <div class="batid-dropdown">
        <a>Home</a>
        <a>Map</a>
        <a>Account</a>
        <a>Settings</a>
        <a style="color:#ddd;">Log Out</a>
    </div>

    <script type="text/javascript">
        function locateReport(id) {
                        for(i = 0; i < all_reports.length; i++) {
                            if(all_reports[i].id == id) {
                                batid.panTo([all_reports[i].latitude, all_reports[i].longitude]);
                                var t = all_reports[i].time_stamp.split(/[- :]/);
                                var post_time = new Date(Date.UTC(t[0], t[1]-1, t[2], t[3], t[4], t[5]));
                                var formatted_time = timeSince(post_time.getTime());
                                $('.batid-area').css('top', '-20px');
                                $(".batid-feed").css("left", "-600px");
                                $('.batid-area-title').text(all_reports[i].title);
                                $('.batid-area-desc').text(all_reports[i].content);
                                $('.batid-area-timestamp').text(formatted_time);
                                $('.report-txt-severity').addClass('severity-'+all_reports[i].severity);
                                $('.batid-txt-votes').text(all_reports[i].upvotes - all_reports[i].downvotes);
                            }
                        }
                    }



    </script>

        <div id="intro" style="display:none;">
            <div class="intro-one"><img src="https://i.imgur.com/IoOm34W.png" /></div>
            <div class="intro-two" style="background-image:url('https://i.imgur.com/dwnmi9K.png');height:1296px;"><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
                <center><a onclick="$('#intro').fadeOut();"><img src="https://i.imgur.com/eDXILqM.png" /><br />
                <center>Keith Leonardo</center></a></center>
            </div>
        </div>




        <div id="container" style="width:976px;">
            <div class="batid-feed">
                <div class="feed-btns">
                    <center>
                    <button onclick="switchFeed('live');">Live Feed</button>
                    <button onclick="switchFeed('verified')">Verified Feed</button>
                    </center>
                </div>

                <h1>What's happening?</h1>
                <div class="feed-wall feed-live">


                 </div>



                <div class="feed-wall feed-verified">

                <div class="report report-status-live" id="report-21">

                <!--Voting, only appears on hover-->
                <div class="report-box-votes">
                    <button class="report-btn report-btn-vote report-btn-upvotes"><i class="fa fa-angle-up"></i></button>
                    <button class="report-btn report-btn-vote  report-btn-downvotes"><i class="fas fa-angle-down"></i></button>
                </div>

                <!--Time-->
                <div class="report-txt-time">3 seconds</div>


                <!--Title-->
                <h2 class="report-boxtxt-title">Terrorist Bombing in Ayala Plaza</h2>

                <!--Verified-->
                <div class="report-verified">
                    <a><i class="fas fa-external-link-square-alt"></i> CNN News</a>
                </div>

                <a href="http://lokeshdhakar.com/projects/lightbox2/images/thumb-2.jpg" data-lightbox="eh" align="right"><img src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-2.jpg" /></a>
                <!--Description-->
                <p class="report-boxtxt-desc">The Chia Corporation's building has been attacked!</p>


                <!--Yeet-->
                <div class="report-box-inner">

                    <div class="report-box-inner-left">
                        <span style="margin-left:13px;" class="report-txt report-txt-author"><i class="fas fa-user"></i> Chia Amisola</span>
                        <br />
                        <button class="report-btn report-btn-locate" onclick="locateReport(21)"><i class="fas fa-map-marker"></i> Locate</button>
                        <span class="report-txt report-txt-severity severity-red"><i class="fas fa-exclamation-circle"></i> Level</span>
                    </div>

                    <div class="report-box-inner-right" style="width:100px;text-align:left;">
                        <!--Vote count here-->
                        <span style="padding-left:.7em;margin:.5em;" class="report-txt report-txt-votecount"> <i class="fas fa-thumbs-up"> 4</i></span>
                        <br />
                        <button style="margin:.5em;color:#949285;" class="report-btn report-btn-comment" onclick="commentReport(21)"><i class="fas fa-comment"></i></button>
                    </div>

                </div>


            </div>




            </div>
            </div>

            <div class="batid-area">
            <!--White box that displays information about reports-->
            <h1 class="batid-area-title">Robbery and mass shooting rawr</h1>
            <h2 class="batid-area-subtitle"><i class="fas fa-map-marker"></i> At this area around <i class="fas fa-clock"></i> <span class="batid-area-timestamp"></span></h2>
            <p class="batid-area-desc">Event description lorem ipsum dolor sit amet hello hello hello hello hello hello gjasdgsa  dgas kdg as</p>
                <div class="batid-area-lower">
                    <div class="batid-area-lower-left">
                        <span class="report-txt report-txt-severity"><i class="fas fa-exclamation-circle"></i></span>
                    </div>

                    <div class="batid-area-lower-right">
                        <i class="fas fa-thumbs-up"> 3</i> <span class="batid-txt-votes">Votes</span>
                    </div>

                </div>
            </div>
            
            <div class="batid-map" id="batid-map" style="width:800px; background: none; border:2px solid #fff;">

            <div class="batid-map-severitybar">
            <div class="severitybar">
            <center>
            <span class="severitycircle" style="background: #edebd1;"></span> White 
            <span class="severitycircle" style="background: #21844b;"></span> Green 
            <span class="severitycircle" style="background: #e2a415;"></span> Yellow 
            <span class="severitycircle" style="background: #e21515;"></span> Red
            </center>
            </div>
               <span class="text-username">User: <?php if($curusername){ echo $curusername;}else{echo '<a href="register.php">Anonymous</a>';} ?></span>
            </div>
                <!--Batid map here-->
                <h1>Map</h1>
            </div>

            <script type="text/javascript">
                function showSeverity(severity){
                    $(".batid-severity-show").text(severity);
                }

                function showVal(newVal){
                    $(".batid-radius-show").text(newVal);
                }</script>
            <div class="batid-report-behind"></div>
            <div class="batid-report">
                <!--Batid reporting information-->
                <div id="report" class="modal">
                        <h1>Write a Report</h1>
                    <div class="report-inner">
                        <span id="report-form-close" class="close" style="float:left;">&times;</span>
                        <h2>Your area:</h2>
                        <h2 class="report-area"><span class="batid-txt-locname">Microsoft Office</span></h2>
                    <form id="report-content" class="modal-content" action='php/add-report.php' method='post' onsubmit='return validate();'>
                        <!-- Coordinates -->
                        <input class='report-box-coord' type="text" id='lng' name='lng' placeholder="Longitude"/>
                        <input class='report-box-coord' type="text" id='lat' name='lat' placeholder="Latitude"/>

                        <!-- Severity -->

                        <table>
                            <tr>
                                <td class="report-label-area">Severity<br /><span class="batid-radius-container"><span class="batid-severity-show"></span></span></td>
                                <td style="width:80%;">
                                    <ul>
                        <li><input type="radio" name="severity" class="batid-s-white" id="white" value="white" onclick="showSeverity(this.value)" >
                        <label for="white">
                            White
                        </label><div class="batid-s-check" style="background: #C4C3BC;"></div></li>
                        <li><input type="radio" name="severity"  class="batid-s-green" id="green" value="green" onclick="showSeverity(this.value)">
                        <label for="green">
                            Green
                        </label><div class="batid-s-check" style="background: #42C242;"></div></li>
                        <li><input type="radio"  class="batid-s-yellow" name="severity" id="yellow" value="yellow" onclick="showSeverity(this.value)" >
                        <label for="yellow">
                            Yellow
                        </label><div class="batid-s-check" style="background: #E3C622;"></div></li>
                        <li><input type="radio"  class="batid-s-red" name="severity" id="red" value="red" onclick="showSeverity(this.value)" >
                        <label for="red">
                            Red
                        </label><div class="batid-s-check"style="background: #E32222;"></div></li></ul></td>
                            </tr>
                            <tr>
                                <td class="report-label-area">Radius<br /><span class="batid-radius-container"><span class="batid-radius-show"></span> meters</span></td>
                                <td>
                        <input style="width:100%;" type="range" min="10" max="150" value="50" step="5" class="slider" id="radius" name="radius" oninput="showVal(this.value)" onchange="showVal(this.value)"></td>
                            </tr>
                        </table>
                        <center><input class='report-title' type="text" id='title' name='title' placeholder="Report title"/></center>
                        <br />
                            <span class="report-label-area">Description</span>
                        <textarea id='report-desc' name='content' class='batid-txt-desc' placeholder="Describe the event and write down any details and incidents that you recall or have footage of."></textarea>
                        <br />

                        <label class="batid-file-container"><i class="fas fa-camera"></i><input type="file" name="attachment" accept="image/*"></label>

                        <br />

                        <span class="report-label-area">Submitted by </span> <?php echo '<input class="batid-txt-author" type="text" id="name" value="'.$curusername.'" placeholder="Anonymous"/>'; ?><br/><br/></div>
                        <center><input class="batid-txt-submit" type="submit" id="submit_button"/></center>
                    </form>
                </div>

                <script>
                    $("#report-form-close").click(function() {
                        $(".batid-report").fadeOut("fast");
                        $("#report").fadeOut("fast");
                    });
                    $(".batid-report-behind").click(function() {
                        $(".batid-report").fadeOut("slow");
                        $(".batid-report-behind").fadeOut("slow");
                    });
                    
                    function timeSince(date) {
                        var seconds = Math.floor((new Date() - date) / 1000);
                        var interval = Math.floor(seconds / 31536000);
                        if (interval > 1) {
                            return interval + " years";
                        }
                        interval = Math.floor(seconds / 2592000);
                        if (interval > 1) {
                            return interval + " months";
                        }
                        interval = Math.floor(seconds / 86400);
                        if (interval > 1) {
                            return interval + " days";
                        }
                        interval = Math.floor(seconds / 3600);
                        if (interval > 1) {
                            return interval + " hours";
                        }
                        interval = Math.floor(seconds / 60);
                        if (interval > 1) {
                            return interval + " minutes";
                        }
                        return Math.floor(seconds) + " seconds";
                    }
                    // Map stuff
                    var batid = L.map('batid-map', {zoom : 23}).locate({setView : true, enableHighAccuracy : true, watch : true});
                    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                        maxZoom: 48,
                        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
                            '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                            'Imagery © <a href="http://mapbox.com">Mapbox</a>',
                        id: 'mapbox.streets'
                    }).addTo(batid);
                    var all_markers = L.layerGroup([]);
                    var Marker = L.Icon.extend({
                        options: {
                            shadowUrl: 'img/shadow.png',
                            iconSize: [25, 25],
                            shadowSize: [22, 28],
                            iconAnchor: [5, 5],
                            shadowAnchor: [7, 3],
                            popupAnchor: [0, -5]
                        }
                    });
                    var marker_colors = {
                        red : new Marker({iconUrl: 'img/red.png'}),
                        yellow : new Marker({iconUrl: 'img/yellow.png'}),
                        green : new Marker({iconUrl: 'img/green.png'}),
                        white : new Marker({iconUrl: 'img/white.png'}),
                    };
                    function addMarker(data) {
                        var marker = L.marker([data.latitude, data.longitude],
                            {icon: marker_colors[data.severity]}).on('click', function () {
                                    batid.panTo([data.latitude, data.longitude]);
                                    var t = data.time_stamp.split(/[- :]/);
                                    var post_time = new Date(Date.UTC(t[0], t[1]-1, t[2], t[3], t[4], t[5]));
                                    var formatted_time = timeSince(post_time.getTime());
                                    $('.batid-area').css('top', '-20px');
                                    $('.batid-area-title').text(data.title);
                                    $('.batid-area-desc').text(data.content);
                                    $('.batid-area-timestamp').text(formatted_time);
                                    $('.report-txt-severity').addClass('severity-'+data.severity);
                                    $('.batid-txt-votes').text(data.upvotes - data.downvotes);
                        });
                        var area = L.circle([data.latitude, data.longitude], data.radius, 
                            {
                                color: data.severity, 
                                opacity: .5
                        });
                        all_markers.addLayer(area);
                        all_markers.addLayer(marker);
                        var t = data.time_stamp.split(/[- :]/);
                        var post_time = new Date(Date.UTC(t[0], t[1]-1, t[2], t[3], t[4], t[5]));
                        var formatted_time = timeSince(post_time.getTime());
                        // Add report data to the feed
                        var verifiedmultimedia = '';
                        if(data.multimedia != 0) {
                            verifiedmultimedia += '<img src="'+all_multimedia[data.id]+'" title="multimedia embed" alt="multimedia embed"';
                        }
                        var verifiedstring = '';
                        if(data.verified != 0){
                            verifiedstring = ' <!--Verified--> \
                               <div class="report-verified"> \
                               <a><i class="fas fa-external-link-square-alt"></i> Journal Link Here</a></div>'
                        }
                        var votes = data.upvotes-data.downvotes;
                        var keithwtf = '<div class="report report-status" id="report-'+data.id+'"> \
                            <div class="report-box-votes">\
                                <button class="report-btn report-btn-vote report-btn-upvotes" onclick="upvoteReport('+data.id+');"><i class="fa fa-angle-up"></i></button>\
                                <button class="report-btn report-btn-vote  report-btn-downvotes" onclick="downvoteReport('+data.id+');"><i class="fas fa-angle-down"></i></button>\
                            </div>\
                            <!--Time-->\
                            <div class="report-txt-time">'+formatted_time+'</div>\
                            <!--Title-->\
                            <h2 class="report-boxtxt-title">'+data.title+'</h2>\
                            <!--ifVerified-->\
                            '+verifiedstring+'\
                            <!--Multimedia-->'+verifiedmultimedia+'\
                            <br /><p class="report-boxtxt-desc">'+data.content+'</p>\
                            <!--YEEEET-->\
                            <div class="report-box-inner">\
                                <div class="report-box-inner-left">\
                                    <span style="margin-left:13px;" class="report-txt report-txt-author"><i class="fas fa-user"></i>  &nbsp;'+data.author+'</span>\
                                    <br /><button class="report-btn report-btn-locate" onclick="locateReport('+data.id+')"><i class="fas fa-map-marker"></i>  &nbsp; Locate</button>\
                                    <span class="report-txt report-txt-severity severity-'+data.severity+'"><i class="fas fa-exclamation-circle"></i> Level</span>\
                                </div>\
                                <div class="report-box-inner-right" style="width:100px;text-align:left;">\
                                    <!--VOTE COUNT HERE-->\
                                    <span style="padding-left:.7em;margin:.5em;" class="report-txt report-txt-votecount"> <i class="fas fa-thumbs-up"></i> '+votes+'</span><br />\
                                    <button style="margin:.5em;color:#949285;" class="report-btn report-btn-comment" onclick="commentReport('+data.id+')"><i class="fas fa-comment"></i></button>\
                                </div></div></div>';
                        // HAXOR
                        // Check if new content is already on feed. If not, add
                        if(data.verified != 0) {
                            if(!$('.feed-verified').find('#report-'+data.id).length && votes >= 0) {
                                var old = $('.feed-verified').html();
                                $('.feed-verified').html(keithwtf + old);
                            }
                            else if($('.feed-verified').find('#report-'+data.id).length) {
                                if($('#report-'+data.id).find('.report-txt-votecount').text() != '<i class="fas fa-thumbs-up"></i> '+votes) {
                                    $('#report-'+data.id).find('.report-txt-votecount').html('<i class="fas fa-thumbs-up"></i> '+votes)
                                }
                            }
                        } 
                        else {
                            if(!$('.feed-live').find('#report-'+data.id).length && votes >= 0) {
                                var old = $('.feed-live').html();
                                $('.feed-live').html(keithwtf + old);
                            }
                            else if($('.feed-live').find('#report-'+data.id).length) {
                                if($('#report-'+data.id).find('.report-txt-votecount').html() != '<i class="fas fa-thumbs-up"></i> '+votes) {
                                    $('#report-'+data.id).find('.report-txt-votecount').html('<i class="fas fa-thumbs-up"></i> '+votes)
                                }
                            }
                        }
                    }
                    
                    // Do not touch: Auto update the feed every 10 seconds
                    function updateForever() {
                        fetchReports();
                        fetchComments();
                        fetchMultimedia();
                        all_markers.clearLayers();
                        for(var i = 0; i < all_reports.length; i++) {
                            addMarker(all_reports[i]);
                        }
                        all_markers.addTo(batid);
                        var repeater = window.setTimeout(updateForever, 500);
                    }
                    updateForever();
                    <?php
                        echo 'setTimeout("locateReport(' . $id . ');",2250);';
                    ?>
                </script>
            </div>
        </div>

        <script src="js/main.js"></script>
        <script src="js/lightbox.min.js"></script>

    </body>
</html>
