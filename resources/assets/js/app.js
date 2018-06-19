
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import { Sortable } from '@shopify/draggable';

function find(selector) {
    return document.querySelector(selector)
}

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
                        $checkbox.form.submit()
                    }
                })
                $el.onchange = () => {
                    $checkboxes.forEach($child => {
                        $child.checked = $el.checked
                    })
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


    const createSortable = selector => {
        const $el = document.querySelectorAll(selector);
        return !$el ? null : new Sortable($el, {
            draggable: '.js-drag-item',
            delay: 500
        }).on('drag:start', event => {
            console.log('drag:start:')
            console.log(event)
        }).on('drag:move', event => {
    
        }).on('drag:stop', event => {
    
        })
    }
    let draggable = createSortable('.js-drag-container')
    const $addfields = getAll("[data-addtable='true']");
    if ($addfields.length > 0) {
        $addfields.forEach($el => {
            $el.addEventListener("click", () => {
                const table = find($el.dataset.target);
                const index = table.querySelectorAll('tbody > tr').length
                const tempalte = $el.dataset.template.replace(/___INDEX___/g, index)
                table.querySelector('tbody').insertAdjacentHTML('beforeend', tempalte)
                return false;
            });
        })
    }


    // 動的に追加された項目に対応する為、クリックした要素が対象の場合処理を行う。
    document.addEventListener('click', e => {
        const $el = e.target
        if($el.querySelector("[data-deletetable='true']") || $el.closest("[data-deletetable='true']")) {
            const $tr = $el.closest('tr')
            if ($tr) {
                $tr.style.display = 'none'
                const $hidden = $tr.querySelector('input[type="hidden"][name$="_delete\]"]')
                $hidden.value = 1
            }
        }
    })

});

