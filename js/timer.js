// Set the date we're counting down to
var timeLeft = 10;

var counter = setInterval(function(){
    document.getElementById("timer").value = 10 - --timeLeft;
    if(timeLeft <= 0)
        clearInterval(counter);
},1000);