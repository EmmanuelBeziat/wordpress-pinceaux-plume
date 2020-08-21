'use strict'

const toggleAttribute = (element, attribute, trueVal, falseVal) => {
	if (trueVal === undefined) {
		trueVal = true
	}

	if (falseVal === undefined) {
		falseVal = false
	}

	if (element.getAttribute(attribute) !== trueVal) {
		element.setAttribute(attribute, trueVal)
	}
	else {
		element.setAttribute(attribute, falseVal)
	}
}

const menuToggle = (target, duration) => {
	let initialParentHeight
	let finalParentHeight
	let menu
	let menuItems
	let transitionListener
	const initialPositions = []
	const finalPositions = []

	if (!target) {
		return
	}

	menu = target.closest('.menu-wrapper')

	// Step 1: look at the initial positions of every menu item.
	menuItems = menu.querySelectorAll('.menu-item')

	menuItems.forEach((menuItem, index) => {
		initialPositions[index] = {
			x: menuItem.offsetLeft,
			y: menuItem.offsetTop
		}
	})
	initialParentHeight = target.parentElement.offsetHeight

	target.classList.add('toggling-target')

	// Step 2: toggle target menu item and look at the final positions of every menu item.
	target.classList.toggle('active')

	menuItems.forEach((menuItem, index) => {
		finalPositions[index] = {
			x: menuItem.offsetLeft,
			y: menuItem.offsetTop
		}
	})
	finalParentHeight = target.parentElement.offsetHeight

	// Step 3: close target menu item again.
	// The whole process happens without giving the browser a chance to render, so it's invisible.
	target.classList.toggle('active')

	/*
	 * Step 4: prepare animation.
	 * Position all the items with absolute offsets, at the same starting position.
	 * Shouldn't result in any visual changes if done right.
	 */
	menu.classList.add('is-toggling')
	target.classList.toggle('active')
	menuItems.forEach((menuItem, index) => {
		const initialPosition = initialPositions[index]

		if (initialPosition.y === 0 && menuItem.parentElement === target) {
			initialPosition.y = initialParentHeight
		}

		menuItem.style.transform = `translate(${initialPosition.x}px, ${initialPosition.y}px)`
	})

	/*
	 * The double rAF is unfortunately needed, since we're toggling CSS classes, and
	 * the only way to ensure layout completion here across browsers is to wait twice.
	 * This just delays the start of the animation by 2 frames and is thus not an issue.
	 */
	requestAnimationFrame(function () {
		requestAnimationFrame(function () {
			/*
			 * Step 5: start animation by moving everything to final position.
			 * All the layout work has already happened, while we were preparing for the animation.
			 * The animation now runs entirely in CSS, using cheap CSS properties (opacity and transform)
			 * that don't trigger the layout or paint stages.
			 */
			menu.classList.add('is-animating')
			menuItems.forEach((menuItem, index) => {
				const finalPosition = finalPositions[index]
				if (finalPosition.y === 0 && menuItem.parentElement === target) {
					finalPosition.y = finalParentHeight
				}

				if (duration !== undefined) {
					menuItem.style.transitionDuration = duration + 'ms'
				}
				menuItem.style.transform = `translate(${initialPosition.x}px, ${initialPosition.y}px)`
			})

			if (duration !== undefined) {
				target.style.transitionDuration = duration + 'ms'
			}
		})

		// Step 6: finish toggling.
		// Remove all transient classes when the animation ends.
		transitionListener = () => {
			menu.classList.remove('is-animating')
			menu.classList.remove('is-toggling')
			target.classList.remove('toggling-target')

			menuItems.forEach(menuItem => {
				menuItem.style.transform = ''
				menuItem.style.transitionDuration = ''
			})

			target.style.transitionDuration = ''
			target.removeEventListener('transitionend', transitionListener)
		}

		target.addEventListener('transitionend', transitionListener)
	})
}

class CoverModals {

	constructor () {
		if (document.querySelector('.cover-modal')) {
			// Handle cover modals when they're toggled.
			this.onToggle()

			// When toggled, untoggle if visitor clicks on the wrapping element of the modal.
			this.outsideUntoggle()

			// Close on escape key press.
			this.closeOnEscape()

			// Hide and show modals before and after their animations have played out.
			this.hideAndShowModals()
		}
	}

	// Handle cover modals when they're toggled.
	onToggle () {
		document.querySelectorAll('.cover-modal').forEach(element => {
			element.addEventListener('toggled', event => {
				const modal = event.target
				const body = document.body

				if (modal.classList.contains('active')) {
					body.classList.add('showing-modal')
				}
				else {
					body.classList.remove('showing-modal')
					body.classList.add('hiding-modal')

					// Remove the hiding class after a delay, when animations have been run.
					setTimeout(() => {
						body.classList.remove('hiding-modal')
					}, 500)
				}
			})
		})
	}

	// Close modal on outside click.
	outsideUntoggle () {
		document.addEventListener('click', function (event) {
			const target = event.target
			const modal = document.querySelector('.cover-modal.active')

			// if target onclick is <a> with # within the href attribute
			if (event.target.tagName.toLowerCase() === 'a' && event.target.hash.includes('#') && modal !== null) {
				// untoggle the modal
				this.untoggleModal(modal)
				// wait 550 and scroll to the anchor
				setTimeout(() => {
					const anchor = document.getElementById(event.target.hash.slice(1))
					anchor.scrollIntoView()
				}, 550)
			}

			if (target === modal) {
				this.untoggleModal(target)
			}
		}.bind(this))
	}

	// Close modal on escape key press.
	closeOnEscape () {
		document.addEventListener('keydown', function(event) {
			if (event.keyCode === 27) {
				event.preventDefault()
				document.querySelectorAll('.cover-modal.active').forEach(function(element) {
					this.untoggleModal(element)
				}.bind(this))
			}
		}.bind(this))
	}

	// Hide and show modals before and after their animations have played out.
	hideAndShowModals () {
		const modals = document.querySelectorAll('.cover-modal')
		const htmlStyle = document.documentElement.style
		const adminBar = document.querySelector('#wpadminbar')

		function getAdminBarHeight (negativeValue) {
			let height
			const currentScroll = window.pageYOffset

			if (adminBar) {
				height = currentScroll + adminBar.getBoundingClientRect().height

				return negativeValue ? -height : height
			}

			return currentScroll === 0 ? 0 : -currentScroll
		}

		function htmlStyles() {
			var overflow = window.innerHeight > document.documentElement.getBoundingClientRect().height

			return {
				'overflow-y': overflow ? 'hidden' : 'scroll',
				position: 'fixed',
				width: '100%',
				top: getAdminBarHeight(true) + 'px',
				left: 0
			}
		}

		// Show the modal.
		modals.forEach(function(modal) {
			modal.addEventListener('toggle-target-before-inactive', function(event) {
				const styles = htmlStyles()
				const offsetY = window.pageYOffset
				const paddingTop = (Math.abs(getAdminBarHeight()) - offsetY) + 'px'
				const mQuery = window.matchMedia('(max-width: 600px)')

				if (event.target !== modal) {
					return
				}

				Object.keys(styles).forEach(styleKey => {
					htmlStyle.setProperty(styleKey, styles[styleKey])
				})

				window.twentytwenty.scrolled = parseInt(styles.top, 10)

				if (adminBar) {
					document.body.style.setProperty('padding-top', paddingTop)

					if (mQuery.matches) {
						if (offsetY >= getAdminBarHeight()) {
							modal.style.setProperty('top', 0)
						}
						else {
							modal.style.setProperty('top', (getAdminBarHeight() - offsetY) + 'px')
						}
					}
				}

				modal.classList.add('show-modal')
			})

			// Hide the modal after a delay, so animations have time to play out.
			modal.addEventListener('toggle-target-after-inactive', event => {
				if (event.target !== modal) {
					return
				}

				setTimeout(() => {
					var clickedEl = twentytwenty.toggles.clickedEl

					modal.classList.remove('show-modal')

					Object.keys(htmlStyles()).forEach(styleKey => {
						htmlStyle.removeProperty(styleKey)
					})

					if (adminBar) {
						document.body.style.removeProperty('padding-top')
						modal.style.removeProperty('top')
					}

					if (clickedEl !== false) {
						clickedEl.focus()
						clickedEl = false
					}

					window.scrollTo(0, Math.abs(window.twentytwenty.scrolled + getAdminBarHeight()))

					window.twentytwenty.scrolled = 0
				}, 500)
			})
		})
	}

	// Untoggle a modal.
	untoggleModal (modal) {
		let modalTargetClass
		let	modalToggle = false

		// If the modal has specified the string (ID or class) used by toggles to target it, untoggle the toggles with that target string.
		// The modal-target-string must match the string toggles use to target the modal.
		if (modal.dataset.modalTargetString) {
			modalTargetClass = modal.dataset.modalTargetString

			modalToggle = document.querySelector('*[data-toggle-target="' + modalTargetClass + '"]')
		}

		// If a modal toggle exists, trigger it so all of the toggle options are included.
		if (modalToggle) {
			modalToggle.click()
		}
		// If one doesn't exist, just hide the modal.
		else {
			modal.classList.remove('active')
		}
	}
}

class Toggles {
  clickedEl = false

  constructor () {
    // Do the toggle.
		this.toggle()

		// Check for toggle/untoggle on resize.
		this.resizeCheck()

		// Check for untoggle on escape key press.
		this.untoggleOnEscapeKeyPress()
  }

	performToggle (element) {
    let target
    let timeOutTime
    let classToToggle

    // Get our targets.
		const toggle = element
		const targetString = toggle.dataset.toggleTarget
		const activeClass = 'active'

		// Elements to focus after modals are closed.
		if (!document.querySelectorAll('.show-modal').length) {
			this.clickedEl = document.activeElement
		}

		if (targetString === 'next') {
			target = toggle.nextSibling
    }
    else {
			target = document.querySelector(targetString)
		}

		// Trigger events on the toggle targets before they are toggled.
		if (target.classList.contains(activeClass)) {
			target.dispatchEvent(new Event('toggle-target-before-active'))
    }
    else {
			target.dispatchEvent(new Event('toggle-target-before-inactive'))
		}

		// Get the class to toggle, if specified.
		classToToggle = toggle.dataset.classToToggle || activeClass

		// For cover modals, set a short timeout duration so the class animations have time to play out.
		timeOutTime = 0

		if (target.classList.contains('cover-modal')) {
			timeOutTime = 10
		}

		setTimeout(() => {
			let focusElement
			const newTarget = target.classList.contains('sub-menu') ? toggle.closest('.menu-item').querySelector('.sub-menu') : target
			const duration = toggle.dataset.toggleDuration

			// Toggle the target of the clicked toggle.
			if (toggle.dataset.toggleType === 'slidetoggle' && !instantly && duration !== '0') {
				menuToggle(newTarget, duration)
      }
      else {
				newTarget.classList.toggle(classToToggle)
			}

			// If the toggle target is 'next', only give the clicked toggle the active class.
			if (targetString === 'next') {
				toggle.classList.toggle(activeClass)
      }
      else if (target.classList.contains('sub-menu')) {
				toggle.classList.toggle(activeClass)
      }
      else {
				// If not, toggle all toggles with this toggle target.
				document.querySelector('*[data-toggle-target="' + targetString + '"]').classList.toggle(activeClass)
			}

			// Toggle aria-expanded on the toggle.
			toggleAttribute(toggle, 'aria-expanded', 'true', 'false')

			if (this.clickedEl && -1 !== toggle.getAttribute('class').indexOf('close-')) {
				toggleAttribute(this.clickedEl, 'aria-expanded', 'true', 'false')
			}

			// Toggle body class.
			if (toggle.dataset.toggleBodyClass) {
				document.body.classList.toggle(toggle.dataset.toggleBodyClass)
			}

			// Check whether to set focus.
			if (toggle.dataset.setFocus) {
				focusElement = document.querySelector(toggle.dataset.setFocus)

				if (focusElement) {
					target.classList.contains(activeClass) ? focusElement.focus() : focusElement.blur()
				}
			}

			// Trigger the toggled event on the toggle target.
			target.dispatchEvent(new Event('toggled'))

			// Trigger events on the toggle targets after they are toggled.
			if (target.classList.contains(activeClass)) {
				target.dispatchEvent(new Event('toggle-target-after-active'))
      }
      else {
				target.dispatchEvent(new Event('toggle-target-after-inactive'))
			}
		}, timeOutTime)
	}

	// Do the toggle.
	toggle () {
		document.querySelectorAll('*[data-toggle-target]').forEach(element => {
			element.addEventListener('click', event => {
				event.preventDefault()
				this.performToggle(element)
			})
		})
	}

	// Check for toggle/untoggle on screen resize.
	resizeCheck () {
		if (document.querySelectorAll('*[data-untoggle-above], *[data-untoggle-below], *[data-toggle-above], *[data-toggle-below]').length) {
			window.addEventListener('resize', () => {
				const winWidth = window.innerWidth
				const toggles = document.querySelectorAll('.toggle')

				toggles.forEach(toggle => {
					const unToggleAbove = toggle.dataset.untoggleAbove
					const unToggleBelow = toggle.dataset.untoggleBelow
					const toggleAbove = toggle.dataset.toggleAbove
					const toggleBelow = toggle.dataset.toggleBelow

					// If no width comparison is set, continue.
					if (!unToggleAbove && !unToggleBelow && !toggleAbove && !toggleBelow) {
						return
					}

					// If the toggle width comparison is true, toggle the toggle.
					if (
						(((unToggleAbove && winWidth > unToggleAbove) ||
							(unToggleBelow && winWidth < unToggleBelow)) &&
							toggle.classList.contains('active')) ||
						(((toggleAbove && winWidth > toggleAbove) ||
							(toggleBelow && winWidth < toggleBelow)) &&
							!toggle.classList.contains('active'))
					) {
						toggle.click()
					}
				})
			})
		}
	}

	// Close toggle on escape key press.
	untoggleOnEscapeKeyPress () {
		document.addEventListener('keyup', event => {
			if (event.key === 'Escape') {
				document.querySelectorAll('*[data-untoggle-on-escape].active').forEach(element => {
					if (element.classList.contains('active')) {
						element.click()
					}
				})
			}
		})
	}
}

document.addEventListener('DOMContentLoaded', () => {
	new Toggles()
	new CoverModals()
})
