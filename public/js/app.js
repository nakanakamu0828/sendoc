/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(1);
module.exports = __webpack_require__(3);


/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {


/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

__webpack_require__(2);

function getAll(selector) {
    return Array.prototype.slice.call(document.querySelectorAll(selector), 0);
}

document.addEventListener("DOMContentLoaded", function () {
    // burger
    var $navbarBurgers = getAll(".navbar-burger");
    if ($navbarBurgers.length > 0) {
        $navbarBurgers.forEach(function ($el) {
            $el.addEventListener("click", function () {
                var $target = document.getElementById($el.dataset.target);
                $el.classList.toggle("is-active");
                $target.classList.toggle("is-active");
            });
        });
    }

    var $autoSubmitElements = getAll(".js-auto-submit");
    if ($autoSubmitElements.length > 0) {
        $autoSubmitElements.forEach(function ($el) {
            $el.onchange = function () {
                $el.form.submit();
            };
        });
    }

    var $resetButtons = getAll("button[type='reset']");
    if ($resetButtons.length > 0) {
        $resetButtons.forEach(function ($el) {
            $el.addEventListener("click", function (event) {
                event.preventDefault();

                for (var i = 0; i < $el.form.elements.length; i++) {
                    if ('text' == $el.form.elements[i].type) {
                        $el.form.elements[i].value = "";
                    } else if ('checkbox' == $el.form.elements[i].type) {
                        $el.form.elements[i].checked = false;
                    } else if (['select', 'select-multiple'].includes($el.form.elements[i].type)) {
                        for (var j = 0; j < $el.form.elements[i].options.length; j++) {
                            $el.form.elements[i].options[j].selected = false;
                        }
                    }
                }
                $el.form.submit();
            });
        });
    }

    var $checkboxAll = getAll("[data-checkboxall]");
    if ($checkboxAll.length > 0) {
        $checkboxAll.forEach(function ($el) {
            var $checkboxes = getAll("input[type='checkbox'][name='" + $el.dataset.checkboxall + "']");
            if ($checkboxes.length > 0) {
                $checkboxes.forEach(function ($checkbox) {
                    $checkbox.onchange = function () {
                        console.log($checkbox.form);
                        $checkbox.form.submit();
                    };
                });
                $el.onchange = function () {
                    $checkboxes.forEach(function ($child) {
                        $child.checked = $el.checked;
                    });
                    console.log($el.form);
                    $el.form.submit();
                };
            }
        });
    }

    var $deleteLinks = getAll('a[data-method="delete"]');
    if ($deleteLinks.length > 0) {
        $deleteLinks.forEach(function ($el) {
            $el.addEventListener("click", function (event) {
                event.preventDefault();

                var confirm = $el.dataset.confirm;
                if (confirm) {
                    if (!window.confirm(confirm)) {
                        return false;
                    }
                }
                var url = $el.href;
                var token = getAll('meta[name="csrf-token"]')[0].content;
                var form = "\n<form id=\"delete-form\" method=\"POST\" action=\"" + url + "\" accept-charset=\"UTF-8\">\n    <input name=\"_method\" type=\"hidden\" value=\"DELETE\">\n    <input name=\"_token\" type=\"hidden\" value=\"" + token + "\">\n</form>\n";

                document.body.innerHTML += form;
                document.getElementById('delete-form').submit();
            });
        });
    }

    var $tagLinks = getAll('a.js-replace-tag');
    if ($tagLinks.length > 0) {
        $tagLinks.forEach(function ($el) {
            $el.addEventListener("click", function (event) {
                event.preventDefault();

                var $target = document.getElementById($el.dataset.targetid);
                $target.focus();
                if (navigator.userAgent.match(/MSIE/)) {
                    var r = document.selection.createRange();
                    r.text = $el.dataset.tagname;
                    r.select();
                } else {
                    var s = $target.value;
                    var p = $target.selectionStart;
                    var np = p + $el.dataset.tagname.length;
                    $target.value = s.substr(0, p) + $el.dataset.tagname + s.substr(p);
                    $target.setSelectionRange(np, np);
                }
            });
        });
    }
});

/***/ }),
/* 2 */
/***/ (function(module, exports) {



/***/ }),
/* 3 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);