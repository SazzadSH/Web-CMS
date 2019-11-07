<html>
    <head><title>product</title></head>
    <body>
        <fieldset>
            <legend>Search</legend>
            Name
            <input type="text" id="demo" onkeyup="getData(this.value)"/>
            <p id="sugg">Suggestion</p>
        </fieldset>
        
        <script>
        function getData(str) {
            if(str.length==0) {document.getElementById("sugg").innerHTML="empty";}
            else{
                var xhttp=new XMLHttpRequest();
                console.log("entered 1");
                xhttp.onreadystatechange=function(){
                    console.log("entered 0");
                    if(this.readyState==4 && this.status==200){
                        console.log("entered 2");
                        document.getElementById("sugg").innerHTML=this.responseText; 
                    }
                    else{console.log("entered 3  "+this.readyState+"  "+this.status);}
                    
                };
                xhttp.open("GET","data.php?q="+str,true);
                xhttp.send();
                console.log("entered 4");
            }
            
        }
        </script>
    </body>
</html>