

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



function in_array(needle, haystack, argStrict){
    var key = '', strict = !!argStrict; 
    if (strict){
        for (key in haystack){
            if (haystack[key] === needle){
                return true;            
            }
        }
    }else{
        for (key in haystack){
            if (haystack[key] == needle){
                return true;
            }
        }
    }
    return false;
}

function XX(el){
	return document.getElementById(el);
}

function fill(unav,element,defval,conns){
	un = $.parseJSON(unav);
	if(conns) conns = $.parseJSON(conns);
	$('#'+element).empty().append('<option selected="selected" value="0">'+defval+'</option>');
	if(!conns)conns = portalok;
	$.each(conns , function(i,item){
		if($.inArray(i,un)<0)$('#'+element).append('<option value="'+i+'">'+item+'</option>');		
	});			
}


function create_portal_dialog(elem,selector,link,title,tip,nemCid){
	$('body').append('<div id="'+elem+'"></div>');
	$( '#'+elem ).attr({'title':title}).html('<p class="validateTips">'+tip+'</p><form><fieldset><input type="hidden" name="ceg_'+elem+'" id="ceg_'+elem+'" value="0" /><label for="portal">Portál:</label>	<select type="text" name="portal_'+elem+'" id="portal_'+elem+'" class="select ui-widget-content ui-corner-all" ><option value="0"> --Válasszon-- </option></select></fieldset></form>');
	$( "#"+elem ).dialog({
		autoOpen: false,
		height: 300,
		width: 350,
		modal: true,
		buttons: {
			'Rendben': function() {
				var bValid = true;					
				bValid = ($('#portal_'+elem).val()!=0);
				if ( bValid ) {										
					$( this ).dialog( "close" );
					pref = (nemCid)?'?id=':'&cid='
					location.href=link+pref+$("#ceg_"+elem).val()+'&pid='+$('#portal_'+elem).val();
				}
			},
			'Mégse': function() {
				$( this ).dialog("close");
			}
		},
		close: function() {
			$('#portal_'+elem).removeClass("ui-state-error");
		}
	});
	
	$(selector).each(function(){		
		$(this).click(function(e){						
			fill($(this).attr('alt'),'portal_'+elem,' --Válasszon-- ',$(this).attr('rel'));
			$("#ceg_"+elem).val($(this).attr('value'));
			$("#"+elem).dialog("open");			
		});		
	});
}
