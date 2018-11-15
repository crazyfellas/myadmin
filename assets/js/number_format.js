//NUMBER
		$('input.number').keyup(function (event) {
				// skip for arrow keys
				if (event.which >= 37 && event.which <= 40) {
						event.preventDefault();
				}

				var currentVal = $(this).val();
				var testDecimal = testDecimals(currentVal);
				if (testDecimal.length > 1) {
						console.log("You cannot enter more than one decimal point");
						currentVal = currentVal.slice(0, -1);
				}
				$(this).val(replaceCommas(currentVal));


		});

		function testDecimals(currentVal) {
				var count;
				currentVal.match(/\./g) === null ? count = 0 : count = currentVal.match(/\./g);
				return count;
		}

		function replaceCommas(yourNumber) {
				var components = yourNumber.toString().split(".");
				if (components.length === 1)
						components[0] = yourNumber;
				components[0] = components[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
				if (components.length === 2)
						components[1] = components[1].replace(/\D/g, "");
				return components.join(".");
		}

		function number_format(number, decimals, dec_point, thousands_sep) {
				number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
				var n = !isFinite(+number) ? 0 : +number,
				prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
				sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
				dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
				s = '',
				toFixedFix = function(n, prec) {
						var k = Math.pow(10, prec);
						return '' + (Math.round(n * k) / k).toFixed(prec);
				};
				// Fix for IE parseFloat(0.55).toFixed(0) = 0;
				s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
				if (s[0].length > 3)
				{
						s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
				}

				if ((s[1] || '').length < prec)
				{
						s[1] = s[1] || '';
						s[1] += new Array(prec - s[1].length + 1).join('0');
				}
				return s.join(dec);
		}
