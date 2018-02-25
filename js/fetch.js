all_reports = [];
all_comments = [];
all_multimedia = {}; // id -> url

function fetchReports() {
	var oReq = new XMLHttpRequest();
	oReq.addEventListener("load", function () {
		all_reports = JSON.parse(this.responseText);
	});
	oReq.open("GET", "php/fetch-reports.php", true);
	oReq.send();
}

function fetchComments() {
	var oReq = new XMLHttpRequest();
	oReq.addEventListener("load", function () {
		all_comments = JSON.parse(this.responseText);
	});
	oReq.open("GET", "php/fetch-comments.php", true);
	oReq.send();
}

function fetchMultimedia() {
	var oReq = new XMLHttpRequest();
	oReq.addEventListener("load", function () {
		all_multimedia = JSON.parse(this.responseText);
	});
	oReq.open("GET", "php/fetch-multimedia.php", true);
	oReq.send();
}