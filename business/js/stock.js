var modal = document.getElementById("main");
var link = document.getElementById("newitem");
var modal2 = document.getElementById("groups");
var link2 = document.getElementById("newgroup");
var modal3 = document.getElementById("subgroups");
var link3 = document.getElementById("newsubgroup");

link.onclick = function() {
    modal.style.display = "block";
}

link2.onclick = function() {
    modal2.style.display = "block";
}

link3.onclick = function() {
    modal3.style.display = "block";
}