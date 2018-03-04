function upvoteReport(id) {
    var http = new XMLHttpRequest();
    var url = "/php/upvote-downvote.php";
    var params = "mode=upvote&id=" + id;
    http.open("POST", url, true);

    //Send the proper header information along with the request
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send(params);
}

function downvoteReport(id) {
    var http = new XMLHttpRequest();
    var url = "/php/upvote-downvote.php";
    var params = "mode=downvote&id=" + id;
    http.open("POST", url, true);

    //Send the proper header information along with the request
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send(params);
}
