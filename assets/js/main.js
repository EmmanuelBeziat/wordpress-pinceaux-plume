'use strict'

class LazyGrid {
	constructor (grid = '.hp-grid', gridItems = '.hp-paint', loadedClass = 'is-loaded') {
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
			setTimeout(() => item.classList.add(this.loadedClass), delay)
			delay += 100
		})
	}
}

class Share {
	constructor () {
		this.postShare = document.querySelector('.post-share')
		if (!this.postShare) return

		navigator.share ? this.setShareAuto() : this.setShareManual()
	}

	setShareAuto () {
		const shareBlock = this.postShare.querySelector('.share-auto')
		if (!shareBlock) return

		const shareButton = shareBlock.querySelector('button')
		if (!shareButton) return

		shareBlock.removeAttribute('hidden')
		shareButton.addEventListener('click', event => {
			event.preventDefault()
			this.shareAuto()
		})
	}

	setShareManual () {
		const shareBlock = this.postShare.querySelector('.share-manual')
		if (!shareBlock) return

		const shareButtons = shareBlock.querySelectorAll('button')
		if (!shareButtons.length) return

		shareBlock.removeAttribute('hidden')
		shareButtons.forEach('click', event => {
			event.preventDefault()
			this.shareManual(event.target.dataset.name)
		})
	}

	shareAuto () {
		navigator.share({
			title: '',
			text: document.title,
			url: window.location.href,
		})
	}

	shareManual (social) {
		let shareUrl = ''
		const pageUrl = encodeURIComponent(window.location.href)
		const pageTitle = encodeURIComponent(document.title)

		switch (social) {
			case 'twitter':
				shareUrl = `https://twitter.com/intent/tweet?text=${pageTitle} — ${pageUrl}&via=EmmanuelBeziat`
				this.sharePopup(shareUrl, 'Partager sur Twitter')
				break

			case 'facebook':
				shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${pageUrl}`
				this.sharePopup(shareUrl, 'Partager sur Facebook')
				break

			case 'link':
				const dummyShare = document.createElement('input')
				document.body.appendChild(dummyShare)
				dummyShare.value = window.location.href
				dummyShare.select()
				document.execCommand('copy')
				document.body.removeChild(dummyShare)
				alert('URL copiée dans le presse papier')
				break
		}
	}

	sharePopup (url, title, width, height) {
		let popupWidth = width || 640
		let popupHeight = height || 320
		let popupPosX = window.screenX + window.innerWidth / 2 - popupWidth / 2
		let popupPosY = window.screenY + window.innerHeight / 2 - popupHeight / 2
		let popup = window.open(url, title, 'scrollbars=yes, menubar=0, location=0, status=0, width=' + popupWidth + ', height=' + popupHeight + ', top=' + popupPosY + ', left=' + popupPosX)

		popup.focus()
		return true
	}
}

document.addEventListener('DOMContentLoaded', () => {
	new LazyGrid()
	new Share()
})
