(function ($, el, log) {
  log('test')
  wp.customize('header_background', value => value.bind(newValue => el('.header').style.backgroundImage = newValue))
})(jQuery, document.querySelector, console.log)
