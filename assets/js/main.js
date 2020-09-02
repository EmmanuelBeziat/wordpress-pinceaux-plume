'use strict'

class LazyGrid {
	constructor (options) {
		const grid = document.querySelector(options.grid)
		if (!grid) return

		const gridItems = grid.querySelectorAll(options.gridItems)
		if (!gridItems || !gridItems.length) return

		this.setAppearance(gridItems)
	}

	setAppearance (items) {
		let delay = 150
		items.forEach(item => {
			setTimeout(() => item.classList.add(options.loadedClass), delay)
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
