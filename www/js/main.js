function upvote_project(project_id , project_uuid){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
         if (this.readyState == 4 && this.status == 200 && this.responseText.toString() != "false") {
             document.getElementById("upvotes_" + project_id).innerText = this.responseText.toString();
         }
    };
    xhttp.open("GET", "index.php?action=upvote_project&upvote_project=" + project_uuid, true);
    xhttp.send();
}

function downvote_project(project_id, project_uuid){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200 && this.responseText.toString() != "false") {
            document.getElementById("downvotes_" + project_id).innerText = this.responseText.toString();
        }
    };
    xhttp.open("GET", "index.php?action=downvote_project&downvote_project=" + project_uuid, true);
    xhttp.send();
}

function join_project(project_uuid){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("join_project").innerText = '✓';
        }
    };
    xhttp.open("GET", "index.php?action=join_project&project=" + project_uuid, true);
    xhttp.send();
}
