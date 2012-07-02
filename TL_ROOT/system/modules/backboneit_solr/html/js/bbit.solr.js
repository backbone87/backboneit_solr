(function($, $$, undef) {

if(!window.bbit) bbit = {};
if(!bbit.solr) bbit.solr = {};

var LiveSearch = {},
	FOCUS_RESULT_CLASS = "focussed",
	UPDATING_RESULT_CLASS = "updating";

LiveSearch.Implements = [ Options, Events, Class.Occlude ];
LiveSearch.Binds = [ "onKeyUp", "onFocus", "onBlur", "onSubmit", "search" ];
LiveSearch.options = {
	delay: 100,
	disableFormSubmit: true,
};
LiveSearch.initialize = function(input, target, targetModule, options) {
	var self = this;
	
	self.input = input = $(input);
	if(!input) return;
	if(input.get("tag") != "input") return;
	if(input.get("type") != "text") return;
	
	if(self.occlude("bbit.solr.LiveSearch", self.input)) return self.occluded;

	self.target = target = $(target);
	if(!target) return;
	
	if(!targetModule.toInt) return;
	targetModule = targetModule.toInt();
	if(targetModule < 1) return;
	
	self.valid = true;
	self.setOptions(options);
	self.form = input.getParent("form");
	self.block = input.getParent(".block");
	addUpdating = function() { if(self.target) self.target.addClass(UPDATING_RESULT_CLASS); };
	removeUpdating = function() { if(self.target) self.target.removeClass(UPDATING_RESULT_CLASS); };
	self.request = new Request({
		url: window.location.href,
		data: { t: targetModule, l: 1 },
		method: "get",
		timeout: 1500,
		link: "cancel",
		onRequest: addUpdating,
		onTimeout: removeUpdating,
		onComplete: removeUpdating,
		onCancel: removeUpdating,
		onException: removeUpdating,
		onSuccess: function(html) {
			html = Elements.from(html);
			if(html.length) self.setResult(self.requestValue, html[0]);
		}
	});
};
LiveSearch.activate = function() {
	var self = this;
	if(!self.valid) return;
	
	self.input.addEvent("keyup", self.onKeyUp);
	self.input.addEvent("focus", self.onFocus);
	self.input.addEvent("blur", self.onBlur);
	
	if(self.form && self.options.disableFormSubmit) self.form.addEvent("submit", self.onSubmit);
	
	self.isNewValue();
};
LiveSearch.deactivate = function() {
	var self = this;
	if(!self.valid) return;
	
	clearTimeout(self.reqTimer);

	self.input.removeEvent("keyup", self.onKeyUp);
	self.input.removeEvent("focus", self.onFocus);
	self.input.removeEvent("blur", self.onBlur);
	
	if(self.form) self.form.removeEvent("submit", self.onSubmit);
};
LiveSearch.onSubmit = function(event) {
	event.preventDefault();
};
LiveSearch.onKeyUp = function() {
	this.checkValue(this.options.delay);
};
LiveSearch.onFocus = function() {
	var self = this;
	clearTimeout(self.focusTimer);
	self.focus = true;
	if(self.target) self.target.addClass(FOCUS_RESULT_CLASS);
	self.checkValue(0);
};
LiveSearch.onBlur = function() {
	var self = this;
	clearTimeout(self.focusTimer);
	self.focus = undef;
	if(self.target) self.focusTimer = self.target.removeClass.delay(150, self.target, FOCUS_RESULT_CLASS);
	self.checkValue(0);
};
LiveSearch.checkValue = function(delay) {
	var self = this;
	clearTimeout(self.reqTimer);
	if(!self.isNewValue()) return;
	self.reqTimer = setTimeout(self.search, delay);
};
LiveSearch.isNewValue = function() {
	var self = this, value = self.getInputValue(), isNew = value != self.value;
	self.value = value;
	return isNew;
};
LiveSearch.getInputValue = function() {
	return this.input.get("value").clean().toLowerCase();
};
LiveSearch.search = function() {
	var self = this;
	if(!self.value) return;
	self.request.options.data.q = self.requestValue = self.value;
	self.request.send();
};
LiveSearch.setResult = function(value, result) {
	result = $(result);
	if(!result) return;
	
	var self = this;
	
	if(self.target) result.replaces(self.target);
	else if(self.block) result.inject(self.block, "after");
	else result.inject(self.input, "after");
	
	if(self.focus) result.addClass(FOCUS_RESULT_CLASS);
	
	self.targetValue = value;
	self.target = result;
};

bbit.solr.LiveSearch = new Class(LiveSearch);

})(document.id, window.$$);