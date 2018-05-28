function readTextFile(file) {
    var rawFile = new XMLHttpRequest();
    rawFile.open("GET", file, false);
    rawFile.onreadystatechange = function () {
        if (rawFile.readyState === 4) {
            if (rawFile.status === 200 || rawFile.status === 0) {
                allText = rawFile.responseText;
                return allText;
            }
        }
    };
    rawFile.send(null);
}


var output = readTextFile('verbes.json');
output.forEach(function(element) {
    console.log(element);
});