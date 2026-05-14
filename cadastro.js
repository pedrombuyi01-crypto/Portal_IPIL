function registar() {
    const nome = document.getElementById("nome").value.trim()
    const email = document.getElementById("email").value.trim()
    const senha = document.getElementById("senha").value
    const confirmacao = document.getElementById("confirmacao").value

    // Remover mensagem antiga
    const msgAntiga = document.querySelector(".mensagem")
    if (msgAntiga) msgAntiga.remove()

    // Validações
    if (!nome || !email || !senha || !confirmacao) {
        mostrarMensagem("Por favor preenche todos os campos.", "erro")
        return
    }

    if (senha !== confirmacao) {
        mostrarMensagem("As senhas não coincidem. Tenta novamente.", "erro")
        return
    }

    if (senha.length < 6) {
        mostrarMensagem("A senha deve ter pelo menos 6 caracteres.", "erro")
        return
    }

    // Sucesso (quando o PHP estiver pronto, aqui faz-se o fetch para o servidor)
    mostrarMensagem("Conta criada com sucesso! Bem-vindo ao IPIL Makarenko.", "sucesso")
}

function mostrarMensagem(texto, tipo) {
    const msg = document.createElement("div")
    msg.classList.add("mensagem", tipo)
    msg.textContent = texto

    const btn = document.querySelector(".btn-submit")
    btn.parentNode.insertBefore(msg, btn)
}
