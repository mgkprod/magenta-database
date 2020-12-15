import animate from "animateplus"

animate({
    elements: ".base rect",
    easing: 'linear',
    duration: 200,
    opacity: [1, 0],
}).then(options => animate({
    elements: ".base rect",
    duration: 0,
    transform: ["translate(0%)", "translate(-100%)"],
    opacity: [0, 1],
})).then(options => animate({
    elements: ".base rect",
    easing: 'linear',
    duration: 2000,
    delay: index => index * 30,
    blur: {x: 10, y: 0},
    transform: ["translate(-100%)", "translate(100%)"],
    loop: true,
}))

window.end = function() {
    return new Promise(function (resolve, reject) {
        resolve(
            animate({
                elements: ".preloader",
                easing: 'linear',
                duration: 200,
                opacity: [1, 0],
            })
        )
    })
}

window.loadStyle = function(src) {
    return new Promise(function (resolve, reject) {
        let link = document.createElement('link')
        link.href = src
        link.rel = 'stylesheet'

        link.onload = () => resolve(link)
        link.onerror = () => reject(new Error(`Style load error for ${src}`))

        document.head.append(link)
    })
}

window.loadFont = function(src) {
    return new Promise(function (resolve, reject) {
        let link = document.createElement('link')
        link.href = src
        link.rel = 'preload'
        link.as='font'
        link.type='font/woff2'
        link.setAttribute('crossorigin', 'anonymous')

        link.onload = () => resolve(link)
        link.onerror = () => reject(new Error(`Font load error for ${src}`))

        document.head.append(link)
    })
}

window.loadScript = function(src) {
    return new Promise(function (resolve, reject) {
        let script = document.createElement('script')
        script.src = src

        script.onload = () => resolve(script)
        script.onerror = () => reject(new Error(`Script load error for ${src}`))

        document.head.append(script)
    })
}

window.loadImage = function(src) {
    return new Promise(function (resolve, reject) {
        let link = document.createElement('link')
        link.href = src
        link.rel = 'preload'
        link.as='image'

        link.onload = () => resolve(link)
        link.onerror = () => reject(new Error(`Image load error for ${src}`))

        document.head.append(link)
    })
}
