function Location(x) {
    // Do something if request has finished and is OK.
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        // The content of the HTTP response
        var y = xmlhttp.responseText;
        y = JSON.parse(y);
        if(document.getElementsByName("departure")[0].value !== "" || document.getElementsByName("arrival")[0].value !== "") y = unique(y);
        autoLocation(x, y);
    }
}

function autoLocation(inp, arr) {
    var m, n, k;
    closeLocationList();
    m = document.createElement("DIV");
    m.setAttribute("id", this.id + "Location-list");
    m.setAttribute("class", "Location-items");
    inp.parentNode.appendChild(m);
    for (k = 0; k < arr.length; k++) {
        n = document.createElement("DIV");
        n.innerHTML = arr[k][1] + " (" + arr[k][2] + ")";
        n.innerHTML += "<input type='hidden' value='" + arr[k][1] + "' id='" + arr[k][0] + "'>";
        n.addEventListener("click", function(e) {
            inp.value = this.getElementsByTagName("input")[0].value;
        });
        m.appendChild(n);
    }
    /*the autocomplete function takes two arguments, the text field element and an array of possible autocompleted values:*/
    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", function(e) {
        var a, b, i, val = this.value;
        /*close any already open lists of autocompleted values*/
        closeLocationList();
        if (!val) { return false;}
        /*create a DIV element that will contain the items (values):*/
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "Location-list");
        a.setAttribute("class", "Location-items");
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a);
        /*for each item in the array...*/
        for (i = 0; i < arr.length; i++) {
            /*check if the item starts with the same letters as the text field value:*/
            if (arr[i][1].substr(0, val.length).toUpperCase() == val.toUpperCase() || arr[i][2].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                /*create a DIV element for each matching element:*/
                b = document.createElement("DIV");
                /*make the matching letters bold:*/
                b.innerHTML = "<strong>" + arr[i][1].substr(0, val.length) + "</strong>";
                b.innerHTML += arr[i][1].substr(val.length);
                b.innerHTML += " (<strong>" + arr[i][2].substr(0, val.length) + "</strong>";
                b.innerHTML += arr[i][2].substr(val.length) + ")";
                /*insert a input field that will hold the current array item's value:*/
                b.innerHTML += "<input type='hidden' value='" + arr[i][1] + "' id='" + arr[i][0] + "'>";
                /*execute a function when someone clicks on the item value (DIV element):*/
                b.addEventListener("click", function(e) {
                    /*insert the value for the autocomplete text field:*/
                    inp.value = this.getElementsByTagName("input")[0].value;
                });
                a.appendChild(b);
            }
        }
    });

    function closeLocationList(elmnt) {
        /*close all Location list in the document, except the one passed as an argument:*/
        var x = document.getElementsByClassName("Location-items");
        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }
    /*execute a function when someone clicks in the document:*/
    document.onclick = function cancel(e) {
        closeLocationList(e.target);
    };
}

function unique(arr){
    var map = {};
    var res = [];
    for (var i = 0; i < arr.length; i++) {
        if (!map[arr[i][2]]) {
            map[arr[i][2]]=1;
            res.push(arr[i]);
        }
    }
    return res;
}

function check(){
    if(document.getElementById("from").value === "" && document.getElementById("to").value === "") {alert("Please choose departure location and arrival location.");return false;}
    if(document.getElementsByName("trip")[0].checked === true && document.getElementById("returning").value === "") {alert("Please choose returning date.");return false;}
    if(document.getElementById("departing").value === "") {alert("Please choose departing date.");return false;}
    if(new Date(document.getElementById("departing").value) > new Date(document.getElementById("returning").value)) {alert("Departing date should be earlier than returning date.");return false;}
}