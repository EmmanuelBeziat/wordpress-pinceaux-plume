'use strict'

class LazyGrid {
	constructor ({ grid = '.hp-grid', gridItems = '.hp-paint', loadedClass = 'is-loaded' }) {
		this.loadedClass = loadedClass

		this.grid = document.querySelector(grid)
		if (!this.grid) return

		this.gridItems = this.grid.querySelectorAll(gridItems)
		if (!this.gridItems || !this.gridItems.length) return

		this.setAppearance(this.gridItems)
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
