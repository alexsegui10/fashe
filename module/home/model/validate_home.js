function cargarprecio() {
    alert("hola");
/*     $(document).on('click', '.list-curso', function () { 
        var id = this.getAttribute('id');
        ajaxpromise("Post","module/cursos/controller/controller_cursos.php?op=read_modal","modal="+ id,"json" )
        .then(function (data, status) {
            console.log(data);
            //
            $('<div></div>').attr('id', 'details_curso').appendTo("#curso_modal");
            $('<div></div>').attr("id", 'details').appendTo('#details_curso');
            $('<div></div>').attr("id", 'container').appendTo('details');

            $("#curso_modal").html(function(){
                let content =""
                for( row in data){
                    if (row !== "id_curso" ) {
                        content += '<div></div>' + row  + "<span>:   </span>" + data[row] + "<br></br>";
                    } 
                }
                return content;
            });
         $("#nombre_modal").html(data.nombre);
            $("#categoria").html(data.categoria);
            $("#descripcion").html(data.descripcion);
            $("#nivel").html(data.nivel);
            $("#fecha_inicio_modal").html(data.fecha_inicio);
            $("#fecha_final_modal").html(data.fecha_final);
            $("#fecha_de_compra").html(data.fecha_de_compra);
            $("#precio").html(data.precio);
            $("#duracion").html(data.duracion);
            $("#areas").html(data.areas); 
            mostrar_modal(data.id_curso);
        });
    }); */
};
