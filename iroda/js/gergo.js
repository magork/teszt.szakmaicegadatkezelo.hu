

function G_isntEmpty(mezo,errmes){
  if (document.getElementById(mezo).value == ""){
    alert(errmes);
    return false;
  }else{
    return true;
  }
}


function G_isntInvalid(mezo,invval,errmes){
  if (document.getElementById(mezo).value==invval){
    alert(errmes);
    return false;
  }else{
    return true;
  }
}

function G_isSame(mezo1,mezo2,errmes){
  if(document.getElementById(mezo1).value!=document.getElementById(mezo2).value){
    alert(errmes);
    return false;
  }else{
    return true;
  }
}

function G_reqLen(mezo,len,errmes){
  if(document.getElementById(mezo).value.length<len){
    alert(errmes);
    return false;
  }else{
    return true;
  }
}

function G_isNum(mezo, errmes){
  var sText = document.getElementById(mezo).value;
  var ValidChars = "0123456789";
  var IsNumber=true;
  var Char;
  for (i=0; i<sText.length && IsNumber == true; i++){
    Char = sText.charAt(i);
    if (ValidChars.indexOf(Char) == -1){
      alert(errmes);
      IsNumber = false;
    }
  }
  return IsNumber;
}

