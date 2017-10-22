// mtd = method (get or post)
// id = element id
// cpage = current page
// tpage = target page
// gstr

cp = "";

function ajaxReq(mtd, id, url, str){
	var xmlhttp;

	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
  		xmlhttp=new XMLHttpRequest();
	} else {// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
  
	xmlhttp.onreadystatechange=function(){
  		if (xmlhttp.readyState==4 && xmlhttp.status==200){
    		document.getElementById(id).innerHTML=xmlhttp.responseText;
			
			cp = url;
		}
  	}

	if (cp == "")
		cp = url;
		
	if (str.length > 0)
		str = "?cp=" + cp + "&amp;tp=" + url + "&" + str;
	else 
		str = "?cp=" + cp + "&amp;tp=" + url;
	
	if (mtd == "GET") {
		xmlhttp.open("GET", url + str, true);
		xmlhttp.send();

	} else if (mtd == "POST") {
		xmlhttp.open("POST", url, true);
		//Send the proper header information along with the request
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.setRequestHeader("Content-length", str.length);
		xmlhttp.setRequestHeader("Connection", "close");
		xmlhttp.send(str);
	}

}


