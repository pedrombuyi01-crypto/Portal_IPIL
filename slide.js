let slide_atual = 0
let intervalo

// Criar dots dinamicamente
function criarDots() {
    const container = document.getElementById("dots")
    container.innerHTML = ""
    slides.forEach((_, i) => {
        const dot = document.createElement("span")
        dot.classList.add("dot")
        if (i === 0) dot.classList.add("active")
        dot.addEventListener("click", () => irParaSlide(i))
        container.appendChild(dot)
    })
}

function actualizarDots() {
    document.querySelectorAll(".dot").forEach((dot, i) => {
        dot.classList.toggle("active", i === slide_atual)
    })
}

function mudar_slide() {
    if (slides.length === 0) return

    const img = document.querySelector(".slide-img")
    img.style.transform = "translateX(-100%)"

    setTimeout(() => {
        const slide = slides[slide_atual]

        img.src = slide.imagem
        document.getElementById("slide-titulo").textContent = slide.titulo
        document.getElementById("slide-resumo").textContent = slide.resumo
        document.getElementById("slide-categoria").textContent = slide.categoria

        img.style.transform = "translateX(0)"
        actualizarDots()
    }, 500)
}

function slideProximo() {
    if (slides.length === 0) return
    slide_atual = (slide_atual + 1) % slides.length
    mudar_slide()
    resetIntervalo()
}

function slideAnterior() {
    if (slides.length === 0) return
    slide_atual = (slide_atual - 1 + slides.length) % slides.length
    mudar_slide()
    resetIntervalo()
}

function irParaSlide(index) {
    slide_atual = index
    mudar_slide()
    resetIntervalo()
}

function resetIntervalo() {
    clearInterval(intervalo)
    intervalo = setInterval(slideProximo, 4000)
}

// Iniciar
criarDots()
intervalo = setInterval(slideProximo, 4000)