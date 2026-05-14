function abrirDrawer(titulo, imagem, texto) {
    document.querySelector(".drawer h2").textContent = titulo
    document.querySelector(".drawer img").src = imagem
    document.querySelector(".drawer p").textContent = texto

    document.querySelector(".drawer").classList.add("aberto")
    document.querySelector(".overlay").classList.add("aberto")
}

function fecharDrawer() {
    document.querySelector(".drawer").classList.remove("aberto")
    document.querySelector(".overlay").classList.remove("aberto")
}

document.querySelector(".overlay").addEventListener("click", fecharDrawer)
document.querySelector(".btn-fechar").addEventListener("click", fecharDrawer)