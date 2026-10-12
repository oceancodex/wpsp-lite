wp.customize('wpsp_lite_customize_text_customize_demo', function(value) {
	value.bind(function(newValue) {
		document.querySelector('.wpsp_lite_customize_text_customize_demo').innerHTML = newValue;
	});
});