//display text
chrome.contextMenus.create({title: "Add to Compare", contexts:["selection"], onclick: loadXMLDoc});
function demo(y)
{
  //alert(y);
	//var str = info.selectionText;
	var xhr1 = new XMLHttpRequest();
	xhr1.open("GET", "http://localhost/mail/mail.php?q="+y, true)
	xhr1.onreadystatechange = function() 
	{
		if (xhr1.readyState == 4) 
		{
			alert("Mail delivered successfully!!!");
		}
	}
	xhr1.send();
}

function loadXMLDoc(info)
{
	
	var str = info.selectionText;
	var xhr = new XMLHttpRequest();
	newWindow=window.open('','mywin','left=700,top=100,width=600,height=300,toolbar=1,resizable=0');
	//newWindow.document.write("<img src=\'http://localhost/libchart/demo/generated/images.gif'>");
	newWindow.document.write("<img src='" + "http://localhost/libchart/demo/generated/load1.gif" + 
       "' alt='Click to load' id='loadimage'/>");
	   
	xhr.open("GET", "http://localhost/libchart/demo/demo.php?q="+str, true)
	xhr.onreadystatechange = function() 
	{
		if (xhr.readyState == 4) 
		{
			
			newWindow.document.getElementById('loadimage').src='http://localhost/libchart/demo/generated/final.png';
			
			newWindow.document.write("<html>");
			newWindow.document.write("<script type=\"text/javascript\"> ");
			newWindow.document.write("function openPopup()");  
			newWindow.document.write("{");
                
				
				newWindow.document.write("var y = " + "window.prompt(\"please enter recipent mail id\");");
				newWindow.document.write("javascript:parent.opener.demo(y)");
				
				
			newWindow.document.write("}"); 
			newWindow.document.write("</script>"); 
			newWindow.document.write("<body style='margin: 0 0 0 0;'>");
			newWindow.document.write("<button id= 'button1' onclick=\"javascript:openPopup()\">Send Mail</button>");
			
			
			newWindow.document.write("</body></html>");
			//newWindow.document.close();
			
		}
		
	}
	xhr.send();
	
}

