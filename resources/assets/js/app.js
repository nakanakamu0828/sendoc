
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')


import ClipBoard from 'clipboard'
import { Sortable } from '@shopify/draggable'
// import bulmaCalendar from 'bulma-extensions/bulma-calendar/dist/js/bulma-calendar.js'


function getAll(selector) {
    return Array.prototype.slice.call(document.querySelectorAll(selector), 0);
}

const sum  = arr => {
    return arr.reduce((prev, current, i, arr) => {
        return prev + current;
    })
}

document.addEventListener("DOMContentLoaded", () => {

    // const datePickers = bulmaCalendar.attach('[type="date"]', {
    //     overlay: false,
    // });

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
    // dropdown menu
    const $dropdowns = getAll('.dropdown:not(.is-hoverable) [dropdown="true"]')
    if ($dropdowns.length > 0) {
        $dropdowns.forEach($el => {
            $el.addEventListener("click", event => {
                const $dropdown  = $el.closest('.dropdown:not(.is-hoverable)')
                $dropdown.classList.toggle("is-active")
            })
        })

        document.addEventListener("click", event => {
            if(!event.target.closest('.dropdown')) {
                $dropdowns.forEach($el => {
                    const $dropdown  = $el.closest('.dropdown:not(.is-hoverable)')
                    $dropdown.classList.remove("is-active")
                });
            }
        });
    }
    // Modal
    const $modals = getAll('a[data-toggle="modal"][data-targetid], button[data-toggle="modal"][data-targetid]')
    if ($modals.length > 0) {
        $modals.forEach($el => {
            $el.addEventListener("click", event => {
                event.preventDefault()
                document.getElementById($el.dataset.targetid).classList.toggle("is-active");
            })
        })
    }
    document.addEventListener('click', e => {
        if(e.target.closest(".modal-background") || e.target.closest(".modal-close")) {
            e.target.closest(".modal").classList.remove('is-active');
        }
    })

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


    const $addfields = getAll("[data-addfiled='true']");
    if ($addfields.length > 0) {
        $addfields.forEach($el => {
            $el.addEventListener("click", () => {
                const $block = document.querySelector($el.dataset.target)
                const index = $block.querySelectorAll('.js-addfield-block').length
                const tempalte = $el.dataset.template.replace(/___INDEX___/g, index)
                $block.insertAdjacentHTML('beforeend', tempalte)
                return false;
            });
        })
    }

    // 動的に追加された項目に対応する為、クリックした要素が対象の場合処理を行う。
    document.addEventListener('click', e => {
        const $el = e.target
        if($el.closest("[data-deletefiled='true']")) {
            const $block = $el.closest('.js-addfield-block')
            if ($block) {
                $block.style.display = 'none'
                const $hidden = $block.querySelector('input[type="hidden"][name$="_delete\]"]')
                $hidden.value = 1
            }
        }
    })

    const $datalists = getAll("input[data-list]");
    if ($datalists.length > 0) {
        $datalists.forEach($el => {
            const $dropdown = document.getElementById($el.dataset.list)
            if ($dropdown) {
                $el.addEventListener("focus", () => {
                    $dropdown.classList.add("is-active")
                })
                const $items = $dropdown.querySelectorAll('.dropdown-item');
                if ($items && $items.length > 0) {
                    $items.forEach($item => {
                        $item.addEventListener('click', e => {
                            $el.value = e.target.innerText
                            $dropdown.classList.remove("is-active")
                        })
                    })
                }
                document.addEventListener('click', e => {
                    if(!e.target.closest('#' + $el.dataset.list) && !e.target.closest('input[data-list]')) {
                        $dropdown.classList.remove("is-active")
                    }
                })
            }
        })
    }

    const clipboard = new ClipBoard('.js-clipboard')
    clipboard.on('success', e => {
        e.trigger.classList.add("tooltip")
        e.trigger.classList.add("is-tooltip-active")
        
        setTimeout(() => {
            e.trigger.classList.remove("tooltip")
            e.trigger.classList.remove("is-tooltip-active")
		}, 3000)
    })


    // 請求書作成ページ
    if(
        document.querySelector('.invoice-create')
        || document.querySelector('.invoice-edit')
        || document.querySelector('.invoice-copy')
        || document.querySelector('.estimate-create')
        || document.querySelector('.estimate-edit')
        || document.querySelector('.estimate-copy')
    ) {
        const createSortable = selector => {
            const $el = document.querySelectorAll(selector);
            return !$el ? null : new Sortable($el, {
                draggable: '.js-drag-item',
                delay: 500
            }).on('drag:start', event => {
            }).on('drag:move', event => {
            }).on('drag:stop', event => {
            })
        }

        const calculatorTotal = () => {
            const $subtotals = getAll('.js-item-subtotal').map($e => $e.closest('tr') && $e.closest('tr').style.display == 'none' ? 0 : parseInt($e.innerText))
            const tax_rate = document.querySelector('input[name="in_tax"]').checked ? document.querySelector('select[name="tax_rate"]').value : 0

            const subtotal = sum($subtotals)
            const tax = sum($subtotals.map($p => $p * tax_rate / 100))

            getAll('.js-subtotal').forEach($el => {
                $el.innerText = subtotal
            })
            getAll('.js-tax').forEach($el => {
                $el.innerText = tax
            })
            getAll('.js-total').forEach($el => {
                $el.innerText = subtotal + tax
            })
        }

        let draggable = createSortable('.js-drag-container')
        const $addfields = getAll("[data-addtable='true']");
        if ($addfields.length > 0) {
            $addfields.forEach($el => {
                $el.addEventListener("click", () => {
                    const table = document.querySelector($el.dataset.target)
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
            if($el.closest("[data-deletetable='true']")) {
                const $tr = $el.closest('tr')
                if ($tr) {
                    $tr.style.display = 'none'
                    const $hidden = $tr.querySelector('input[type="hidden"][name$="_delete\]"]')
                    $hidden.value = 1

                    calculatorTotal()
                }
            }
        })

        // 税込設定の変更
        document.querySelector('input[name="in_tax"]').addEventListener('change', () => {
            calculatorTotal()
        })
        // 税率の変更
        document.querySelector('select[name="tax_rate"]').addEventListener('change', () => {
            calculatorTotal()
        })

        // 商品毎の単価・数量が変わった時の金額計算処理
        // 動的に追加された項目に対応する為、全てのchangeイベントから対象要素だけ抽出
        document.addEventListener('change', e => {
            const $el = e.target
            if($el.classList.contains('js-trigger-change-item')) {
                const $tr = $el.closest('tr')
                if ($tr) {
                    const price = parseInt($tr.querySelector('[name$="[price]"]').value)
                    const quantity = parseInt($tr.querySelector('[name$="[quantity]"]').value)
                    $tr.querySelector('.js-item-subtotal').innerText = (price * quantity)


                    calculatorTotal()
                }
            }
        })
    }
});

