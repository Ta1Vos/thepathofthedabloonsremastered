
async function loadEvent(event) {
    event = (event);
}

function fetchFirstEvent() {
    console.log(location.host + '/game/test/item-generate');
    fetch('/game/fetch/start')
        .then(myData => myData.text())
        .then(textData => loadEvent(textData))
}

fetchFirstEvent();