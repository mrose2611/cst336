//VARIABLES
var selectedWord = "";
var selectedHint = "";
var board = [];
var remainingGuesses = 6;
var hint = false;
var words = [{word: "snake", hint:"It's a reptile"},
             {word: "monkey", hint:"It's a mammal"},
             {word: "beetle", hint: "It's an insect"}];
var guessedWords = new Array();

var alphabet = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L',
                'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X',
                'Y', 'Z',];
//LISTENERS
window.onload = startGame();

$(".letter").click(function(){
    checkLetter($(this).attr("id"));
    disableButton($(this));
});

$(".replayBtn").on("click", function() {
    location.reload();
});

$(".hintButton").on("click", function() {
    hintPressed();
    disableButton($(this));
});

//FUNCTIONS

function createLetters() {
    for (var letter of alphabet) {
        $("#letters").append("<button class='letter btn btn-success' id='" + letter + "'>" + letter + "</button>");
    }
}

function startGame() {
    pickWord();
    initBoard();
    updateBoard();
    createLetters();
    showWords();
}
//Fill the board with underscores
function initBoard() {
    for(var letter in selectedWord) {
        board.push("_");
    }
}

function pickWord() {
    var randomInt = Math.floor(Math.random() * words.length);
    selectedWord = words[randomInt].word.toUpperCase();
    selectedHint = words[randomInt].hint;
}

function updateBoard() {
    $("#word").empty();
    
    for(var letter of board) {
        document.getElementById("word").innerHTML += letter + " ";
    }
    
    $("#word").append("<br />");
    if(hint == false) {
        $("#word").append("<button class='hintButton btn btn-warning'>Get a hint. Costs a body part.</button>");
    }
    else {
        $("#word").append("<span class='hint'>Hint: " + selectedHint + "</span>");
    }
}

//Checks to see if the selected letter exists in the selectedWord
function checkLetter(letter) {
    var positions = new Array();
    
    //Put all the positions the letter ecists in an array
    for (var i = 0; i < selectedWord.length; i++) {
        //console.log(selectedWord);
        if (letter == selectedWord[i]) {
            positions.push(i);
        }
    }
    
    if (positions.length > 0) {
        updateWord(positions, letter);
        
        if (!board.includes('_')) {
            endGame(true);
            guessedWords = JSON.parse(sessionStorage.getItem("correctWords"));
            if(guessedWords == null) guessedWords = Array();
            guessedWords.push(selectedWord);
            sessionStorage.setItem("correctWords", JSON.stringify(guessedWords));
            console.log(guessedWords);
        }
    } else {
        remainingGuesses -= 1;
        updateMan();
    }
    
    if (remainingGuesses <= 0) {
        endGame(false);
    }
}

//Update the current word and then call for a board update
function updateWord(positions, letter) {
    for(var pos of positions) {
        board[pos] = letter;
    }
    updateBoard();
}

//Calculates and updates the image for our stick man
function updateMan() {
    $("#hangImg").attr("src", "img/stick_" + (6 - remainingGuesses) + ".png");
}

function showWords() {
    $("#guessed").append("Guessed Words: <br>");
    var retrievedData = JSON.parse(sessionStorage.getItem("correctWords"));
    if(retrievedData == null) retrievedData = Array();
    for(var i =0; i < retrievedData.length; i++) {
        $("#guessed").append(retrievedData[i] + "<br>");
    }
}

function endGame(win) {
    $("#letters").hide();
    
    if(win) {
        $('#won').show();
    } else {
        $('#lost').show();
    }
}

function disableButton(btn) {
    btn.prop("disabled", true);
    btn.attr("class", "btn btn-danger");
}

function hintPressed() {
    hint = true;
    remainingGuesses -= 1;
    updateBoard();
    updateMan();
}
            
