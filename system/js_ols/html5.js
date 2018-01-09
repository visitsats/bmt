(function($) {

	$.fn.h5form = function(options) {
		// Check UA
		var ua = window.navigator.userAgent.toLowerCase(),
			msie = parseInt(ua.replace(/.*msie (\d+).*/, "$1")),
			firefox = parseInt(ua.replace(/.*firefox\/(\d+).*/, "$1")),
			chrome = parseInt(ua.replace(/.*chrome\/(\d+).*/, "$1")),
			opera = parseInt(ua.replace(/.*opera[\/ ](\d+).*/, "$1")),	// "opara/9.80" or "opera 10.10"
			safari = parseInt(ua.replace(/.*version\/(\d+).*safari.*/, "$1")),	// "Version/5.0 Safari/533.16"
			android = (navigator.userAgent.search(/Android/) != -1);

		if (opera > 9) return;

		$.fn.outerHTML = function() {
			// Firefox 10 or earlier does not have outerHTML
			var obj = $(this).get(0);
			return obj.outerHTML || new XMLSerializer().serializeToString(obj);
		};

		//default configuration properties
		var defaults = {
			exprResponse: '.h5form-response, .h5form-reversed',
			exprBehind: '.h5fom-behind',
			styleErr: { backgroundColor: '',border:'#E9322D solid 1px;'},
			msgEmpty: 'Please enter this field.',
			msgUnselct: 'Please select an item.',
			msgUncheck: 'Please check this checkbox.',
			msgPattern: 'Does not match the required pattern.',
			msgEmail: 'E-mail address is not correct.',
			msgUrl: 'URL is not correct.',
			colorOff: '#a1a1a1',
			msgMaxlen: 'Too many # characters.',
			msgInvalid: 'Value is invalid.',
			msgMin: 'Please be greater than or equal to #.',
			msgMax: 'Please be less than or equal to #.',
			addSpin: true,
			classSpinNumber: 'h5form-spinNumber',
			classRange: 'h5form-range',
			classSpinTime: 'h5form-spinTime',
			classDatetime: 'h5form-datetime',
			datepicker: { },
			hasOptions: [],
			dynamicHtml: '.h5form-dynamic'
		};
		var opts = $.extend({}, defaults, options);

		// Test browser
		var test1 = $('<input>').hide().appendTo($('body')).get(0),
			test2 = $('textarea:first').get(0) || new Object(),
			hasCustomValidity = ('setCustomValidity' in test1) && !android,
			hasAppendTitle = chrome || (msie > 9),
			hasAutofocus = ('autofocus' in test1),
			hasRequired = ('required' in test1) && !android,
			hasPattern = ('pattern' in test1) && !android,
			hasEmail = hasUrl = hasCustomValidity && hasPattern && !android, // maybe
			hasPlaceholder = ('placeholder' in test1),
			hasNumber = hasSpin = hasRange =
				('step' in test1) && ('min' in test1) && !android && !firefox,
			hasDateTime = false,
			hasDate = hasDateTime || chrome > 21,
			hasTime = hasDateTime || chrome > 22,
			hasMaxlength = ('maxLength' in test2),
			hasFormAttr = ('form' in test1) && ('formAction' in test1) && !android,
			hasDatalist = ('autocomplete' in test1) && ('list' in test1),
			hasBugButton = (msie && msie < 8);
			hasBugEnter = (msie && msie < 9) || android;

		for (i = opts.hasOptions.length-1; i >= 0; i--) {
			eval(opts.hasOptions[i] + '=true;');
		}

		$('input:last').remove();

		var validatable = ':input:enabled:not(:button, :submit)';
		// clear balloons
		$(validatable).click(function() {
			$(this).siblings(opts.exprResponse).remove();
			$(opts.exprBehind).removeAttr('disabled');
		});
		$(validatable).live('keypress',function(e) {
			$(this).siblings(opts.exprResponse).remove();
			$(opts.exprBehind).removeAttr('disabled');
		});
		$(document).on('click', opts.exprResponse, function() {
			$(this).remove();
		});

		// for each form
		return this.each(function() {

			//Private properties
			var form = $(this),
				firstTime = true,
				elmAutofocus,
				elmPlaceholder = new Array(),
				validatableElements = form.find(validatable),
				novalidate = !!form.outerHTML().match(/^[^>]+ novalidate/);
				// form.attr('novalidate') result undefined,
				// when from has simply "novalidate" rather than "novalidate='novalidate'"

			/**
			 * Change Type
			 * @param {string} type -- type.
			 * @return {object} -- this.
			 */
			$.fn.typeTo = function(type) {
				var ui = $(this),
					at = ui.get(0).attributes,
					ui2 = $('<input type="'+type+'">');

				for(i = at.length-1; i>=0; i--) {
					name = at[i].nodeName;
					value = at[i].nodeValue;
					if (name && value) {
						if (name == 'type') {
							type = value;	// original type for additional class
						} else {
							ui2.attr(name, value);
						}
					}
				}
				ui2.addClass('h5form-'+type);

				return ui2.replaceAll(ui);
			};

			/**
			 * Set a custom Validity to the elements
			 * @param {string} message -- message.
			 * @return {object} -- this.
			 */
			$.fn.setCustomValidity = function(message) {
				if (novalidate) message = null;
				var ui = $(this);
				if (ui.is(validatable)) {
					// Add a title to the message
					if (!hasAppendTitle && message && (title = ui.getAttr('title'))) {
						message += '\n' + title;
					}
					// Set a custon validity
	
					if (hasCustomValidity) {
						ui.get(0).setCustomValidity(message);
					} else {
						if (message) {
							ui.data('customValidity', message.replace(/\n/, '<br />'));
						} else {
							ui.removeData('customValidity');
						}

						if (!firstTime && opts.styleErr) {
							if (message) {
								ui.css(opts.styleErr);
							} else {
								for (key in opts.styleErr) {
									ui.css(key, '');
								}
								ui.css('border','#ccc solid 1px;');
							}
						}
					}
				}
				return ui;
			};

			/**
			 * Spin number or time
			 * @param {bool} isDown -- isDown.
			 * @return {object} -- this.
			 */
			$.fn.spin = function(isDown) {
				var ui = $(this),
					isNumber = (ui.getAttr('type').toLowerCase() == 'number'),
					min = attr2num(ui, 'min', (isNumber) ? '' : 0),
					max = attr2num(ui, 'max', (isNumber) ? '' : 86400),
					step = attr2num(ui, 'step', (isNumber) ? 1 : 60),
					base = (isNumber) ? min : 0,
					val = (isNumber) ? Number(ui.val()) : str2sec(ui.val(), true);

				val = val - ((val - base) % step) + step * ((isDown) ? -1 : 1);

				if (max != '' && val > max) val = max;
				if (min != '' && val < min) val = min;

				ui.val((isNumber) ? val : sec2str(val, step % 60, true));
				return ui;
			};

			$.fn.getAttr = function(name) {
				var attr = $(this).attr(name);
				return (attr == undefined) ? '' : attr;
			};

			/**
			 * For each control function
			 * @return {object} -- this.
			 */
			$.fn.initControl = function() {
				return this.each(function() {

					var ui = $(this),
						type = ui.getAttr('type').toLowerCase();

					// Is autofoucs
					if (!hasAutofocus && !elmAutofocus && ui.getAttr('autofocus')) {
						elmAutofocus = ui;
					}
					// Focus and blur attach for Placeholder
					var placeholder = ui.getAttr('placeholder');

					if (!hasPlaceholder && placeholder && type != 'password') {
						elmPlaceholder.push(ui);

						var evFocus = (function() {
							if (ui.val() == placeholder) {
								ui.attr('value', '').css('color', '');
							}
						});
						ui.unbind('focus', evFocus).focus(evFocus);

						var evBlur = (function() {
							if (ui.val() == '' || ui.val() == placeholder) {
								ui.val(placeholder).css('color', opts.colorOff);
							}
						});
						ui.unbind('blur', evBlur).blur(evBlur).blur();
					}

					// Spin button
					if (
						(!hasSpin && type == 'number') ||
						(!hasTime && type == 'time') ||
						false) {
						var className, allow;
						ui = ui.typeTo('text');
						switch (type) {
						case 'number':
							className = opts.classSpinNumber;
							allow = [8, 9, 35, 36, 37, 39, 46, 190];
							break;
						default:
							className = opts.classSpinTime;
							allow = [8, 9, 35, 36, 37, 39, 46, 59, 186, 190];
							break;
						}

						// Keydown event attach
						var evKeydown = (function(ev) {
							var cc = ev.charCode || ev.keyCode;
							if (cc == 38) ui.spin(0);
							if (cc == 40) ui.spin(1);
							if (($.inArray(cc, allow) >= 0) || (cc >= 48 && cc <= 57)) return true;
							return false;
						});
						ui.unbind('keydown', evKeydown).keydown(evKeydown);

						if (opts.addSpin) {
							ui.after('<span class="' + className + '">' +
									 '<button type="button">&and;</button>' +
									 '<button type="button">&or;</button></span>');

							// Click button
							ui.next().children().click(function() {
								ui.spin(ui.next().children().index($(this))).change();
								// change for Chrome
							});
						}
					}

					// Datepicker
					if (!hasDate && (type == 'date') && ('datepicker' in ui)) {
						var option = opts.datepicker;
						option.dateFormat = 'yy-mm-dd';
						option.minDate = ui.getAttr('min');
						option.maxDate = ui.getAttr('max');
						ui = ui.typeTo('text').datepicker(option);
					}

					// Slider
					if (!hasRange && (type == 'range') && ('slider' in ui)) {
						var min = attr2num(ui, 'min', 0),
							max = attr2num(ui, 'max', 100),
							step = attr2num(ui, 'step', 1),
							val = attr2num(ui, 'val', (min + max) / 2 - ((min + max) / 2 % step));

						ui.hide().after('<span class="' + opts.classRange +
										'"><div></div></span>').val(val);
						ui.next().children().slider({
							min: min, max: max, step: step, value: val,
							change: function(ev, sl) {
								ui.val($(this).slider('value'));
							}
						});
					}

					// Maxlength
					if (!hasMaxlength && ui.is('textarea') &&
						(maxlength = ui.getAttr('maxlength'))) {
						// Keypress event attach
						var evKeypress = (function(ev) {
							var cc = ev.charCode || ev.keyCode;
							if (($.inArray(cc, [8, 9, 37, 39, 46]) < 0) &&
								(this.value.length >= maxlength)) {
								return false;
							}
							return true;
						});
						ui.unbind('keypress', evKeypress).keypress(evKeypress);
					}

					// Datetime
					if (!hasDateTime && (type == 'datetime' || type == 'datetime-local')) {
						if (!ui.next().hasClass(opts.classDatetime)) {
							var val = getLocalDatetime(ui.val()),
								min = getLocalDatetime(ui.getAttr('min')),
								max = getLocalDatetime(ui.getAttr('max')),
								tz = (type == 'datetime') ?
									'<span class="h5form-timezone">' + getTZ() + '</span>' : '';

							ui.hide().after(
								'<span class="' + opts.classDatetime + '">' +

								'<input type="date" value="' + val[0] + '"' +
								' min="' + min[0] + '" max="' + max[0] + '"' +
								' size="' + ui.getAttr('size') + '"' +
								' class="' + ui.getAttr('class') + '"' +
								' title="' + ui.getAttr('title') + '">' +

								'<input type="time" value="' + val[1] + '"' +
								' step="' + attr2num(ui, 'step', 60) + '"' +
								' size="' + ui.getAttr('size') + '"' +
								' class="' + ui.getAttr('class') + '"' +
								' title="' + ui.getAttr('title') + '">' +
								tz +
								'</span>');
							if (ui.getAttr('required')) {
								ui.removeAttr('required');
								ui.next().children().attr('required', 'required').initControl();
							} else {
								ui.next().children().initControl();
							}
						}
					}
					if ((!hasDatalist) &&
						(list = ui.getAttr('list')) &&
						('autocomplete' in ui))
					{
						var arr = new Array();
						$('datalist#'+list).children('option').each(function () {
							arr.push($(this).val());
						});
						// Avoid conflicts with the browser
						ui.removeAttr('list');

						ui.autocomplete({
							source: arr,
							// under imput method
							search: function(ev, ui) {
								if (ev.keyCode == 229) return false;
								return true;
							}

						})
						.keyup(function(ev) {
							// output imput method
							if (ev.keyCode == 13) $(this).autocomplete('search');
						});
					}

					/**
					 * Change event
					 * @return {bool} -- isNecessary.
					 */
					var evChange = (function() {

						var isNecessary = false,
							name = ui.attr('name'),
							isChecked = $('[name="'+name+'"]:checked').length,
							isEmpty = ((ui.val() == '') ||
									   (ui.is(':checkbox, :radio') && !isChecked) ||
									   (placeholder && ui.val() == placeholder) ||
									   false);

						// clear validity first
						$('[name="'+name+'"]').setCustomValidity(null);
						if (hasBugEnter && !ui.is('select, textarea, button')) {
							// Keypress event attach
							var evKeypress2 = (function(ev) {
								var cc = ev.charCode || ev.keyCode;
/*								if (cc == 13) {
									form.find('input:submit, button:submit').eq(0).click();
									return false;
								}*/
								return true;
							});
							ui.unbind('keypress', evKeypress2).keypress(evKeypress2);
							isNecessary = true;
						}
						// Required
						if (!hasRequired && ui.getAttr('required')) {
							isNecessary = true;
							if (isEmpty) {
								var msg = opts.msgEmpty;
								if (ui.is('select, :radio')) msg = opts.msgUnselct;
								if (ui.is(':checkbox')) msg = opts.msgUncheck;
								ui.setCustomValidity(msg);
								return true;
							}
						}
						// Pattern
						if (!hasPattern && (pattern = ui.getAttr('pattern'))) {
							isNecessary = true;
							if (!isEmpty &&
								validateRe(ui, '^(' + pattern.replace(/^\^?(.*)\$?$/, '$1') + ')$')) {
								ui.setCustomValidity(opts.msgPattern);
								return true;
							}
						}
						// Email
						if (!hasEmail && type == 'email') {
							isNecessary = true;
							if (!isEmpty && validateRe(ui,
							   '[\\w-\\.]{3,}@([\\w-]{2,}\\.)*([\\w-]{2,}\\.)[\\w-]{2,4}', 'i')) {
								ui.setCustomValidity(opts.msgEmail);
								return true;
							}
						}

						// URL
						if (!hasUrl && type == 'url') {
							isNecessary = true;
							if (!isEmpty && validateRe(ui,
							   '[\\w-\\.]{3,}:\\/\\/([\\w-]{2,}\\.)*([\\w-]{2,}\\.)[\\w-]{2,4}',
							   'i')) {
								ui.setCustomValidity(opts.msgUrl);
								return true;
							}
						}

						// Maxlength
						if (!hasMaxlength && ui.is('textarea') && ui.getAttr('maxlength')) {
							isNecessary = true;
							if (over = validateMaxlength(ui)) {
								ui.setCustomValidity(opts.msgMaxlen.replace(/#/, over));
								return true;
							}
						}

						// Number, Date, Time
						if (
							(!hasNumber && type == 'number') ||
							(!hasDateTime && (type == 'date' || type == 'time')) ||
							false) {
							isNecessary = true;

							// Set values to local
							var ui0 = ui, type0 = type, ui2 = ui;
							// Is this control within datetime?
							if (ui.parent().hasClass(opts.classDatetime)) {
								ui0 = ui.parent().prev();	// hidden datetime control
								type0 = ui0.getAttr('type').toLowerCase();	// datetime or datetime-local

								ui2 = ui.parent().children('input');	// a set of date & time
								ui2.setCustomValidity('');
								var i = ui2.index(ui), date = ui2.eq(0).val(), time = ui2.eq(1).val();
								if (date != '' || time != '') {
									// Complement the other control if empty
									if (date == '' || time == '') {
										var min = getLocalDatetime(ui0.getAttr('min'), true);	// use min value
										if (i == 0 && date != '' && time == '') { ui2.eq(1).val(min[1]); }
										if (i == 1 && time != '' && date == '') { ui2.eq(0).val(min[0]); }
										date = ui2.eq(0).val(), time = ui2.eq(1).val();
									}
									// Copy to hidden datetime control
									var val = $.trim(date + 'T' + time);
									if (type0 == 'datetime-local') {
										ui0.val(val);
									} else {
										var dt = getUTCDatetime(val);
										ui0.val(dt[0] + 'T' + dt[1]);
									}
								} else {
									ui0.val('');
								}
							}
							// Set validation parameters
							var pattern = '^-?\\d+\\.?\\d*$',
								min = 0,
								step = 1;
							switch (type0) {
							case 'date':
								pattern = '^\\d+-\\d+-\\d+$';
								min = '1970-01-01';
								step = 1;
								break;
							case 'time':
								pattern = '^\\d+:\\d+:?\\d*\\.?\\d*$';
								min = '00:00';
								step = 60;
								break;
							case 'datetime':
								pattern = '^\\d+-\\d+-\\d+T\\d+:\\d+:?\\d*\\.?\\d*Z$';
								min = '1970-01-01T00:00';
								step = 60;
								break;
							case 'datetime-local':
								pattern = '^\\d+-\\d+-\\d+T\\d+:\\d+:?\\d*\\.?\\d*$';
								min = '1970-01-01T00:00';
								step = 60;
								break;
							}
							// Perform validtions
							if (validateRe(ui0, pattern) || (validateStep(ui0, min, step))) {
								ui2.setCustomValidity(opts.msgInvalid);
								return true;
							}
							if (validateMin(ui0)) {
								ui2.setCustomValidity(opts.msgMin.replace(/#/, ui0.getAttr('min')));
								return true;
							}
							if (validateMax(ui0)) {
								ui2.setCustomValidity(opts.msgMax.replace(/#/, ui0.getAttr('max')));
								return true;
							}
						}
						return isNecessary;
					});

					// Test the change event, to run concurrently
					if (evChange()) {
						// Attach the change event if necessary
						ui.unbind('change', evChange).change(evChange);
					}

				});
			};
			validatableElements.initControl();
			firstTime = false;

			if (elmAutofocus) {
				elmAutofocus.focus().select();	// focus only does not work in IE
			}

			//
			// When submit
			//

			form.find('input:submit, input:image, input:button, button:submit')
				.click(function(ev) {

				if (ev.result == false) return false;	// Canceled in the previous handler

				var ui = $(this);
				if (!hasFormAttr) {
					if (attr = ui.getAttr('formaction')) {
						form.attr('action', attr);
					}
					if (attr = ui.getAttr('formeenctype')) {
						form.attr('enctype', attr);
					}
					if (attr = ui.getAttr('formmethod')) {
						form.attr('method', attr);
					}
					if (attr = ui.getAttr('formtarget')) {
						form.attr('target', attr);
					}
					if (null != ui.attr('formnovalidate')) {
						form.attr('novalidate', 'novalidate');
						validatableElements.each(function() {
							$(this).setCustomValidity('');
						});
					}
				}
				// Re-scan for dinamic controls
				form.find(opts.dynamicHtml).initControl();

				// Show balloons message
				if (!hasCustomValidity) {
					var result = true;
					validatableElements.each(function() {
						if (message = $(this).data('customValidity')) {
							err = $(this);
							if (opts.styleErr) err.css(opts.styleErr);
							if (result) {
								if (!err.prev().is(opts.exprResponse)) {
									var m = opts.exprResponse.match(/^\.([^, ]+),? *\.?([^, ]*)/),
									name = ($(window).width() - err.offset().left < 300 && !!m[2]) ?
										m[2] : m[1];
									err.before('<span class="' + name + '"></span>');
									$(opts.exprBehind).attr('disabled', 'disabled');
								}
								err.prev().html('<p>' + message.replace(/\n/, '<br/>') + '</p>');
								err.focus().select();	// focus only does not work in IE
								result = false;
							}
							return false;
						}
					});
					if (!result) return false;
				}
				// Submit if no error

				// Clear Placeholder
				if (!hasPlaceholder) {
					for (i = elmPlaceholder.length-1; i>=0; i--) {
						if (i != undefined) {
							var elm = elmPlaceholder[i];
							if (elm.val() == elm.getAttr('placeholder')) {
								elm.val('');
							}
						}
					}
				}

				if (hasBugButton)
				{
					// Set a value of button:submit you clicked to input:hidden.
					$('<input type="hidden" name="' + ui.getAttr('name') +
					  '" value="' + ui.val() + '">').appendTo(form);

					form.find('button, input:submit').attr('name', '');

					if (ui.is('button')) {
						form.find('input:submit').remove();
					}
				}
			});

		});

		// Validations
		// if error, result value is true (is not zero).
		// search returns zero when first match.

		function validateRe(item, pattern, flags) {
			re = new RegExp(pattern, flags);
			return ((item.val() != '') && item.val().search(re));
		}
		function validateMaxlength(item) {
			var len = item.val().length,
				max = attr2num(item, 'maxlength', 0);
			// if error, reulst value is number of overflow
			return (len && max && (len	> max)) ? len - max : 0;
		}
		function validateStep(item, min, step) {
			min = (item.getAttr('type').toLowerCase().indexOf('datetime')) ?
				attr2num(item, 'min', min) : attr2num(item, '', min);
			step = attr2num(item, 'step', step);
			var val = attr2num(item, 'val', '');
			return ((val != '') && ((val - min) % step));
		}
		function validateMin(item) {
			var val = attr2num(item, 'val', ''),
				min = attr2num(item, 'min', '');
			return ((val != '') && (min != '') && (val < min));
		}
		function validateMax(item) {
			var val = attr2num(item, 'val', ''),
				max = attr2num(item, 'max', '');
			return ((val != '') && (max != '') && (val > max));
		}

		// functions of datetime

		function attr2num(item, name, def) {
			var val = (name) ? ((name == 'val') ? item.val() : item.getAttr(name)) : def;
			if (val == undefined || val == '') val = '' + def;
			// Result seconds on unix time if the type is time
			// or resuts days on unix time if the type is date
			// because the return value is compared with the step base.
			if (val.match(/\d+-\d+-\d+[ T]\d+:\d/))
				return Date.parse(utc2js(val)) / (1000);	// seconds
			if (val.match(/\d+-\d+-\d+/))
				return Date.parse(utc2js(val)) / (1000 * 60 * 60 * 24);	// days
			if (val.match(/\d+:\d/)) return str2sec(val, true);	// seconds
			return Number(val);
		}
		function str2sec(str, gmt) {
			if (str.search(/\d+:\d+/)) str = '00:00';
			if (gmt) str += ' GMT';
			return Date.parse('1970/1/1 ' + str) / 1000;
		}
		function sec2str(time, sec, gmt) {
			var date = new Date(time * 1000);
			ret = (gmt) ? date.toUTCString() : toString();
			return ret.replace((sec) ? /.* (\d+:\d+:\d+).*$/ : /.* (\d+:\d+).*$/, '$1');
		}
		function getLocalDatetime(val, NullIsToday) {
			if (!val && !NullIsToday) return new Array('', '');
			// string to date for TZ
			var dt = (!val) ? new Date() : new Date(utc2js(val)),
				date = dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDate();

			date = date.replace(/\b(\d)\b/g, '0$1');
			var time = (val) ?
				dt.toString().replace(/.* (\d+:\d+:\d+).*$/, '$1') : '12:00';

			return new Array(date, time);
		}
		function getUTCDatetime(val) {
			// string to date for TZ
			var dt = new Date(utc2js(val)),
				date = dt.getUTCFullYear() + '-' + (dt.getUTCMonth() + 1) +
					'-' + dt.getUTCDate();

			date = date.replace(/\b(\d)\b/g, '0$1');
			var time = dt.toUTCString().replace(/.* (\d+:\d+:\d+).*$/, '$1Z');

			return new Array(date, time);
		}
		function utc2js(val) {
			return val.replace(/-/g, '/').replace(/T/, ' ').replace(/Z/, ' GMT')
				.replace(/([+-])(\d+):(\d+)/, ' GMT$1$2$3');
		}
		function getTZ()
		{
			var dt = new Date(),
				min = -1 * dt.getTimezoneOffset();

			if (min) {
				var	ret = min / 60 + ':' + min % 60;
				return ret.replace(/\b(\d)\b/g, '0$1').replace(/^(\d)/, '+$1');
			} else {
				return 'UTC';
			}
		}
	};


})(jQuery);
