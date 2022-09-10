(() => {

function waitForElm(selector) {
    return new Promise(resolve => {
        if (document.querySelector(selector)) {
            return resolve(document.querySelector(selector));
        }

        const observer = new MutationObserver(mutations => {
            if (document.querySelector(selector)) {
                resolve(document.querySelector(selector));
                observer.disconnect();
            }
        });

        observer.observe(document, {
            childList: true,
            subtree: true
        });
    });
}

waitForElm('select[name="_mepr_group_theme"].group_theme_dropdown').then((elm) => {
    // force select XPERTO
    elm.value="xperto.css";
});

})();