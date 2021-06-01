"use strict";
/* global document window */

var sentDiag = (function () {
  var can,/*canvas*/ ctx,/*context*/ elDragged,/*element dragged*/
    diag = {showing: false, fsize: 0, marg: 0.1, pad: 0.01, base: 0.4, sent: 0, dobj: 0, adj: 0, adv: 0, crossLoc: 0.5, crossLocA: 0.3, crossLocB: 0.6},
    //sentence = "Diligent farmers delivered fresh beets.",
    sentence = "Diligent farmers .#$,?  delivered   fresh beets.",
    //sentence = "Diligent farmers .#$,?  delivered  quickly.",
    wordButtons, words, proposal = ["", "", "", "", ""];


  // ASSIGNMENT 3

  /* setFontSize divides the width and height of the canvas by 16 and rounds it 
     to the nearest whole number.  Then it sets diag.fsize equal to the lowest of
     these two numbers and sets the font property of the canvas context object to be diag.fsize pixels and sans-serif (e.g. to be "14px sans-serif").
  */

  function setFontSize() {
    var fsizeW = Math.round(can.width / 16),
      fsizeH = Math.round(can.height / 16);

    if (fsizeW < fsizeH) {
      diag.fsize = fsizeW;
    } else {
      diag.fsize = fsizeH;
    }
    ctx.font = diag.fsize + "px sans-serif";
  }


  /* displayErrorMsg takes an argument, m, and displays it in the error 
     message location on the page.
  */

  function displayErrorMsg(m) {
    document.getElementById("errorMsg").innerHTML = m;
    document.getElementById("errorM").style.display = "inline";
  }


  /* longestWord searches the words array for the longest word and returns it. */

  function longestWord() {
    var longest, i;

    longest = words[0];

    for (i = 1; i < words.length; i = i + 1) {
      if (longest.length < words[i].length) {
        longest = words[i];
      }
    }
    return longest;
  }


  /* drawMainSentence checks diag.sent to see if a sentence structure 
     already has been drawn.  If so, it sets an error message letting the user 
     know it already exists.  Otherwise, it sets the sent property of diag 
     to 1, sets the error message to empty, and draws the horizontal and vertical
     lines for the main sentence structure.

     It draws a horizontal line at a percentage of the canvas height as specified by
     diag.base, with a margin on both sides as specified by diag.marg.  It draws 
     a vertical line at the horizontal diag.crossLoc location of the canvas, beginning at 
     a bit above the base line (diag.base - diag.marg) and ending at just below 
     the base line (diag.base + diag.marg).

     The diag.crossLoc location is 50% by default as is needed for a simple sentence with 
     a subject and a verb where the main sentence structure looks like ---+---.  The 
     diag.crossLoc location shifts to the left when there is a direct object for the verb 
     indicating a sentence structure which looks like --+--'--.

     Finally, it calls displayErrorMsg and sends the error message stored.  
  */

  function drawMainSentence() {
    var msg, w = can.width, h = can.height;

    if (diag.sent) {
      msg = "You already have the main sentence structure.";

    } else {
      diag.sent = 1;
      msg = "";

      // draw horizontal line for sentence structure
      ctx.beginPath();
      ctx.moveTo(diag.marg * w, diag.base * h);
      ctx.lineTo((1 - diag.marg) * w, diag.base * h);
      ctx.stroke();

      // draw vertical line for sentence structure
      ctx.beginPath();
      ctx.moveTo(diag.crossLoc * w, (diag.base - diag.marg) * h);
      ctx.lineTo(diag.crossLoc * w, (diag.base + diag.marg) * h);
      ctx.stroke();
    }

    displayErrorMsg(msg);
  }


  /* drawDirectObjectLine checks diag.sent to see if a sentence structure 
     has been drawn yet.  Next, it checks diag.obj to see if a direct object
     structure already has been drawn.  If so, it sets an error message letting 
     the user know it already exists.  Otherwise, it sets the error message to empty, 
     sets diag.crossLoc to diag.crossLocA, calls redraw to redraw the current sentence  
     diagram structures, sets the dobj property of diag to 1, and draws the horizontal  
     line for the direct object structure at a percentage of the canvas width as specified 
     by diag.crossLocB, beginning a bit above the base line (diag.base - diag.marg) 
     and ending at the base line.

     Finally, it calls displayErrorMsg and sends the error message stored.  
  */

  function drawDirectObjectLine() {
    var msg, w = can.width, h = can.height;

    if (!diag.sent) {
      msg = "You need a sentence structure first.";

    } else {
      if (diag.dobj) {
        msg = "You already have a direct object structure.";

      } else {
        msg = "";

        diag.crossLoc = diag.crossLocA;
        redraw();

        diag.dobj = 1;

        // draw vertical line for direct object
        ctx.beginPath();
        ctx.moveTo(diag.crossLocB * w, (diag.base - diag.marg) * h);
        ctx.lineTo(diag.crossLocB * w, diag.base * h);
        ctx.stroke();
      }
    }

    displayErrorMsg(msg);
  }


  /* drawAdjLine checks diag.sent to see if a sentence structure already 
     has been drawn.  If not, it sets an error message letting the user know 
     it is needed first.  Otherwise, it checks diag.adj to see if an 
     adjective structure already has been drawn.  If so, it sets the error 
     message letting the user know it already exists.  Otherwise, it sets 
     diag.adj to 1, sets the error message to empty, and draws the adjective 
     structure as follows.

       o save context
       o translate to point just to the right of the left side of the base line 
         (diag.marg + diag.pad)
       o rotate 45 degrees
       o move to (0, 0)
       o draw line long enough to accommodate longest word in sentence
         1.5 * ctx.measureText(longestWord()).width
         longestWord() returns longest word in words array
       o restore original context

     Finally, it calls displayErrorMsg and sends the error message stored. */

  function drawAdjLine() {
    var msg, w = can.width, h = can.height;

    if (!diag.sent) {
      msg = "You need a sentence structure first.";

    } else {
      if (diag.adj) {
        msg = "You already have an adjective structure.";

      } else {
        diag.adj = 1;
        msg = "";

        ctx.save();
        ctx.translate((diag.marg + diag.pad) * w, diag.base * h);
        ctx.rotate(45 * Math.PI / 180);
        ctx.moveTo(0, 0);
        ctx.lineTo(1.5 * ctx.measureText(longestWord()).width, 0);
        ctx.stroke();
        ctx.restore();
      }
    }

    displayErrorMsg(msg);
  }


  /* drawAdvLine checks diag.sent to see if a sentence structure already 
     has been drawn.  If not, it sets an error message letting the user know 
     it is needed first.  Otherwise, it checks diag.adv to see if an 
     adverb structure already has been drawn.  If so, it sets the error 
     message letting the user know it already exists.  Otherwise, it sets 
     diag.adv to 1, sets the error message to empty, and draws the adverb 
     structure as follows.

       o save context
       o translate to point just to the right of diag.crossLocB on the base line 
         (diag.crossLocB + diag.pad)
       o rotate 45 degrees
       o move to (0, 0)
       o draw line long enough to accommodate longest word in sentence
         1.5 * ctx.measureText(longestWord()).width
         longestWord() returns longest word in words array
       o restore original context

     Finally, it calls displayErrorMsg and sends the error message stored. 
     
     NOTE: This modifier technically is an adjective for the five word sentence 
     containing a direct object we're considering. */

  function drawAdvLine() {
    var msg, w = can.width, h = can.height;

    if (!diag.sent) {
      msg = "You need a sentence structure first.";

    } else {
      if (diag.adv) {
        msg = "You already have an adverb structure.";

      } else {
        diag.adv = 1;
        msg = "";

        ctx.save();
        ctx.translate((diag.crossLocB + diag.pad) * w, diag.base * h);
        ctx.rotate(45 * Math.PI / 180);
        ctx.moveTo(0, 0);
        ctx.lineTo(1.5 * ctx.measureText(longestWord()).width, 0);
        ctx.stroke();
        ctx.restore();
      }
    }

    displayErrorMsg(msg);
  }


  /* drawSubject takes one argument, s, the word to be displayed.  It checks
     diag.sent to see if a sentence structure already has been drawn.  If 
     not, it sets an error message letting the user know it is needed first.  
     Otherwise, it sets the error message to empty, and checks the second 
     location of the proposal array to see if it already contains a word.  If
     it does, the second location of the proposal array is replaced with the 
     new word sent to this function, and redraw is called to redraw the current 
     sentence diagram structures.  Otherwise, the second location of the proposal 
     array is set to the word sent to this function and drawn on the canvas just
     to the right of the left edge of the beginning of the base line 
     (diag.marg + diag.pad) and just above the base line (diag.base - diag.pad).  

     Finally, it calls displayErrorMsg and sends the error message stored. */

  function drawSubject(s) {
    var msg, w = can.width, h = can.height;

    if (!diag.sent) {
      msg = "You need a sentence structure first.";

    } else {
      msg = "";

      if (proposal[1] !== "") { // replace current word
        proposal[1] = s;
        redraw();

      } else {
        proposal[1] = s;
        ctx.fillText(s, (diag.marg + diag.pad) * w, (diag.base - diag.pad) * h);
      }
    }

    displayErrorMsg(msg);
  }


  /* drawPredicate takes one argument, p, the word to be displayed.  It checks
     diag.sent to see if a sentence structure already has been drawn.  If 
     not, it sets an error message letting the user know it is needed first.  
     Otherwise, it sets the error message to empty, and checks the third 
     location of the proposal array to see if it already contains a word.  If
     it does, the third location of the proposal array is replaced with the 
     new word sent to this function, and redraw is called to redraw the current 
     sentence diagram structures.  Otherwise, the third location of the proposal 
     array is set to the word sent to this function and drawn on the canvas just
     to the right of diag.crossLoc (diag.crossLoc + (2 * diag.pad)) and just above the 
     base line (diag.base - diag.pad).  

     Finally, it calls displayErrorMsg and sends the error message stored. */

  function drawPredicate(p) {
    var msg, w = can.width, h = can.height;

    if (!diag.sent) {
      msg = "You need a sentence structure first.";

    } else {
      msg = "";

      if (proposal[2] !== "") { // replace current word
        proposal[2] = p;
        redraw();

      } else {
        proposal[2] = p;
        ctx.fillText(p, ((diag.crossLoc + (2 * diag.pad)) * w), (diag.base - diag.pad) * h);
      }
    }

    displayErrorMsg(msg);
  }


  /* drawAdj takes one argument, a, the word to be displayed.  It checks
     diag.sent to see if a sentence structure already has been drawn.  If 
     not, it sets an error message letting the user know it is needed first. Next 
     it checks diag.adj to see if a modifier structure exists under the subject.
     If not, it sets an error message letting the user know it is needed first.
     Otherwise, it sets the error message to empty, and checks the first 
     location of the proposal array to see if it already contains a word.  If
     it does, the first location of the proposal array is replaced with the 
     new word sent to this function, and redraw is called to redraw the current 
     sentence diagram structures.  Otherwise, the first location of the proposal 
     array is set to the word sent to this function and this word is drawn on the 
     canvas as follows.

       o save context
       o translate to point just to the right of the left side of the base line 
         (diag.marg + 2 * diag.pad)
       o rotate 45 degrees
       o move to (0, 0)
       o draw word a at location (fsize, 0)
       o restore original context

     Finally, it calls displayErrorMsg and sends the error message stored. */

  function drawAdj(a) {
    var msg, w = can.width, h = can.height;

    if (!diag.sent) {
      msg = "You need a sentence structure first.";

    } else if (!diag.adj) {
      msg = "You need an adjective structure first.";

    } else { // sentence and adverb structure exists
      msg = "";

      if (proposal[0] !== "") { // replace current word
        proposal[0] = a;
        redraw();

      } else {
        proposal[0] = a;

        ctx.save();
        ctx.translate((diag.marg + 2 * diag.pad) * w, diag.base * h);
        ctx.rotate(45 * Math.PI / 180);
        ctx.moveTo(0, 0);
        ctx.fillText(a, diag.fsize, 0);
        ctx.restore();
      }
    }

    displayErrorMsg(msg);
  }


  /* drawAdv takes one argument, a, the word to be displayed.  It checks
     diag.sent to see if a sentence structure already has been drawn.  If 
     not, it sets an error message letting the user know it is needed first.  
     Next it checks diag.adv to see if a modifier structure exists under the 
     predicate (or direct object). If not, it sets an error message letting the 
     user know it is needed first.  Otherwise, it sets the error message to empty, 
     and checks the fourth location of the proposal array to see if it already 
     contains a word.  If it does, the fourth location of the proposal array is 
     replaced with the new word sent to this function, and redraw is called to 
     redraw the current sentence diagram structures.  Otherwise, the fourth 
     location of the proposal array is set to the word sent to this function and 
     this word is drawn on the canvas as follows.

       o save context
       o translate to point just to the right of diag.crossLocB on the base line 
         (diag.crossLocB + 2 * diag.pad)
       o rotate 45 degrees
       o move to (0, 0)
       o draw word a at location (fsize, 0)
       o restore original context

     Finally, it calls displayErrorMsg and sends the error message stored.
          
     NOTE: This modifier technically is an adjective for the five word sentence 
     containing a direct object we're considering. */

  function drawAdv(a) {
    var msg, w = can.width, h = can.height;

    if (!diag.sent) {
      msg = "You need a sentence structure first.";

    } else if (!diag.adv) {
      msg = "You need an adverb structure first.";

    } else { // sentence and adverb structure exists
      msg = "";

      if (proposal[3] !== "") { // replace current word
        proposal[3] = a;
        redraw();

      } else { // draw new word
        proposal[3] = a;

        ctx.save();
        ctx.translate((diag.crossLocB + 2 * diag.pad) * w, diag.base * h);
        ctx.rotate(45 * Math.PI / 180);
        ctx.moveTo(0, 0);
        ctx.fillText(a, diag.fsize, 0);
        ctx.restore();
      }
    }

    displayErrorMsg(msg);
  }


  /* drawDirectObject takes one argument, a, the word to be displayed.  It checks
     diag.sent to see if a sentence structure already has been drawn.  If 
     not, it sets an error message letting the user know it is needed first.
     Otherwise, it checks diag.dobj to see if a direct object structure 
     already has been drawn.  If not, it sets an error message letting the user 
     know it is needed first.  Otherwise, it sets the error message to empty, and 
     checks the fifth location of the proposal array to see if it already contains 
     a word.  If it does, the fifth location of the proposal array is replaced 
     with the new word sent to this function, and redraw is called to redraw the 
     current sentence diagram structures.  Otherwise, the fifth location of the 
     proposal array is set to the word sent to this function and drawn on the 
     canvas just to the right of diag.crossLocB (diag.crossLocB + (2 * diag.pad)) and 
     just above the base line (diag.base - diag.pad).  

     Finally, it calls displayErrorMsg and sends the error message stored. */

  function drawDirectObject(a) {
    var msg, w = can.width, h = can.height;

    if (!diag.sent) {
      msg = "You need a sentence structure first.";

    } else if (!diag.dobj) {
      msg = "You need a direct object structure first.";

    } else { // sentence and direct object structure exist
      msg = "";

      if (proposal[4] !== "") { // replace current word
        proposal[4] = a;
        redraw();

      } else { // draw new word
        proposal[4] = a;

        ctx.fillText(a, (diag.crossLocB + (2 * diag.pad)) * w, (diag.base - diag.pad) * h);
      }
    }

    displayErrorMsg(msg);
  }


  // ASSIGNMENT 2

  /* processChoice takes an event, ev, as an argument, which is the location 
     where the user dropped an element on the canvas, can, indicating how they  
     would like to alter the canvas.  Using (x, y) notation, the top left corner 
     of the window is considered (0, 0) with x increasing as you move toward the  
     right and y increasing as you move downward.  The drop event occurred at 
     location (ev.x, ev.y) of the window, but we need to know where it occurred on 
     the canvas.  The canvas' top left corner also is (0, 0) relative to itself, 
     but relative to the window, it is at location (can.offsetLeft, can.offsetTop) 
     of the window.  The location of the drop event on the canvas is (ev.offsetX, ev.offsetY).

     After calling setFontSize, the variable sentDiag.elDragged is checked.  It 
     stores a number indicating which element was dragged as shown below.  Notice 
     the value of sentDiag.elDragged is always four more than the value in brackets, 
     which indexes the w array.

       1 -- main sentence structure
       2 -- direct object structure
       3 -- modifier structure
       4 -- first word at w[0]
       5 -- second word at w[1]
       6 -- third word at w[2]
       7 -- fouth word at w[3]
       8 -- fifth word at w[4]

     Based on what was dropped where on the canvas, one of the following 
     functions is called.
     
        o drawMainSentence - main sentence structure dropped anywhere, and no main  
          sentence structure exists yet
          
        The following assume the main sentence structure exists.
        
        o drawDirectObjectLine - direct object structure dropped anywhere
        o drawAdjLine - modifier structure dropped on left side of crossLoc
        o drawAdvLine - modifier structure dropped on right side of crossLoc
        
        The following assume appropriate sentence structures exist.
        
        o drawSubject - word dropped to left of crossLoc and above base line
        o drawPredicate - word dropped to right of crossLoc and above base line
          (and to left of crossLocB, if direct object structure is present)
        o drawDirectObject - word dropped to right of crossLoc, above base line, and 
          to right of crossLocB, if direct object structure is present
        o drawAdj - word dropped on left side of crossLoc below base line
        o drawAdv - word dropped on right side of crossLoc below base line
     */

  function processChoice(ev) {
    var dropX, dropY, sentOrigX, sentOrigY, e, w = can.width, h = can.height, idx;

    sentOrigX = w * diag.crossLoc;
    sentOrigY = h * diag.base;

    dropX = ev.offsetX;
    dropY = ev.offsetY;

    e = sentDiag.elDragged;
    //alert("Element " + e + " dropped at (" + dropX + "," + dropY + ").");

    //setFontSize();

    if (e === 1) { // main sentence structure
      drawMainSentence();

    } else if (e === 2) { // direct object structure
      drawDirectObjectLine();

    } else if (e === 3) { // modifier structure (adj or adv)
      if (dropX < sentOrigX) { // modifier structure (adj)
        drawAdjLine();

      } else { // modifier structure (adv)
        drawAdvLine();
      }

    } else { // word
      idx = e - 4; // shift values, so idx is in range [0,4]

      if (dropY >= sentOrigY) { // bottom
        if (dropX < sentOrigX) { // left (adj)
          drawAdj(words[idx]);

        } else { // right (adv)
          drawAdv(words[idx]);
        }

      } else { // top
        if (dropX < sentOrigX) { // left (subject)
          drawSubject(words[idx]);

        } else { // right (predicate or direct object)
          if (diag.crossLoc === 0.5) { // predicate (diagram with no direct object)
            drawPredicate(words[idx]);

          } else { // diagram with direct object (predicate or direct object)
            if (dropX < (2 * sentOrigX)) { // predicate
              drawPredicate(words[idx]);

            } else { // direct object
              drawDirectObject(words[idx]);
            }
          }
        }
      }
    }
  }


  /* convertSentence uses regular expression matching and string functions 
     to perform the operations below, one after the other, on sentence.
     It stores the results in words.

     o Remove punctuation from sentence
     o Convert sequences of multiple blank spaces to single blank spaces
     o Split on the remaining single blank spaces and store the separate 
        words returned as array elements in words 

     It uses a loop to traverse words and create wordButtons which is a 
     string containing HTML code to display the words as buttons the user 
     can drag onto the canvas.  See example below for the format if the 
     first word is Diligent and the second word is farmers.

       <input id='w0' type='button' value='Diligent' draggable='true' 
          ondrag ='sentDiag.elDragged=4'><br>

       <input id='w1' type='button' value='farmers' draggable='true' 
          ondrag ='sentDiag.elDragged=5'><br>
  */

  function convertSentence() {
    var i, len, noPunct, singleSpace;
    
    noPunct = sentence.replace(/[^\w\s]/g, ""); // remove punctuation
    singleSpace = noPunct.replace(/\s{2,}/g, " "); // collapse white space to single space
    words = singleSpace.split(/\s/); // create array elements from words between spaces
    
    sentence = singleSpace;
    document.getElementById('curSent').innerHTML = sentence;

    // create HTML for draggable word buttons
    len = words.length;
    wordButtons = "";
    for (i = 0; i < len; i = i + 1) {
      wordButtons += '<input type="button" value="' + words[i] + '" class="word" draggable="true" ondrag ="sentDiag.elDragged=' + (i + 4) + '"><br>';
    }
  }


  // ASSIGNMENT 1

  /* displayDiagram sets diag.showing to true and displays the canvas along with
     diagram structure elements, word choices, menu buttons, and directions.  It also
     stops displaying the welcome page and questions. */

  function displayDiagram() {
    diag.showing = true;

    document.getElementById('titleWelcome').style.display = "none";
    document.getElementById('titleDiagram').style.display = "inline";

    document.getElementById('mainLshow').style.display = "inline";

    document.getElementById('mainCwelcome').style.display = "none";
    //document.getElementById('myCanvas').style.border = "1px solid black";
    document.getElementById('mainCcanvas').style.display = "inline";

    document.getElementById('mainRshow').innerHTML = wordButtons;
    document.getElementById('mainRshow').style.display = "inline";

    document.getElementById('directShow').style.display = "inline";
  }


  /* validScore checks the validity of the value entered by the user as their 
     anticipated score.  It uses the try, throw, catch, and finally statements to
     error check values entered by the user for the anticipated grade.

     Specifically, it throws messages for the following.
       o empty string
       o strings which are not numbers
       o values below 0
       o values greater than 100 

     It prints these messages in red next to the input element.  If valid data is
     entered, the finally statement erases any remaining error message and calls the displayDiagram function. */

  function validScore() {
    var e = document.getElementById('scoreErr'),
      preScore = document.getElementById("score").value;

    try {
      if (preScore === "") {
        throw "Please enter what you expect to earn.";
      }
      if (isNaN(preScore)) {
        throw "Please enter a number for the score you think you'd earn.";
      }
      if (preScore < 0) {
        throw "Please enter a score greater than or equal to 0.";
      }
      if (preScore > 100) {
        throw "Please enter a score less than or equal to 100.";
      }

    } catch (err) {
      e.innerHTML = err;
      e.style.display = "inline";
      document.getElementById("score").focus();

    } finally {
      if ((preScore !== "") && (isNaN(preScore) === false) && (preScore >= 0)
          && (preScore <= 100)) {
        e.innerHTML = "";
        e.style.display = "none";

        displayDiagram();
      }
    }
  }


  /* validInput checks that the user has entered a name.  If so, it sets the fnameEntered 
     element in index.html to the name entered, clears any error messages from the screen, 
     calls validScore, and returns true.  Otherwise, it displays the error message, 
     validationMessage, generated by a call to checkValidity for the fn element by 
     writing it in red next to the input element. */

  function validInput() {
    var input = document.getElementById("fn"),
      err = document.getElementById("fnameErr");

    if (input.checkValidity() === false) {
      err.innerHTML = input.validationMessage;
      err.style.display = "inline";
      input.focus();
      return false;

    } else { // valid name, so proceed
      document.getElementById("fnameEntered").innerHTML = input.value;
      err.innerHTML = "";
      err.style.display = "none";

      validScore();

      return true;
    }
  }


  /* Redraw is called when the user resizes the window and by many of the
     drawing functions.  If a sentence diagram currently is displayed, then 
     it redraws the diagram based on the new window size.  Specifically, the
     width of the canvas is adjusted to be half the dimensions of the innerWidth 
     and innerHeight of the main browser window, setFontsize is called to adjust 
     the canvas font, and any diagram elements currently placed by the user are 
     redrawn.  For example, if the sentence structure is present, diag.sent is set 
     to zero and drawMainSentence is called.  Also, drawSubject and drawPredicate
     are called and sent the second and third elements of p, respectively, where 
     p is a local copy of proposal. */

  function redraw() {
    var p = [];

    if (diag.showing) {
      can.width = window.innerWidth / 2 - 10;
      can.height = window.innerHeight / 2;

      setFontSize();

      p = proposal;
      //alert ("p[0] is " + p[0] + " and proposal[0] is " + proposal[0]);
      proposal = ["", "", "", "", ""];

      if (diag.sent) {
        diag.sent = 0;
        drawMainSentence();
        drawSubject(p[1]);
        drawPredicate(p[2]);

        if (diag.dobj) {
          diag.dobj = 0;
          drawDirectObjectLine();
          drawDirectObject(p[4]);
        }

        if (diag.adj) {
          diag.adj = 0;
          drawAdjLine();
          drawAdj(p[0]);
        }

        if (diag.adv) {
          diag.adv = 0;
          drawAdvLine();
          drawAdv(p[3]);
        }
      }
    }
  }
  
  
  // ASSIGNMENT 4

  /* checkProposal compares the placement chosen by the user stored in proposal with 
     the solution stored in words.  If the sentence has four words, but the user has
     included the direct object line in the diagram (indicating a five word solution), 
     then an error message is displayed stating, "This sentence should not have a 
     direct object structure.  Please click reset and begin again."
     
     The user's score, calculated as the percentage of correct matches, is reported in 
     the feedback pane along with a list of words incorrectly placed.
     
     Directions and error messages are cleared from the display. */

  function checkProposal() {
    alert("Check Answer clicked");
  }


  /* resetAll clears all user choices stored in proposal, resets the values the 
     sent, adj, adv, and dobj properties of diag to zero, resets diag's crossLoc 
     property to 0.5, and calls redraw to show a blank canvas.  It also shows the 
     directions and clears any feedback and/or error messages. */

  function resetAll() {
    alert("Reset clicked");
  }


  convertSentence();
  can = document.getElementById("myCanvas");
  can.width = window.innerWidth / 2 - 10;
  can.height = window.innerHeight / 2;
  ctx = can.getContext("2d");
  setFontSize();

  return {
    elDragged: elDragged,
    validInput: validInput,
    processChoice: processChoice,
    redraw: redraw,
    resetAll: resetAll,
    checkProposal: checkProposal
  };
}());
