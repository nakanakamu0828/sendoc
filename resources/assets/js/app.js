
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


function getAll(selector) {
    return Array.prototype.slice.call(document.querySelectorAll(selector), 0);
}


document.addEventListener("DOMContentLoaded", () => {
    // burger
    const $navbarBurgers = getAll(".navbar-burger");
    if ($navbarBurgers.length > 0) {
        $navbarBurgers.forEach($el => {
            $el.addEventListener("click", () => {
                const $target = document.getElementById($el.dataset.target);
                $el.classList.toggle("is-active");
                $target.classList.toggle("is-active");
            })
        })
    }


    const $autoSubmitElements = getAll(".js-auto-submit");
    if ($autoSubmitElements.length > 0) {
        $autoSubmitElements.forEach($el => {
            $el.onchange = () => {
                $el.form.submit();
            }
        })
    }


    const $resetButtons = getAll("button[type='reset']");
    if ($resetButtons.length > 0) {
        $resetButtons.forEach($el => {
            $el.addEventListener("click", event => {
                event.preventDefault()

                for(let i = 0; i < $el.form.elements.length; i++) {
                    if ('text' == $el.form.elements[i].type) {
                        $el.form.elements[i].value = ""
                    } else if ('checkbox' == $el.form.elements[i].type) {
                        $el.form.elements[i].checked = false
                    } else if (['select', 'select-multiple'].includes($el.form.elements[i].type)) {
                        for(let j = 0; j < $el.form.elements[i].options.length; j++) {
                            $el.form.elements[i].options[j].selected = false
                        }
                    }
                    
                }
                $el.form.submit();
            })
        })
    }

    const $checkboxAll = getAll("[data-checkboxall]");
    if ($checkboxAll.length > 0) {
        $checkboxAll.forEach($el => {
            const $checkboxes = getAll("input[type='checkbox'][name='" + $el.dataset.checkboxall + "']");
            if ($checkboxes.length > 0) {
                $checkboxes.forEach($checkbox => {
                    $checkbox.onchange = () => {
                        console.log($checkbox.form)
                        $checkbox.form.submit()
                    }
                })
                $el.onchange = () => {
                    $checkboxes.forEach($child => {
                        $child.checked = $el.checked
                    })
                    console.log($el.form)
                    $el.form.submit()
                }
            }
        })
    }

    const $deleteLinks = getAll('a[data-method="delete"]');
    if ($deleteLinks.length > 0) {
        $deleteLinks.forEach($el => {
            $el.addEventListener("click", event => {
                event.preventDefault()

                const confirm = $el.dataset.confirm;
                if (confirm) {
                    if (!window.confirm(confirm)) {
                        return false;
                    }
                }
                const url = $el.href
                const token = getAll('meta[name="csrf-token"]')[0].content;
                const form = `
<form id="delete-form" method="POST" action="${url}" accept-charset="UTF-8">
    <input name="_method" type="hidden" value="DELETE">
    <input name="_token" type="hidden" value="${token}">
</form>
`

                document.body.innerHTML += form;
                document.getElementById('delete-form').submit()
            })
        })
    }

    const $tagLinks = getAll('a.js-replace-tag');
    if ($tagLinks.length > 0) {
        $tagLinks.forEach($el => {
            $el.addEventListener("click", event => {
                event.preventDefault()

                const $target = document.getElementById($el.dataset.targetid)
                $target.focus()
                if(navigator.userAgent.match(/MSIE/)) {
                    const r = document.selection.createRange();
                    r.text = $el.dataset.tagname;
                    r.select();
                } else {
                    const s = $target.value;
                    const p = $target.selectionStart
                    const np = p + $el.dataset.tagname.length
                    $target.value = s.substr(0, p) + $el.dataset.tagname + s.substr(p)
                    $target.setSelectionRange(np, np);
                }
            })
        })
    }

});

