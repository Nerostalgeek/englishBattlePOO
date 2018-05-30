var game = function game() {
  console.log('game.js ==> =>=');
  readTextFile('verbes.json');
  setQuestion()
}


function readTextFile(file) {
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


function checkAnswer() {

}
function score() {

}

function setQuestion() {
  // Declare variable outside the loop
  var i = 0;


  if (i > window.allText.length) {
    return
  }
  $("#submit").click(function () {
    i++;
    $.getJSON('verbes.json', function (json) {
      console.log('json',json[i]);
      $.each(json, function (key, data) {
        var inputBaseVerbale = $('#baseVerbale');
        //console.log('input', inputBaseVerbale);
        console.log(i);
        inputBaseVerbale.val(data.baseVerbale);
      });
    });
  });
}





function startGame() { }

function endGame() { }

window.onload = game;


