var i = 0;
var images = [];
var time = 5000;

images[0] = 'img/shop-main.jpg';
//images[1] = 'img/shop1.jpg';
//images[2] = 'img/shop2.jpg';
//images[3] = 'img/shop3.jpg';
//images[4] = 'img/shop4.jpg';

function changeImg(){
    document.slide.src = images[i];
    if(i < images.length - 1){
        i++;
    } else {
        i = 0;
    }

    setTimeout("changeImg()", time);
}

window.onload = changeImg;


function popup(){
        document.getElementById('signup-modal').style.display = "none";
        document.getElementById('login-modal').style.display = "block";

        document.getElementById('fullname').value = "";
        document.getElementById('email1').value = "";
        document.getElementById('pass1').value = "";
}
function popupsu(){
    document.getElementById('signup-modal').style.display = "block";
    document.getElementById('login-modal').style.display = "none";

    document.getElementById('email').value = "";
    document.getElementById('password').value = "";
}

function showpass(){

    var checkb = document.getElementById('checkb');

    if(checkb.checked){
        document.getElementById('password').type = "text";
    }else{
        document.getElementById('password').type = "password";
    }
}

/*
var thumbnails = document.getElementsByClassName("product-container");
var slider = document.getElementById("slider");
var slideight = document.getElementById("slide-right");
var slideleft = document.getElementById("slide-left");

slideleft.addEventListener("click", () => {
    slider.scrollLeft -= 125;
});
slideight.addEventListener("click", () => {
    slider.scrollLeft += 125;
});
*/




