'use strict'

class LazyGrid {
	constructor ({ grid = '.hp-grid', gridItems = '.hp-paint', loadedClass = 'is-loaded' }) {
		this.loadedClass = loadedClass

		this.grid = document.querySelector(grid)
		if (!grid) return

		this.gridItems = grid.querySelectorAll(gridItems)
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
	new LazyGrid()
})
