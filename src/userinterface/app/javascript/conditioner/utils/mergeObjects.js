!function (e) {
	"use strict";
	var t = function (e, n) {

		if(!e){
			e = window;
		}

		var o = Array.isArray(n), c = o && [] || {};
		return n = n || {}, o ? c = n.concat() : (e && "object" == typeof e && Object.keys(e).forEach(function (t) {
			c[t] = e[t]
		}), Object.keys(n).forEach(function (o) {
			c[o] = "object" == typeof n[o] && n[o] && e[o] ? t(e[o], n[o]) : n[o]
		})), c
	};
	"undefined" != typeof module && module.exports ? module.exports = t : "function" == typeof define && define.amd ? define(function () {
		return t
	}) : e.mergeObjects = t
}(this);