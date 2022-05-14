function show(){

    var x = document.getElementById('options');
    var y = x.value;

    if(y==1){
        window.location.href = "inventory.php";
    }else if(x.value==2){
        alert('user');
    }
}