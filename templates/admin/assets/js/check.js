var checkColor = document.querySelectorAll('.checkcolor');
var checkSize = document.querySelectorAll('.checksize');
for(var i = 0 ; i < checkColor.length; i++){
    var isChecked = checkColor[i].checked;
    if(isChecked){
       var colorShow = checkColor[i].parentElement.parentElement.parentElement.parentElement;
       colorShow.classList.add("show")

    }
}

for(var i = 0 ; i < checkSize.length; i++){
    var isChecked = checkSize[i].checked;
    if(isChecked){
       var colorSize = checkSize[i].parentElement.parentElement.parentElement.parentElement;
       colorSize.classList.add("show")

    }
}

