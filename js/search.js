var readFile = function readTextFile(file) {
    var rawFile = new XMLHttpRequest();
    rawFile.open("GET", file, false);
    rawFile.onreadystatechange = function () {
        if (rawFile.readyState === 4) {
            if (rawFile.status === 200 || rawFile.status === 0) {
                allText = rawFile.responseText;
            }
        }
    };
    rawFile.send(file);
};

function isSubmit(form) {
    var submit = false;
}

function score() {
    var score = 0;

    $.getJSON('verbes.json', function (json) {
            .each(json, function (key, data) {
            console.log('key data => => ', key, data.id);
        });
    });
}

function checkWord() {
    var JSONObject = {"animals": [{name:"cat"}, {name:"dog"}]};
    for (i=0; i < JSONObject.animals.length; i++) {
        if (JSONObject.animals[i].name == "dog")
            return true;
    }
    return false;
}

$.getJSON( "ajax/test.json", function( data ) {
    var items = [];
    $.each( data, function( key, val ) {
        items.push( "<li id='" + key + "'>" + val + "</li>" );
    });

    $( "<ul/>", {
        "class": "my-new-list",
        html: items.join( "" )
    }).appendTo( "body" );
});

window.onload = readFile('verbes.json');
