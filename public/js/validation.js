function cpf(cpf) {

    cpf = cpf.replace(/\D/g, '');
    if (cpf.toString().length != 11 || /^(\d)\1{10}$/.test(cpf)) return false;
    var result = true;
    [9, 10].forEach(function (j) {
        var soma = 0, r;
        cpf.split(/(?=)/).splice(0, j).forEach(function (e, i) {
            soma += parseInt(e) * ((j + 2) - (i + 1));
        });
        r = soma % 11;
        r = (r < 2) ? 0 : 11 - r;
        if (r != cpf.substring(j, j + 1)) result = false;
    });
    return result;
}
// Chamadas de validaçao, com teclas e alteração de input
document.getElementById('cpf').addEventListener('keyup', testeRapido, false);
//para evitar erros verifica se cad-cpf existe
if (document.getElementById('cad-cpf') != undefined) {
    document.getElementById('cad-cpf').addEventListener('keyup', testeRapido, false);
}
function valida() {
    var inputCpf = document.getElementById('cpf').value;
    if (document.getElementById('rg') != undefined) {
        var rg = document.getElementById('rg').value
    } else {
        var rg = false
    }
    // var btn = document.querySelector('.btn-register');
    // btn.disabled = true;
    teste = cpf(inputCpf);
    if (rg.length > 0 || teste) {
        document.getElementById('invalid').style = "display: none";
        document.getElementById('cpf').style = "border-bottom: 2px solid #20B2AA!important;";
        // btn.disabled = false;
        return true
    }
    else {
        document.getElementById('cpf').style = "border-bottom: 2px solid red!important;";
        document.getElementById('cpf').focus();
        document.getElementById('invalid').style = "display: block";
        // btn.disabled = true;
        return false
    }
}
function validaCadastro() {
    var inputCpf = document.getElementById('cad-cpf').value;
    var rg = document.getElementById('cad-rg').value;
    // var btn = document.querySelector('#registrar');
    // btn.disabled = true;
    teste = cpf(inputCpf);
    if (rg.length > 0 || teste) {
        document.getElementById('cad-invalid').style = "display: none";
        document.getElementById('cad-cpf').style = "border-bottom: 2px solid #20B2AA!important;";
        // btn.disabled = false;
        return true;
    }
    else {
        document.getElementById('cad-cpf').style = "border-bottom: 2px solid red!important;";
        document.getElementById('cad-cpf').focus();
        document.getElementById('cad-invalid').style = "display: block";
        // btn.disabled = true;
        return false;
    }
}

function validaCadastroCars() {
    
    var dsc_veiculo = document.getElementById('dsc_veiculo').value;
    var cor_veiculo = document.getElementById('cor_veiculo').value;
    var placa_veiculo = document.getElementById('placa_veiculo').value;
    var id_vaga_garagem = document.getElementById('id_vaga_garagem').value;

    if (dsc_veiculo.length > 3) {
        document.getElementById('cad-invalid').style = "display: none";
        document.getElementById('dsc_veiculo').innerHTML =  "";
        document.getElementById('dsc_veiculo').style = "border-bottom: 2px solid #20B2AA!important;";
        return true;
    }
    else {
        document.getElementById('dsc_veiculo').style = "border-bottom: 2px solid red!important;";
        document.getElementById('dsc_veiculo').focus();
        document.getElementById('cad-invalid').innerHTML =  "* Descrição em branco ou insuficiente (mínimo de 4 caracteres)";
        document.getElementById('cad-invalid').style = "display: block";
        return false;
    }

    if (cor_veiculo.length > 3) {
        document.getElementById('cad-invalid').style = "display: none";
        document.getElementById('cor_veiculo').innerHTML =  "";
        document.getElementById('cor_veiculo').style = "border-bottom: 2px solid #20B2AA!important;";
        return true;
    }
    else {
        document.getElementById('cor_veiculo').style = "border-bottom: 2px solid red!important;";
        document.getElementById('cor_veiculo').focus();
        document.getElementById('cad-invalid').innerHTML =  "* Cor não selecionada";
        document.getElementById('cad-invalid').style = "display: block";
        return false;
    }

    if (placa_veiculo.length > 3) {
        document.getElementById('cad-invalid').style = "display: none";
        document.getElementById('placa_veiculo').innerHTML =  "";
        document.getElementById('placa_veiculo').style = "border-bottom: 2px solid #20B2AA!important;";
        return true;
    }
    else {
        document.getElementById('placa_veiculo').style = "border-bottom: 2px solid red!important;";
        document.getElementById('placa_veiculo').focus();
        document.getElementById('cad-invalid').innerHTML =  "* Placa em branco";
        document.getElementById('cad-invalid').style = "display: block";
        return false;
    }

    if(id_vaga_garagem === ""){ 
        document.getElementById('id_vaga_garagem').style = "border-bottom: 2px solid red!important;";
        document.getElementById('id_vaga_garagem').focus();
        document.getElementById('cad-invalid').innerHTML =  "* Selecione a vaga de garagem";
        document.getElementById('cad-invalid').style = "display: block";
        return false;
    }
    else {
        document.getElementById('cad-invalid').style = "display: none";
        document.getElementById('id_vaga_garagem').innerHTML =  "";
        document.getElementById('id_vaga_garagem').style = "border-bottom: 2px solid #20B2AA!important;";
        return true;  
    }
}

function testeRapido() {
    var delay = 1000;

    setTimeout(valida(), delay);
    setTimeout(validaCadastro(), delay);
}

if (document.getElementById('select-documento-cadastro') != undefined || document.getElementById('select-documento-registro') != undefined) {
    document.getElementById('select-documento-cadastro').addEventListener('change',
        function apagaInput() {
            // var btn = document.querySelector('#registrar');
            document.getElementById('cad-cpf').value = "";
            document.getElementById('cad-rg').value = "";
            // btn.disabled = false;
        }
    );
    document.getElementById('select-documento-registro').addEventListener('change',
        function apagaInput() {
            // var btn = document.querySelector('.btn-register');
            // btn.disabled = false;
            document.getElementById('cpf').value = "";
            document.getElementById('rg').value = "";
        }
    );
    document.getElementById('select-uf-registro').addEventListener('change',
        function apagaInput() {
            document.getElementById('rg').value = "";
        }
    );
    document.getElementById('select-uf-cadastro').addEventListener('change',
        function apagaInput() {
            document.getElementById('cad-rg').value = "";
        }
    );
}



