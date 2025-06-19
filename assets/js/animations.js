// console.log('hello world!');

const startButton = document.querySelector('.start-button');

function startGame() {
    const overlayDiv = document.querySelector(`.overlay`);
    const body = document.querySelector(`body`);
    overlayDiv.style.zIndex = '10';
    overlayDiv.style.opacity = '1';
    body.style.backgroundColor = 'black';
    setTimeout(() => {
        window.location = route;
    }, 2500);
}

startButton.addEventListener('click', startGame);