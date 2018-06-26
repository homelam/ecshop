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
/******/ 	return __webpack_require__(__webpack_require__.s = 46);
/******/ })
/************************************************************************/
/******/ ({

/***/ 46:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(47);


/***/ }),

/***/ 47:
/***/ (function(module, exports) {

$(function () {
    $(".delete_product").click(function (evt) {
        var id = $(this).data('id');
        var url = $('#delete-product-form').attr('action') + '/' + id;
        $('#delete-product-form').attr('action', url);
        $('#delete-product-form').submit();
    });

    // 删除商品类型
    $(".delete-type").click(function (event) {
        var id = $(this).data("id");
        var parentTag = $(this).parent().parent();
        var reg = /^\d+$/;
        if (reg.test(id)) {
            var url = $('#delete-type-url').data('url') + '/' + id;
            var token = $('#delete-type-url').data('token');
            layer.confirm('确定删除该商品类型吗？', {
                btn: ['确认', '取消'] //按钮
            }, function () {
                $.post(url, { '_token': token, '_method': 'delete' }, function (data) {
                    if (data.code == 1) {
                        parentTag.remove();
                        layer.msg(data.msg, { time: 1000, icon: 6 });
                    } else {
                        layer.msg(data.msg, { time: 1000, icon: 5 });
                    }
                });
            }, function () {
                // 点击取消
            });
        }
    });

    // 删除属性
    $(".delete-type-attribute").click(function (event) {
        var id = $(this).data("id");
        var parentTag = $(this).parent().parent();
        var reg = /^\d+$/;
        if (reg.test(id)) {
            var url = $('#delete-attribute-url').data('url') + '/' + id;
            var token = $('#delete-attribute-url').data('token');
            layer.confirm('确定删除该属性吗？', {
                btn: ['确认', '取消'] //按钮
            }, function () {
                $.post(url, { '_token': token, '_method': 'delete' }, function (data) {
                    if (data.code == 200) {
                        parentTag.remove();
                        layer.msg(data.msg, { time: 1000, icon: 6 });
                    } else {
                        layer.msg(data.msg, { time: 1000, icon: 5 });
                    }
                });
            }, function () {
                // 点击取消
            });
        }
    });

    // 删除商品
    $(".delete_product").click(function (evt) {
        var id = $(this).data('id');
        var url = $('#delete-product-form').attr('action') + '/' + id;
        $('#delete-product-form').attr('action', url);
        $('#delete-product-form').submit();
    });
});

/***/ })

/******/ });
