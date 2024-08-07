/* LD_Echo © 2024 by J Loiacano is licensed under CC BY-NC-ND 4.0  */

/* mimimize and use the LD_Echo.min.js file as that is the one that the inline scripter calls... */
/* https://www.freeformatter.com/javascript-minifier.html */
let LD_Echo_startTime = new Date();
var LD_Echo = LD_Echo || {};

window.addEventListener('DOMContentLoaded', () => {
    LD_Echo.init();
});

LD_Echo = {
    init: function () {
        this.SetUpLDEchoCloseButtons();
        this.SetUpLDEchoMinimizeButtons();
        this.SetUpLDEchoMaximizeButtons();
        this.SetUpLDEchoLimitButtons();
        this.SetUpLDEchoCopyButtons();
        this.SetUpEchoConsoleLineCollapsibleElements();

        this.LogLoadedToConsole();
    },

    SetUpLDEchoCloseButtons: function () {
        var closeButtons = document.getElementsByClassName('echo-console-close-button');

        if (closeButtons != undefined) {
            closeButtons = Array.from(closeButtons);
            closeButtons.forEach(closeButton => closeButton.addEventListener('click', event => {
                LD_Echo.CloseConsole(closeButton);
            }));
        }

    },

    SetUpLDEchoMinimizeButtons: function () {
        var minimizeButtons = document.getElementsByClassName('echo-console-minimize-button');

        if (minimizeButtons != undefined) {
            minimizeButtons = Array.from(minimizeButtons);
            minimizeButtons.forEach(minimizeButton => minimizeButton.addEventListener('click', event => {
                LD_Echo.MinimizeConsoleDisplay(minimizeButton);
            }));
        }
    },

    SetUpLDEchoMaximizeButtons: function () {
        var maximizeButtons = document.getElementsByClassName('echo-console-maximize-button');

        if (maximizeButtons != undefined) {
            maximizeButtons = Array.from(maximizeButtons);
            maximizeButtons.forEach(maximizeButton => maximizeButton.addEventListener('click', event => {
                LD_Echo.MaximizeConsoleDisplay(maximizeButton);
            }));
        }
    },

    SetUpLDEchoLimitButtons: function () {
        var limitButtons = document.getElementsByClassName('echo-console-limit-button');

        if (limitButtons != undefined) {
            limitButtons = Array.from(limitButtons);
            limitButtons.forEach(limitButton => limitButton.addEventListener('click', event => {
                LD_Echo.LimitConsoleDisplay(limitButton);
            }));
        }
    },

    SetUpLDEchoCopyButtons: function () {
        var copyButtons = document.getElementsByClassName('echo-console-copy-button');

        if (copyButtons != undefined) {
            copyButtons = Array.from(copyButtons);
            copyButtons.forEach(copyButton => copyButton.addEventListener('click', event => {
                LD_Echo.CopyConsoleContents(copyButton);
            }));
        }
    },

    SetUpEchoConsoleLineCollapsibleElements: function () {
        var allCollapsibleConsoleLineSpans = document.getElementsByClassName('collapsable');

        if (allCollapsibleConsoleLineSpans != undefined) {
            collapsibleConsoleLineSpans = Array.from(allCollapsibleConsoleLineSpans);
            collapsibleConsoleLineSpans.forEach(collapsibleConsoleLineSpan => {
                LD_Echo.CheckIfLastCollapsibleChild(collapsibleConsoleLineSpan);
            });
        }

        var newCollapsibleConsoleLineSpans = document.getElementsByClassName('collapsable');
        if (newCollapsibleConsoleLineSpans != undefined) {
            collapsibleConsoleLineSpans = Array.from(newCollapsibleConsoleLineSpans);
            collapsibleConsoleLineSpans.forEach(collapsibleConsoleLineSpan =>
                collapsibleConsoleLineSpan.addEventListener('click', event => {
                    event.stopPropagation();
                    LD_Echo.CollapseConsoleLineChildren(event.currentTarget);
                })
            );
        }
    },

    CloseConsole: function (clickedCloseButton) {
        var wholeConsole = clickedCloseButton.closest('.echo-console-container');
        wholeConsole.style.display = 'none';
    },

    MinimizeConsoleDisplay: function (clickedMinimizeButton) {
        var wholeConsole = clickedMinimizeButton.closest('.echo-console-container');
        wholeConsole.classList.add('minimized-console');
        wholeConsole.classList.remove('limited-console');
        wholeConsole.classList.remove('maximized-console');
    },

    MaximizeConsoleDisplay: function (clickedMaximizeButton) {
        var wholeConsole = clickedMaximizeButton.closest('.echo-console-container');
        wholeConsole.classList.add('maximized-console');
        wholeConsole.classList.remove('minimized-console');
        wholeConsole.classList.remove('limited-console');
    },

    LimitConsoleDisplay: function (clickedLimitButton) {
        var wholeConsole = clickedLimitButton.closest('.echo-console-container');
        wholeConsole.classList.add('limited-console');
        wholeConsole.classList.remove('minimized-console');
        wholeConsole.classList.remove('maximized-console');
    },

    CopyConsoleContents: function (clickedCopyButton) {
        var wholeConsole = clickedCopyButton.closest('.echo-console-container');
        var title = wholeConsole.querySelector('.title');
        var consoleDisplay = wholeConsole.querySelector('.echo-console-display');
        var copyButtonText = clickedCopyButton.querySelector('.echo-console-copy-button-text');
        var textArea = consoleDisplay.querySelector('.hidden-console-text-area');
        textArea.select();
        textArea.setSelectionRange(0, 99999);
        clickedCopyButton.classList.add('copying');
        copyButtonText.textContent = 'COPYING...';
        navigator.clipboard
            .writeText(textArea.value)
            .then(() => {
                setTimeout(() => {
                    clickedCopyButton.classList.remove('copying');
                    clickedCopyButton.classList.add('copied');
                    copyButtonText.textContent = 'COPIED!';

                    setTimeout(() => {
                        clickedCopyButton.classList.remove('copied');
                        copyButtonText.textContent = 'COPY';
                    }, 2000);
                }, 1000);
            })
            .catch(() => {
                alert("something went wrong");
            });
    },

    CheckIfLastCollapsibleChild: function (collapsibleConsoleLineSpan) {
        var echoConsoleLine = collapsibleConsoleLineSpan.parentElement;
        if (echoConsoleLine.querySelector('.echo-console-line') == undefined) {
            LD_Echo.RemoveCollapsibility(collapsibleConsoleLineSpan);
        }
    },

    RemoveCollapsibility: function (collapsibleConsoleLineSpan) {
        var upArrow = collapsibleConsoleLineSpan.querySelector('.up-arrow');
        var downArrow = collapsibleConsoleLineSpan.querySelector('.down-arrow');
        collapsibleConsoleLineSpan.removeAttribute("title");
        collapsibleConsoleLineSpan.classList.remove('collapsable');
        upArrow.remove();
        downArrow.remove();
    },

    CollapseConsoleLineChildren: function (clickedConsoleLineSpan) {
        var echoConsoleLine = clickedConsoleLineSpan.parentElement;
        var classList = echoConsoleLine.classList;
        if (classList.contains('collapsed')) {
            classList.remove('collapsed');
            clickedConsoleLineSpan.title = 'Collapse';
        }
        else {
            classList.add('collapsed');
            clickedConsoleLineSpan.title = 'Expand';
        }
    },

    LogLoadedToConsole: function () {
        let LD_Echo_endTime = new Date();
        let elapsed = LD_Echo_endTime - LD_Echo_startTime;
        console.log('LD_Echo.js has been loaded in: ' + elapsed + 'ms');
    }
}
