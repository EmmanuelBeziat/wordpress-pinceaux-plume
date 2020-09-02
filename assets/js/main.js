'use strict'

class LazyGrid {
	constructor (options) {
		this.options = options

		const grid = document.querySelector(this.options.grid)
		if (!grid) return

		const gridItems = grid.querySelectorAll(this.options.gridItems)
		if (!gridItems || !gridItems.length) return

		this.setAppearance(gridItems)
	}

	setAppearance (items) {
		let delay = 150
		items.forEach(item => {
			setTimeout(() => item.classList.add(this.options.loadedClass), delay)
			delay += 100
		})
	}
}

document.addEventListener('DOMContentLoaded', () => {
	new LazyGrid({
		grid: '.hp-grid',
		gridItems: '.hp-paint',
		loadedClass: 'is-loaded'
	})
})
