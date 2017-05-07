function upvote_project(project_uuid){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(project_uuid).querySelector('upvotes').innerHTML = this.responseText;
            console.log(this.responseText);
        }
    };
     xhttp.open("GET", "index.php?action=upvote_project&upvote_project=" + project_uuid + "", true);
     xhttp.send();
}

function downvote_project(project_uuid){
    var xhttp = new XMLHttpRequest();
    // xhttp.onreadystatechange = function() {
    //     if (this.readyState == 4 && this.status == 200) {
    //         document.querySelectorAll("#"+project_uuid+".downvotes").innerHTML = this.responseText;
    //     }
    // };
     xhttp.open("GET", "index.php?action=downvote_project&downvote_project=" + project_uuid + "", true);
     xhttp.send();
}
