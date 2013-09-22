function getAjaxData(str) {
    var xmlhttp;
    if (document.getElementById(str).innerHTML == '') {
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById(str).innerHTML = xmlhttp.responseText;
            }
        }

        xmlhttp.open("GET", "ajax.php?q=" + str, true);
        xmlhttp.send();
    } else {
        document.getElementById(str).innerHTML = '';
    }
}