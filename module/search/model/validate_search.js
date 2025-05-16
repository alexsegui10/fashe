function cargar_marcas() {
    ajaxPromise('index.php?module=search&op=buscar_marca', 'POST', 'JSON')
        .then(function (data) {
            $('<option>Brand</option>').attr('selected', true).attr('disabled', true).appendTo('.search_brand')
            for (row in data) {
                $('<option value="' + data[row].id_brand + '">' + data[row].brand_name + '</option>').appendTo('.search_brand')
            }
        }).catch(function () {
            window.location.href = "index.php?modules=exception&op=503&error=fail_load_brands&type=503";
        });
}




function cargar_marcas(categoria) {
    $('.marcas_select').empty();
console.log("datos30");
    if (categoria == undefined) {
        ajaxpromise('POST','index.php?module=search&op=buscar_marca', null,  'JSON')
            .then(function (data) {
                $('<option>Marca</option>').attr('selected', true).attr('disabled', true).appendTo('.marcas_select');
                for (row in data) {
                    $('<option value="' + data[row].name+ '">' + data[row].name + '</option>').appendTo('.marcas_select');
                }
            }).catch(function (error) {
                console.error("Error AJAX buscar_marca:", error);
                //window.location.href = "index.php?modules=exception&op=503&error=fail_load_category&type=503";
            });
    } else {
        console.log("datos40");
        ajaxpromise('POST', 'index.php?module=search&op=buscar_marca_por_categoria',
            { categoria: categoria }, 'JSON')
            .then(function (data) {
                $('<option>Marca</option>').attr('selected', true).attr('disabled', true).appendTo('.marcas_select');
                console.log("datos50", data);
                for (row in data) {
                    $('<option value="' + data[row].name + '">' + data[row].name + '</option>').appendTo('.marcas_select');
                }
            }).catch(function (error) {
                console.error("Error AJAX buscar_marca_por_categoria:", error);
                //window.location.href = "index.php?modules=exception&op=503&error=fail_load_category_2&type=503";
            });
    }
}


function launch_search() {
    cargar_categorias();
    cargar_marcas();
    $('.categorias_select').change(function () {
        cargar_marcas(this.value);
    });
}

function cargar_categorias() {
    console.log("datos20");
    ajaxpromise('POST','index.php?module=search&op=buscar_categoria', null,  'JSON')
        .then(function (data) {
            console.log("datos20", data);
            $('<option>Categorias</option>')
                .attr('selected', true)
                .attr('disabled', true)
                .appendTo('.categorias_select');

            for (let row in data) {
                $('<option value="'+ data[row].name + '">' + data[row].name + '</option>').appendTo('.categorias_select');
            }
        })
        .catch(function (error) {
            console.error("Error en la llamada AJAX (ciudades10):", error);
        });
}

function autocomplete() {
    console.log("función autocomplete cargada");

    $(".ciudad_auto").on("keyup", function () {
        console.log("sí entran al pulsar tecla");

        let sdata = { complete: $(this).val() };

        if ($('.marcas_select').val() != 0) {
            sdata.marca = $('.marcas_select').val();

            if ($('.categorias_select').val() != 0) {
                sdata.categoria = $('.categorias_select').val();
            }
        }

        if ($('.marcas_select').val() == undefined && $('.categorias_select').val() != 0) {
            sdata.categoria = $('.categorias_select').val();
        }

        ajaxpromise('POST', 'index.php?module=search&op=autocomplete', sdata, 'JSON') 
            .then(function (data) {
                console.log("datos recibidos", data);

                $('.ciudad_auto_resultados').empty().fadeIn(200);
                if (data.length !== 0) {
                    for (let row of data) {
                                        
                        if (row && row.name && row.name.trim() !== "") {
                            $('<div></div>')
                                .addClass('searchElement')
                                .text(row.name)
                                .attr('data-id', row.id_ciudad)
                                .appendTo('.ciudad_auto_resultados');
                        }
                    }
                }

/*                 $(document).on('click', '.searchElement', function () {
                    $('#autocom').val(this.getAttribute('id'));
                    $('.ciudad_auto_resultados').fadeOut(300);
                });

                $(document).on('click scroll', function (event) {
                    if (event.target.id !== 'autocom') {
                        $('.ciudad_auto_resultados').fadeOut(300);
                    }
                }); */
                $(document).off('click', '.searchElement').on('click', '.searchElement', function () {
                    const idCiudad = $(this).data('id');
                    const nombreCiudad = $(this).text(); 
                
                    $('#autocom').val(nombreCiudad);
                    $('.ciudad_auto_resultados').fadeOut(200);
                
                });
                
            })
            .catch(function () {
                $('.ciudad_auto_resultados').fadeOut(200);
            });
    });
}


function button_search() {
    $('.buscar_search').on('click', function () {
        console.log("entra en la función de buscar");
        const Ciudad = $('#autocom').val();
        const Marca = $('.marcas_select').val();
        const Categoria = $('.categorias_select').val();
        console.log("datos", Ciudad, Marca, Categoria);
    
        $('#autocom').val(Ciudad);
    
        localStorage.removeItem('filter_marcas');
        localStorage.removeItem('filter_estados');
        localStorage.removeItem('filter_ciudades');
        localStorage.removeItem('filter_categorias');
        localStorage.removeItem('filter');
    
        const filter = [];
        if (Ciudad && Ciudad != 0) {
            filter.push(['id_ciudad', Ciudad, 'ciudades']);
            localStorage.setItem('filter_ciudades', Ciudad);
        }

    
        if (Marca && Marca != 0) {
            filter.push(['id_marca', [Marca], 'marcas']);
            localStorage.setItem('filter_marcas', Marca);
        }
    
        if (Categoria && Categoria != 0) {
            filter.push(['id_categoria', Categoria, 'categorias']);
            localStorage.setItem('filter_categorias', Categoria);
        }
        if (filter != 0) {
            localStorage.setItem('filter', JSON.stringify(filter));
        }
        window.location.href = 'index.php?module=shop';
    });
}

$(document).ready(function () {

    launch_search();
    autocomplete();
    button_search();
   // cargarcategorias();
   // autocomplete();
  //  button_search();
});