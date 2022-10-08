/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./wp-content/themes/bacola-mob-child/src/js/index.js":
/*!************************************************************!*\
  !*** ./wp-content/themes/bacola-mob-child/src/js/index.js ***!
  \************************************************************/
/***/ (() => {

function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

/* jshint esversion: 6 */
var jQuery = window.jQuery;
var clearSearchBtn = document.getElementById('clearSearch');
var mobSearchValue = document.getElementById('mobSearchValue');
var searchRecent = document.getElementById('search-recent');
var resultContent = document.getElementById('resultContent');

function findParentElement(el, tag) {
  while (el.parentNode) {
    el = el.parentNode;
    if (el.tagName === tag) return el;
  }

  return null;
}

function renderRecentSearch() {
try{

  var latestLocalSearches = localStorage.getItem('latestLocalSearches');
  var recentSearchesContainer = document.getElementById('recentSearchContent');
  var latestItems = [];

  if (latestLocalSearches) {
    latestItems = JSON.parse([latestLocalSearches]);
  }

  var toRender = '';

  if (latestItems.length > 0) {
    var _iterator = _createForOfIteratorHelper(latestItems),
        _step;

    try {
      for (_iterator.s(); !(_step = _iterator.n()).done;) {
        var item = _step.value;
        toRender += item;
      }
    } catch (err) {
      _iterator.e(err);
    } finally {
      _iterator.f();
    }

    searchRecent.classList.remove('hide');
  } else {
    searchRecent.classList.add('hide');
  }

  recentSearchesContainer.innerHTML = toRender;
} catch(e){}
}

function saveRecentSearch(results) {
  var resultLinks = document.getElementsByClassName('result-link');

  for (var i = 0; i < resultLinks.length; i++) {
    resultLinks[i].addEventListener('click', function (event) {
      var target = event.target;
      var stringRow = findParentElement(target, 'LI').outerHTML;
      var latestLocalSearches = localStorage.getItem('latestLocalSearches');

      if (!latestLocalSearches) {
        localStorage.setItem('latestLocalSearches', JSON.stringify([stringRow]));
      }

      if (latestLocalSearches) {
        latestLocalSearches = JSON.parse(latestLocalSearches);

        if (!latestLocalSearches.includes(stringRow)) {
          latestLocalSearches.unshift(stringRow);

          if (latestLocalSearches.length > 5) {
            latestLocalSearches.pop();
          }

          localStorage.setItem('latestLocalSearches', JSON.stringify(latestLocalSearches));
        }
      }

      window.location = target.closest('a').href;
      event.preventDefault();
    });
  }
}

function handleSearch(valueToSearch) {
  var data = {
    'wc-ajax': 'dgwt_wcas_ajax_search',
    s: valueToSearch
  };
  jQuery.get('/', data, function (response) {
    requestResult = JSON.parse(response);
    var toRender = '';
    var stringResults = [];

    if (requestResult) {
      var _iterator2 = _createForOfIteratorHelper(requestResult.suggestions),
          _step2;

      try {
        for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
          var item = _step2.value;

          if (item.type === 'no-results') {
            toRender = 'No results';
            continue;
          }

          toRender += "\n                <li class=\"row\">\n                    <a href=\"".concat(item.url, "\" class=\"result-link\">\n                        ").concat(item.thumb_html, "\n                        <div>\n                            <h6>").concat(item.value, "</h6>\n                            <p>in: ").concat(item.category, "</p>\n                        </div>\n                    </a>\n                </li>\n                ");
        }
      } catch (err) {
        _iterator2.e(err);
      } finally {
        _iterator2.f();
      }
    }

    var resultsContent = document.getElementById('resultContent');
    resultsContent.innerHTML = toRender;
    saveRecentSearch();
  }).done(function () {
    searchRecent.classList.add('hide');
  });
}

var debounce;
try{
clearSearchBtn.addEventListener('click', function (event) {
  searchRecent.classList.remove();
  mobSearchValue.value = '';
  renderRecentSearch();
  resultContent.innerHTML = '';
  mobSearchValue.focus();
});
} catch (e){
  console.log("err");
}
try{

mobSearchValue.addEventListener('input', function (event) {
  if (event.target.value.length < 3) {
    return false;
  }

  clearTimeout(debounce);
  debounce = setTimeout(function () {
    handleSearch(event.target.value);
  }, 250);
});
} catch (e){
  console.log("err");
}
renderRecentSearch();

/***/ }),

/***/ "./wp-content/themes/bacola-mob-child/src/scss/main.scss":
/*!***************************************************************!*\
  !*** ./wp-content/themes/bacola-mob-child/src/scss/main.scss ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/wp-content/themes/bacola-mob-child/assets/js/index": 0,
/******/ 			"wp-content/themes/bacola-mob-child/assets/css/main": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkIds[i]] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunkwordpress"] = self["webpackChunkwordpress"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["wp-content/themes/bacola-mob-child/assets/css/main"], () => (__webpack_require__("./wp-content/themes/bacola-mob-child/src/js/index.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["wp-content/themes/bacola-mob-child/assets/css/main"], () => (__webpack_require__("./wp-content/themes/bacola-mob-child/src/scss/main.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;