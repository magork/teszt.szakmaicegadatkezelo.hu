function toggle(obj) {

	var el = document.getElementById(obj);
	if ( el.style.display != 'none' ) {
		el.style.display = 'none';
	}
	else {
		el.style.display = '';
	}
}
window.onload = function(){

		if (navigator.platform == "Win32" && navigator.appName == "Microsoft Internet Explorer" && window.attachEvent) {
			window.attachEvent("onload", fnLoadPngs);
		}

		function fnLoadPngs() {
			
			var rslt = navigator.appVersion.match(/MSIE (\d+\.\d+)/, '');
			var itsAllGood = (rslt != null && Number(rslt[1]) >= 5.5);
		
			for (var i = document.images.length - 1, img = null; (img = document.images[i]); i--) {

				if (itsAllGood && img.src.match(/\.png$/i) != null) {
					var src = img.src;
					
					var div = document.createElement("DIV");
					div.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + src + "', sizing='scale')"
					div.style.width = img.width + "px";
					div.style.height = img.height + "px";
					div.style.cursor = "pointer";
					div.style.display = "inline";
					
					img.replaceNode(div);
				}
			}
		}
}


function NewWindow(mypage,myname,w,h,scroll){
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable=false'
	win = window.open(mypage,myname,settings)
}

function tabview_aux(TabViewId, id) {

  var i = 0;
  
  var Tabs = $$( '#tabsK a' );

  Tabs.each( function(t){
  
      i++;  
      t.href = "javascript:tabview_switch('" + TabViewId + "', " + i + ");";
      t.className = (i == id) ? "active" : "inactive";
      t.blur();
  });

  // ----- Pages -----
  
  i = 1;

  var Pages = document.getElementsByClassName( 'page' )

  Pages.each( function(p){
  
      p.style.display = (i == id) ? 'block' : 'none';
      
      i++;
  });

}

// ----- Functions -------------------------------------------------------------

function tabview_switch(TabViewId, id) { tabview_aux(TabViewId, id); }

function tabview_initialize(TabViewId, index) { tabview_aux(TabViewId, index); }
