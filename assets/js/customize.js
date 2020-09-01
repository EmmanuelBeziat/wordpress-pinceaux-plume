(function ($) {
  wp.customize('header_background', value => value.bind(newValue => {
      $('.header').css('background-image', newValue)
    })
  )
})(jQuery)
