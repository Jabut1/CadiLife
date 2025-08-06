
const cadastro = document.getElementById("cadastro");
const nome = document.getElementById("nome");
const sobrenome = document.getElementById("sobrenome");
const email = document.getElementById("email");
const altura = document.getElementById("altura");
const senha = document.getElementById("senha");
const confirmarSenha = document.getElementById("confirmar-senha");


cadastro.addEventListener("submit", (event) => {
    if(!checkCadastro()) {
        event.preventDefault();
    }
})

function checkInputNome(){
    const nomeValue = nome.value;

    if(nomeValue === ""){
        errorInput(nome, "O nome é obrigatório.")
    }else{
        const cadastroItem = nome.parentElement
        cadastroItem.className = "cadastro-content"
    }

}
function checkInputSobrenome(){
    const sobrenomeValue = nome.value;

    if(sobrenomeValue === ""){
        errorInput(sobrenome, "O sobrenome é obrigatório.")
    }else{
        const cadastroItem = sobrenome.parentElement
        cadastroItem.className = "cadastro-content"
    }

}

function checkInputEmail(){
    const emailValue = email.value;

    if(emailValue === ""){
        errorInput(email, "O email é obrigatório.")
    }else{
        const cadastroItem = email.parentElement
        cadastroItem.className = "cadastro-content"
    }

}
function checkInputAltura(){
    const alturaValue = altura.value;

    if(alturaValue === ""){
        errorInput(altura, "A altura é obrigatória.")
    }else{
        const cadastroItem = altura.parentElement
        cadastroItem.className = "cadastro-content"
    }

}

function checkInputSenha(){
    const senhaValue = senha.value;

    if(senhaValue === ""){
        errorInput(senha, "A senha é obrigatória")
    }else if(senhaValue.length < 8){
        errorInput(senha, "A senha precisa ter no mínimo 8 caracteres")
    }else{
        const cadastroItem = senha.parentElement
        cadastroItem.className = "cadastro-content"
    }

}

function checkInputConfirmarSenha(){
    const senhaValue = senha.value;
    const confirmarSenhaValue = confirmarSenha.value;

    if(confirmarSenhaValue === ""){
        errorInput(confirmarSenha, "A confirmção de senha é obrigatória.")
    }else if(confirmarSenhaValue !== senhaValue){
        errorInput(confirmarSenha, "As senhas não são iguais")
    }else{
        const cadastroItem = confirmarSenha.parentElement
        cadastroItem.className = "cadastro-content"
    }

}

function checkCadastro(){
    checkInputNome();
    checkInputSobrenome();
    checkInputEmail();
    checkInputAltura();
    checkInputSenha();
    checkInputConfirmarSenha();

    const cadastroItems = cadastro.querySelectorAll(".cadastro-content")

    const isValid = [...cadastroItems].every( (item) => {
        return item.className === "cadastro-content"
    });

    if(isValid){
        alert("Você foi cadastrado com sucesso!")
        return true;
    } else {
        return false
    }
 
}

function errorInput(input, message){
    const cadastroItem = input.parentElement;
    const textMessage = cadastroItem.querySelector("a")

    textMessage.innerText = message;

    cadastroItem.className = "cadastro-content error"
}