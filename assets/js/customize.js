(function ($, log) {
  wp.customize('header_background', value => value.bind(newValue => {
      log(newValue)
      log($('.header'))
      $('.header').css('background-image', newValue)
    })
  )
})(jQuery, console.log)
