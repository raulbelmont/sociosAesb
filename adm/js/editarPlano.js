
var qtdVantagemEditar = parseInt($('#qtd-vantagens-editar').val());
/*Adicionando vantagem na modal de editar*/
$("#add-vantagem-editar").on('click',function () {

    if (qtdVantagemEditar == 0){
        $('#remove-vantagem-editar').removeClass('d-none');
    }

    qtdVantagemEditar = qtdVantagemEditar +1;

    var html = "<div class='form-group col-12 vantagem-editar"+qtdVantagemEditar+"'> <label for='vantagem1'>Vantagem " + qtdVantagemEditar+ "</label> <textarea class='form-control' id='vantagem" + qtdVantagemEditar +"' name='vantagem"+qtdVantagemEditar+"' maxlength='150' placeholder='(Máximo de 150 caractéres)'></textarea>  </div>";
    $('#vantagens-editar').append(html);
    $('#qtd-vantagens-editar').val(qtdVantagemEditar);
});

/*removendo vantagem na modal de editar*/
$("#remove-vantagem-editar").on('click',function () {

    if (qtdVantagemEditar == 1){
        $(this).addClass('d-none');
    }

    if (qtdVantagemEditar>0){
        var html = ".vantagem-editar"+qtdVantagemEditar;
        qtdVantagemEditar = qtdVantagemEditar - 1;
        $(html).remove();
        $('#qtd-vantagens-editar').val(qtdVantagemEditar);
    }



});

$(document).ready(function () {
    $('#valor_adesao_editar').mask("#.##0,00", {reverse: true});
});