var modal = document.getElementById("main");
var link = document.getElementById("newdelivery");

link.onclick = function() {
    modal.style.display = "block";
}

function computeTotal1(){
    var price = document.getElementById("sp1").value;
    var quantity = document.getElementById("qty1").value;
    price = Number(price);
    quantity = Number(quantity);

    var total = price * quantity;

    document.getElementById("tp1").value = total;
}

function computeTotal2(){
    var price = document.getElementById("sp2").value;
    var quantity = document.getElementById("qty2").value;
    price = Number(price);
    quantity = Number(quantity);

    var total = price * quantity;

    document.getElementById("tp2").value = total;
}

function computeTotal3(){
    var price = document.getElementById("sp3").value;
    var quantity = document.getElementById("qty3").value;
    price = Number(price);
    quantity = Number(quantity);

    var total = price * quantity;

    document.getElementById("tp3").value = total;
}

function computeTotal4(){
    var price = document.getElementById("sp4").value;
    var quantity = document.getElementById("qty4").value;
    price = Number(price);
    quantity = Number(quantity);

    var total = price * quantity;

    document.getElementById("tp4").value = total;
}

function computeTotal5(){
    var price = document.getElementById("sp5").value;
    var quantity = document.getElementById("qty5").value;
    price = Number(price);
    quantity = Number(quantity);

    var total = price * quantity;

    document.getElementById("tp5").value = total;
}

function computeTotal6(){
    var price = document.getElementById("sp6").value;
    var quantity = document.getElementById("qty6").value;
    price = Number(price);
    quantity = Number(quantity);

    var total = price * quantity;

    document.getElementById("tp6").value = total;
}

function computeTotal7(){
    var price = document.getElementById("sp7").value;
    var quantity = document.getElementById("qty7").value;
    price = Number(price);
    quantity = Number(quantity);

    var total = price * quantity;

    document.getElementById("tp7").value = total;
}

function computeTotal8(){
    var price = document.getElementById("sp8").value;
    var quantity = document.getElementById("qty8").value;
    price = Number(price);
    quantity = Number(quantity);

    var total = price * quantity;

    document.getElementById("tp8").value = total;
}

function computeGrandTotal(){
    var total1 = document.getElementById("tp1").value;
    var total2 = document.getElementById("tp2").value;
    var total3 = document.getElementById("tp3").value;
    var total4 = document.getElementById("tp4").value;
    var total5 = document.getElementById("tp5").value;
    var total6 = document.getElementById("tp6").value;
    var total7 = document.getElementById("tp7").value;
    var total8 = document.getElementById("tp8").value;

    total1 = Number(total1);
    total2 = Number(total2);
    total3 = Number(total3);
    total4 = Number(total4);
    total5 = Number(total5);
    total6 = Number(total6);
    total7 = Number(total7);
    total8 = Number(total8);


    var grandTotal = total1 + total2 + total3 + total4 + total5 + total6 + total7 + total8;

    document.getElementById("tp9").value = grandTotal;
}

function dropdownFunction(){
    document.getElementById("myDropdown").classList.toggle("show");
}

window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
  
      var dropdowns = document.getElementsByClassName("dropdown-content");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
          openDropdown.classList.remove('show');
        }
      }
    }
}