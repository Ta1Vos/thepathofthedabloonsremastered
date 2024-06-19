const dialogBox = document.body.querySelector('.dialog-box');
console.log("weeee willl work");
let changeableVariable;
let dialogRunning = false;
let addConfirmAfterDialog;
let dialogTyping = true;

//This function makes it so only 1 dialog can run at a time.
function dialogPrioritizer(dialogText, addConfirmButton) {
    if (dialogRunning === false) {
        dialogRunning = true;


        if (addConfirmButton !== undefined) {
            addConfirmAfterDialog = addConfirmButton;
        }

        runDialog(dialogText);
    } else {
        setTimeout(() => {
            dialogPrioritizer(dialogText, addConfirmButton);
        }, 600);
    }
}

//This function places letters by letters in dialogs
function runDialog(dialogText, letterCount) {
    let timeOut = 25;

    if (letterCount === undefined) {
        dialogBox.innerHTML += `<p>`;
        letterCount = 0;
    }

    //Skip a line or place a letter
    if (dialogText.charAt(letterCount) === `|`) {
        dialogBox.innerHTML += `<br>`;
    } else {
        if (dialogTyping === true) {
            if (dialogText.charAt(letterCount) === `.` || dialogText.charAt(letterCount) === `!` || dialogText.charAt(letterCount) === `?` || dialogText.charAt(letterCount) === `,`) {
                timeOut = 300;
            }
        } else {
            timeOut = 0;
        }

        dialogBox.innerHTML += dialogText.charAt(letterCount);
    }

    //Function keeps running until the entire dialog has finished
    if (dialogText.length !== letterCount) {
        letterCount++;
        setTimeout(() => {
            runDialog(dialogText, letterCount);
        }, timeOut);
        //When the dialog line has finished generating
    } else {
        dialogBox.innerHTML += `</p>`;
        dialogRunning = false;

        //Add a confirm button and remove other ones
        if (addConfirmAfterDialog !== false) {
            //Remove all confirm buttons
            if (currentConfirmButton) {
                currentConfirmButton = document.querySelectorAll(`.confirm-button`);
                for (let i = 0; i < currentConfirmButton.length; i++) {
                    currentConfirmButton[i].remove();
                }
            }

            dialogBox.innerHTML += `<button class="confirm-button">Confirm</button>`;
            currentConfirmButton = document.querySelector(`.confirm-button`);

            //Add a confirm button
            if (addConfirmAfterDialog === true) {
                currentConfirmButton.addEventListener(`click`, buyItem);
                //If the call came from an item use
            } else if (addConfirmAfterDialog === `useItem`) {
                currentConfirmButton.addEventListener(`click`, function () {
                    currentConfirmButton.remove();
                    viewItemInfo(currentItemInView[0], true, true);
                });
            } else if (addConfirmAfterDialog === `sellItem`) {
                currentConfirmButton.addEventListener(`click`, function () {
                    currentConfirmButton.remove();
                    viewItemInfo(currentItemInView[0], true, undefined, true);
                });
            }

            addConfirmAfterDialog = false;
        }
    }
}

