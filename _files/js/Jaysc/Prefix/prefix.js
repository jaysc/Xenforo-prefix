const cookieName = "xf_jaysc_prefix_epanded";

function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie =
        name + "=" + (value || "") + expires + "; path=/; SameSite=Strict";
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(";");
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == " ") c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}
function eraseCookie(name) {
    setCookie(name, "", -1);
}

function togglePrefixList(event) {
    const prefixList = document.querySelector("#prefix_list");
    if (!prefixList) {
        console.error("Prefix list not found!");
        return;
    }

    const prefixes = prefixList.querySelectorAll(
        "a.label:not(.prefix--selected)"
    );
    const icon = document.querySelector("#toggle_prefix_display i");

    if (icon.classList.contains("fa-chevron-right")) {
        // expand
        prefixes.forEach((prefix) => {
            prefix.classList.remove("prefix--hide");
        });

        icon.classList.remove("fa-chevron-right");
        icon.classList.add("fa-chevron-left");

        setCookie(cookieName, true, 999);
    } else {
        // hide
        prefixes.forEach((prefix) => {
            prefix.classList.add("prefix--hide");
        });

        icon.classList.remove("fa-chevron-left");
        icon.classList.add("fa-chevron-right");

        eraseCookie(cookieName);
    }
}

function init() {
    const toggleButton = document.querySelector("#toggle_prefix_display");
    if (!toggleButton) {
        console.error("Toggle button for prefix expander not found!");
        return;
    }

    const prefixList = document.querySelector("#prefix_list");
    const prefixes = prefixList.querySelectorAll(
        "#prefix_list a.prefix--hide-js"
    );
    const expanded = !!getCookie(cookieName); 

    if (!expanded) {
        const showAll = prefixList.querySelector("#prefix_show_all");
        showAll.classList.add("prefix--hide");
    }
    if (prefixes.length > 0) {
        if (expanded) {
            prefixes.forEach((prefix) => {
                prefix.classList.remove("prefix--hide-js");
            });
        } else {
            prefixes.forEach((prefix) => {
                prefix.classList.remove("prefix--hide-js");
                prefix.classList.add("prefix--hide");
            });
        }

        toggleButton.addEventListener("click", togglePrefixList);
    } else {
        toggleButton.remove();
    }
}

init();
