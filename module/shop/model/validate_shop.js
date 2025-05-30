function ajaxForSearch(url, filter, offset, limit, total_pages, order) {
    ajaxpromise('POST', url, { 'filter': filter, 'limit':limit, 'offset':offset, 'order':order}, 'json', )
      .then(function (data) {
        let content = "";
        if (data.length == undefined || data.length == 0) {
          content += `<h2>No se han encontrado resultados</h2>`;
        } else {
          for (let row in data) {
            content += `
              <!-- Producto 1 -->
              <div class="col-sm-12 col-md-6 col-lg-6 p-b-50">
                <div id="${data[row].id_accesorio}" class="block2">
                  <div
                    class="block2-img wrap-pic-w of-hidden pos-relative details_accesorio"
                    id="${data[row].id_accesorio}"
                  >
                    <div class="slick2" id="list-carrusel-${data[row].id_accesorio}">
            `;
            for (let img in data[row].imagenes) {
              content += `
                      <img class="imagen-fija"
                           src="${data[row].imagenes[img]}"
                           alt="${data[row].imagenes[img]}">
              `;
            }
            content += `
                    </div>
                    <div class="block2-overlay trans-0-4">
                      <!-- Botón de like con stopPropagation -->
                      <a href="#"
                        class="block2-btn-addwishlist hov-pointer trans-0-4"
                        data-id="${data[row].id_accesorio}"
                        onclick="event.preventDefault(); event.stopPropagation(); click_like(this);"
                      >
                        <i class="fa-regular fa-heart"></i>
                      </a>
                      <!-- Botón Add to Cart -->
                      <div class="block2-btn-addcart w-size1 trans-0-4">
                        <button
                          class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4"
                        >
                          Add to Cart
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="block2-txt p-t-20">
                    <a href="#"
                       class="block2-name dis-block s-text3 p-b-5">
                      ${data[row].name}
                    </a>
                    <span class="block2-price m-text6 p-r-5">
                      <span class="money">${data[row].precio} €</span>
                    </span>
                  </div>
                </div>
              </div>
            `;
          }
          
      }
      listmap(data);
        $("#custom-products").html(content);
        load_user_likes();
        for (let row in data) {
          $(`#list-carrusel-${data[row].id_accesorio}`).slick({
            infinite: true,
            dots: true,
            slidesToShow: 1, 
            slidesToScroll: 1,
            prevArrow: '<button class="arrow-slick2 prev-slick2 slick-prev" onclick="event.stopPropagation();"><i class="fa fa-angle-left" aria-hidden="true"></i></button>',
            nextArrow: '<button class="arrow-slick2 next-slick2 slick-next" onclick="event.stopPropagation();"><i class="fa fa-angle-right" aria-hidden="true"></i></button>',
            adaptiveHeight: true
        });
        }
          let paginactual = parseInt(localStorage.getItem('currentPage')) || 1;
          let start = Math.max(1, paginactual - 1);
          let end = Math.min(total_pages, paginactual + 1);
          let pagination = '<div class="pagination text-center m-t-30">';
              if (paginactual > 1) {
                pagination += `<button class="page-btn" data-page="${paginactual - 1}">«</button>`;
              }

              for (let i = start; i <= end; i++) {
                if (i === paginactual) {
                  pagination += `<button class="page-btn active-page" data-page="${i}">${i}</button>`;
                } else {
                  pagination += `<button class="page-btn" data-page="${i}">${i}</button>`;
                }
              }
              
              if (paginactual < total_pages) {
                pagination += `<button class="page-btn" data-page="${paginactual + 1}">»</button>`;
              }
          pagination += '</div>';

          $("#pagination-container").html(pagination);

      })
      .catch(error => {
        console.error("Error en la llamada AJAX (ciudades):", error);
      });
  } 
  var tablas = [];
  function mostrar_modal() { 
    $(document).on('click', '.modal_filtros', function () {
      $("#details_modal").removeAttr("hidden").show();
      $("#container_filtros").dialog({
        width: 850,
        height: 500, 
        resizable: "false", 
        modal: "true",
        buttons: {
            Ok: function () {
                $(this).dialog("close");
            },
            Filtrar: {
              text: "Filtrar",
              class: "filter_button",
              id: "Button_filter",
            },
            Eliminar: {
              text: "Eliminar Filtros",
              class: "filter_remove",
              id: "Remove_filter",
            },
        },
        show: {
            effect: "blind",
            duration: 1000
        },
        hide: {
            effect: "explode",
            duration: 1000
        }
      });
    });
    
}

function filtroshtml() {
    $('<button>Filtros</button>').attr({ id: 'modal_filtros', class: 'modal_filtros' }).appendTo("#filtros");
    $('<div></div>').attr({ id: 'details_modal', hidden: true }).appendTo("#filtros");
    $('<div></div>').attr("id", 'container_filtros').appendTo('#details_modal');
    ajaxpromise('POST', 'index.php?module=shop&op=tipos', null, 'json')
    .then(function (data, status) {
      let content = "";
           for (let row in data[5][0]) {
            tablas.push(data[5][0][row]);
            if (data[5][0][row].tipo == "select") {
              content += `
              <div class="filter-group">
                <label class="filter-label">${data[5][0][row].nombre_tabla}</label>
                <select class="filter-select filter_${data[5][0][row].nombre_tabla}"></select>
              </div>`;
           } else if(data[5][0][row].tipo == "checkbox"){
            content += `
            <div class="filter-group">
              <label class="filter-label">${data[5][0][row].nombre_tabla}</label>
              <div class="filter-checkbox filter_${data[5][0][row].nombre_tabla}"></div>
            </div>`;
           } else if( data[5][0][row].tipo == "radio"){
            content += `
            <div class="filter-group">
              <label class="filter-label">${data[5][0][row].nombre_tabla}</label>
              <div class="filter-checkbox filter_${data[5][0][row].nombre_tabla}"></div>
            </div>`;
           }
          }
          $("#container_filtros").html(content);
          let i=0;
/*          data.forEach(row => {
            row.forEach(row2 => { 
              if (row2.tipo == "select") {
                $(`.filter_${row2.tabla}`).append(`<option value="${row2.name}">${row2.name}</option>`);
              } else if(row2.tipo == "checkbox"){
                $(`.filter_${row2.tabla}`).append(`<label><input type="checkbox" value="${row2.name}">${row2.name}</label><br>`);
              } else if( row2.tipo == "radio"){
                $(`.filter_${row2.tabla}`).append(`<label><input type="radio" value="${row2.name}">${row2.name}</label><br>`);
              }
            });
          }); */
           for (let row in data) {
            for (let row2 in data[row]) {
              for (let row3 in data[row][row2]) {
                  if (data[row][row2][row3].tipo == "select") {
                    $(`.filter_${data[row][row2][row3].tabla}`).append(`
                      <option value="${data[row][row2][row3].name}">${data[row][row2][row3].name}</option>`);                 
                     } else if (data[row][row2][row3].tipo == "checkbox") {
                    $(`.filter_${data[row][row2][row3].tabla}`).append(`
                      <label class="filter-option">
                        <input type="checkbox" class="${data[row][row2][row3].tabla}" value="${data[row][row2][row3].name}">
                        ${data[row][row2][row3].name}
                      </label>`);                 
                     } else if (data[row][row2][row3].tipo == "radio") {
                    $(`.filter_${data[row][row2][row3].tabla}`).append(`
                      <label class="filter-option">
                        <input type="checkbox" class="${data[row][row2][row3].tabla}" value="${data[row][row2][row3].name}">
                        ${data[row][row2][row3].name}
                      </label>`);                }
              }
            }
            i++;
          } 

/*             for (let i = 0; i < data.length; i++) {
              for (let j = 0; j < data[i].length; j++) {
                  for (let k = 0; k < data[i][j].length; k++) {
                      let row = data[i][j][k];
                      if (row.tipo == "select") {
                          $(`.filter_${row.tabla}`).append(`<option value="${row.name}">${row.name}</option>`);
                      } else if (row.tipo == "checkbox") {
                          $(`.filter_${row.tabla}`).append(`<label><input type="checkbox" value="${row.name}">${row.name}</label><br>`);
                      } else if (row.tipo == "radio") {
                          $(`.filter_${row.tabla}`).append(`<label><input type="radio" value="${row.name}">${row.name}</label><br>`);
                      }
                  }
              }
          } */
         filter_button();
         highlightFilters();
      })
      .catch(error => {
          console.error("Error en la llamada AJAX (filtros):", error);
      }); 
}   
function highlightFilters() {
  var all_filters = JSON.parse(localStorage.getItem('filter'));

  if (!all_filters) return;

  all_filters.forEach(filter => {
    let [id_filtro, valor_filtro, tabla] = filter;

    if (Array.isArray(valor_filtro)) {
      valor_filtro.forEach(val => {
        $(`.filter_${tabla} input[type="checkbox"][value="${val}"]`).prop('checked', true);
      });
    } else {
      $(`.filter_${tabla}`).val(valor_filtro);
      $(`.filter_${tabla} input[type="radio"][value="${valor_filtro}"]`).prop('checked', true);
    }
  });
}



function listmap(data) {
  var map = L.map('map').setView([40.4168, -3.7038], 6);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  var customIcon = L.icon({
    iconUrl: 'https://i.ibb.co/FLww5HBD/marcador-de-posicion.png',
    iconSize: [38, 50],  
    shadowSize: [50, 64],
    iconAnchor: [19, 50],  
    popupAnchor: [0, -45]  
  });

  for (let row in data) {
    if (data.length == undefined || data.length == 0) {
      continue;
    }

    let imagesHTML = "";
    for (let img in data[row].imagenes) {
      imagesHTML += `
          <img class="imagen-fija" src="${data[row].imagenes[img]}" 
          alt="${data[row].imagenes[img]}" 
          style="width: 100px; height: auto; border-radius: 5px; margin: 5px;">`;
    }

    let popupContent = `
      <div style="text-align: center;">
        <div class="slick2" id="list-carrusell-${data[row].id_accesorio}">
          ${imagesHTML}
        </div>
        <h3>${data[row].name}</h3>
        <p>${data[row].precio}€</p>
        <p>${data[row].descripcion}</p>
      </div>
    `;

    let marker = L.marker([data[row].lat, data[row].lon], { icon: customIcon }).addTo(map);
    
    marker.bindPopup(popupContent);

    marker.on("popupopen", function () {
      setTimeout(() => {
        $(`#list-carrusell-${data[row].id_accesorio}`).slick({
          infinite: true,
          dots: true,
          slidesToShow: 1, 
          slidesToScroll: 1,
          prevArrow: '<button class="arrow-slick2 prev-slick2 slick-prev" onclick="event.stopPropagation();"><i class="fa fa-angle-left" aria-hidden="true"></i></button>',
          nextArrow: '<button class="arrow-slick2 next-slick2 slick-next" onclick="event.stopPropagation();"><i class="fa fa-angle-right" aria-hidden="true"></i></button>',
          adaptiveHeight: true
        });
      }, 100);
    });
  }
}


  function detailsmap(data) {
    var map = L.map('map1').setView([data[0].lat, data[0].lon], 13);
  
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);
  
    var customIcon = L.icon({
      iconUrl: 'https://i.ibb.co/FLww5HBD/marcador-de-posicion.png',
      iconSize: [38, 50],  
      shadowSize: [50, 64],
      iconAnchor: [19, 50],  
      shadowAnchor: [4, 40],
      popupAnchor: [0, -45]  
  });

     L.marker([data[0].lat, data[0].lon], {icon: customIcon}).addTo(map)
      .bindPopup(data[0].descripcion); 
    }
  



/* 
  function filtroshtml() {
    $('<div></div>').appendTo('.filters')
        .html(`
            <select class="filter_category"> 
                <option value="Gafas de sol">Gafas de sol</option> 
                <option value="Relojes">Relojes</option> 
                <option value="Mochilas">Mochilas</option> 
                <option value="Collares">Collares</option> 
            </select> 
          <div class="filter_brand">
              <label><input type="checkbox" value="Ray-Ban"> Ray-Ban</label><br>
              <label><input type="checkbox" value="Oakley"> Oakley</label><br>
              <label><input type="checkbox" value="Rolex"> Rolex</label><br>
              <label><input type="checkbox" value="Casio"> Casio</label><br>
              <label><input type="checkbox" value="Nike"> Nike</label><br>
              <label><input type="checkbox" value="Adidas"> Adidas</label><br>  
              <label><input type="checkbox" value="Gucci"> Gucci</label><br>
              <label><input type="checkbox" value="Louis Vuitton"> Louis Vuitton</label><br>
              <label><input type="checkbox" value="Persol"> Persol</label><br>
              <label><input type="checkbox" value="Prada"> Prada</label><br>
              <label><input type="checkbox" value="Tom Ford"> Tom Ford</label><br>
              <label><input type="checkbox" value="Maui Jim"> Maui Jim</label><br>
              <label><input type="checkbox" value="Carrera"> Carrera</label><br>
          </div>
            <select class="filter_city"> 
                <option value="Madrid">Madrid</option> 
                <option value="Barcelona">Barcelona</option> 
                <option value="Valencia">Valencia</option> 
                <option value="Sevilla">Sevilla</option> 
                <option value="Bilbao">Bilbao</option> 
                <option value="Málaga">Málaga</option> 
            </select> 
            <select class="filter_state"> 
                <option value="Nuevo">Nuevo</option> 
                <option value="Usado">Usado</option> 
                <option value="Reacondicionado">Reacondicionado</option> 
            </select> 
            <button class="filter_button" id="Button_filter">Filtrar</button> 
            <button class="filter_remove"  id="Remove_filter">Eliminar Filtros</button> 
        `);
} */

function Remove_filter(){
         $(document).on('click', '.filter_remove', function () {
          localStorage.removeItem('filter_marcas');
          localStorage.removeItem('filter_estados');
          localStorage.removeItem('filter_ciudades');
          localStorage.removeItem('filter_categorias');
          localStorage.removeItem('filter');
          localStorage.removeItem('currentPage');
          window.location.reload();
      });

}

function loadaccesorios(limit, offset) {
  var filter = localStorage.getItem('filter') || false;
  if (filter != false && filter != null && filter != undefined && filter != " ") {
      filter = JSON.parse(filter);
      ajaxForSearch("index.php?module=shop&op=filtros", filter, offset, limit);
      highlightFilters();
    }
    else {
      ajaxForSearch("index.php?module=shop&op=list-productos");
    }
}

function filter_button() {
  tablas.forEach(function(tabla) {
    
    if (tabla.tipo === "select") {
      $('.filter_' + tabla.nombre_tabla).change(function() {
        localStorage.setItem('filter_' + tabla.nombre_tabla, this.value);
      });

      if (localStorage.getItem('filter_' + tabla.nombre_tabla)) {
        $('.filter_' + tabla.nombre_tabla).val(localStorage.getItem('filter_' + tabla.nombre_tabla));
      }

     } else if (tabla.tipo === "checkbox") {
      $('.filter_' + tabla.nombre_tabla + ' input[type="checkbox"]').change(function() {
        var checked = [];
        $('.filter_' + tabla.nombre_tabla + ' input[type="checkbox"]:checked').each(function() {
          checked.push($(this).val());
        });
        localStorage.setItem('filter_' + tabla.nombre_tabla, JSON.stringify(checked));
      });

      

    } else if (tabla.tipo === "radio") {
      $('.filter_' + tabla.nombre_tabla + ' input[type="radio"]').change(function() {
        localStorage.setItem('filter_' + tabla.nombre_tabla, this.value);
      });


      
      if (localStorage.getItem('filter_' + tabla.nombre_tabla)) {
        const storedValue = localStorage.getItem('filter_' + tabla.nombre_tabla);
        $('.filter_' + tabla.nombre_tabla + ' input[type="radio"]').each(function() {
          if (this.value === storedValue) {
            $(this).prop('checked', true);
          }
        });
      }
    }
  });
  $('.orderby').change(function () {
      localStorage.setItem('orderby', this.value);
      localStorage.removeItem('currentPage');
      window.location.reload();
  });
  if (localStorage.getItem('orderby')) {
      $('.orderby').val(localStorage.getItem('orderby'));
  }

  $('.mostrarproductos').change(function () {
    localStorage.setItem('mostrar', this.value);
    localStorage.removeItem('currentPage');
    window.location.reload();
});


$(document).on('click', '.categorias_visitado', function () { 
  localStorage.removeItem('filter_marcas');
  localStorage.removeItem('filter_estados');
  localStorage.removeItem('filter_ciudades');
  localStorage.removeItem('filter_categorias');
  localStorage.removeItem('filter');
  var id = this.getAttribute('id');
  filter.push(['id_categoria', id, 'categorias']);
  localStorage.setItem('filter_categorias', id); 
  localStorage.setItem('filter', JSON.stringify(filter));
  window.location.href = 'index.php?module=controller_shop&op=list';
});









if (localStorage.getItem('mostrar')) {
    $('.mostrarproductos').val(localStorage.getItem('mostrar'));
    
}
  



/*   $('.filter_categorias').change(function () {
      localStorage.setItem('filter_categorias', this.value);
  });
  if (localStorage.getItem('filter_categorias')) {
      $('.filter_categorias').val(localStorage.getItem('filter_categorias'));
  }
;

  if (localStorage.getItem('filter_marcas')) {
      var storedBrands = JSON.parse(localStorage.getItem('filter_marcas'));
      $('.filter_marcas input[type="checkbox"]').each(function () {
          if (storedBrands.includes(this.value)) {
              $(this).prop('checked', true);
          }
      });
  }

  $('.filter_ciudades').change(function () {
      localStorage.setItem('filter_ciudades', this.value);
  });
  if (localStorage.getItem('filter_ciudades')) {
      $('.filter_ciudades').val(localStorage.getItem('filter_ciudades'));
  }

  $('.filter_estados').change(function () {
      localStorage.setItem('filter_state', this.value);
  });
  if (localStorage.getItem('filter_state')) {
      $('.filter_ciudades').val(localStorage.getItem('filter_state'));
  }
 */
  $(document).on('click', '.filter_button', function () {
      var filter = [];

      if (localStorage.getItem('filter_categorias')) {
          filter.push(['id_categoria', localStorage.getItem('filter_categorias'), 'categorias']);
      }
      if (localStorage.getItem('filter_marcas')) {
          filter.push(['id_marca', JSON.parse(localStorage.getItem('filter_marcas')), 'marcas']);
      }
      if (localStorage.getItem('filter_ciudades')) {
          filter.push(['id_ciudad', localStorage.getItem('filter_ciudades'), 'ciudades']);
      }
      if (localStorage.getItem('filter_estados')) {
          filter.push(['id_estado', localStorage.getItem('filter_estados'), 'estados']);
      }

      if (filter != 0) {
        localStorage.setItem('filter', JSON.stringify(filter));
    }    
    localStorage.removeItem('currentPage');
    window.location.reload();
  });
}


function paginar(){
  $(document).on('click', '.page-btn', function () {
    const page = $(this).data('page');
    localStorage.setItem('currentPage', page);
    location.reload();
  });
  
}

function pagination() {
  var pagina =  localStorage.getItem('currentPage') || 1;
  var filter = localStorage.getItem('filter') || false;
  var order = localStorage.getItem('orderby') || "popular";
  var mostrar = parseInt(localStorage.getItem('mostrar')) || 4;

  if (filter != false && filter != null && filter != undefined && filter != " ") {
      filter = JSON.parse(filter);
      var url = "index.php?module=shop&op=count_filtros";
    }
    else {
      var url = "index.php?module=shop&op=count_filtros";
    }
    ajaxpromise('POST', url, { 'filter': filter }, 'json', )
      .then(function(data) {
          var total_products = data;
          var total_pages = (total_products >= mostrar) ? Math.ceil(total_products / mostrar) : 1;
          if(pagina > total_pages){
            pagina=1;
            localStorage.setItem('currentPage', pagina);
            }
          var offset = mostrar * (pagina - 1);  
     
          if (filter != false) {
              ajaxForSearch("index.php?module=shop&op=filtros", filter, offset, mostrar, total_pages, order);
              highlightFilters();
          } else {
              ajaxForSearch("index.php?module=shop&op=list-productos", undefined, offset, mostrar, total_pages, order);
              highlightFilters();
          }
          $('html, body').animate({ scrollTop: $(".wrap") });
      })
} 

/* function pintarlikejs() {
  document.addEventListener('click', e => {
    const token = JSON.parse(localStorage.getItem('token')) || false;

    // Solo los .block2-btn-addwishlist que tengan data-id
    const listBtn = e.target.closest('.block2-btn-addwishlist[data-id]');
    if (listBtn) {
      e.preventDefault();
      e.stopImmediatePropagation();  // frena cualquier otro listener en document

      if (!token) {
        alert('Debes iniciar sesión para dar me gusta');
        return;
      }

      // toggle visual
      const icon = listBtn.querySelector('i');
      icon.classList.toggle('fa-regular');
      icon.classList.toggle('fa-solid');

      // tu AJAX exactamente igual
      ajaxpromise(
        'POST',
        'module/shop/controller/controller_shop.php?op=control_likes',
        { token, id_car: listBtn.dataset.id },
        'json'
      )
      .then(code => console.log('Like list:', code))
      .catch(console.error);

      return;  
    }

    // resto: detalle…
    const detailBtn = e.target.closest('#like-detail');
    if (detailBtn) {
      /* …igual que antes… 
    }
  });
} */



function click_like(btn) {
  const $btn  = $(btn);
  const id    = $btn.data('id');
  const $icon = $btn.find('i');
  const token = JSON.parse(localStorage.getItem('token')) || false;
  if (!token) {
    Swal.fire('Debes iniciar sesión para dar like');
    (function checkRecoveredd() {
    const params = new URLSearchParams(window.location.search);
    if (params.get('recovered') === '1') {
      params.delete('recovered');
      const token = params.get('token');
      document.getElementById('token_recover').value = token;
      showModal('reset');
    } 
  })();
    return;
  }
  ajaxpromise(
    'POST',
    'index.php?module=shop&op=control_likes',
    { token: token, id_accesorio: id },
    'json'
  )
  .then(function(response) {
    if (response === 'liked' || response === 'unliked') {
      $icon.toggleClass('fa-regular fa-solid like_red');
    } else {
      Swal.fire('Error al procesar tu like');
    }
  })
  .catch(function() {
    Swal.fire('Error al procesar tu like');
  });
}

function load_user_likes() {
  const token = JSON.parse(localStorage.getItem('token')) || false;
  if (!token) return;
  ajaxpromise(
    'POST',
    'index.php?module=shop&op=load_likes_user',
    { token: token },
    'json'
  )
  .then(function(data) {
    data.forEach(function(item) {
      $(`[data-id="${item.id_accesorio}"] i`)
        .removeClass('fa-regular')
        .addClass('fa-solid like_red');
    });
  })
  .catch(function(err) {
    console.error('Error al cargar likes de usuario:', err);
  });
}




  function clickdetails() {
    $(document).on('click', '.details_accesorio', function () { 
      var id = this.getAttribute('id');
      detalles(id);
    });
    if (localStorage.getItem('id_accesorio')) {
      var id = localStorage.getItem('id_accesorio');
      detalles(id);
      localStorage.removeItem('id_accesorio');
    }
  }

  function detalles(id) {
      items = 4;
      loaded = 4;
      items1 = 4;
      loaded1 = 4;
      ajaxpromise('POST', 'index.php?module=shop&op=details', { id_accesorio: id }, 'json')
      .then(function (data, status) {
          $(".container-shop").empty();
  
          let content = "";
  
          content += `
            <div class="bread-crumb bgwhite flex-w p-l-52 p-r-15 p-t-30 p-l-15-sm">
              <a class="s-text16" href="/" title="Back to the frontpage">
                Home <i class="fa fa-angle-right m-l-8 m-r-9" aria-hidden="true"></i>
              </a>
              <a class="s-text16" href="#">
                ${data[0].name}
              </a>
            </div>
  
            <!-- Product Detail -->
            <div class="container bgwhite p-t-35 p-b-80">
              <div class="flex-w flex-sb">
  
                    <div class="w-size13 p-t-30 respon5">
                  
                  <div class="slick-carousel"">
          `;       
          for (let row in data[1][0]) {
          content += `
                  <div class="main-image" >
                  <img 
                    id="main-product-image"
                    src="${data[1][0][row].image}" 
                    alt="main-image"
                    class="imagen-fija-grande"
                  />
                </div>
          `;
          }
          content += `
                  </div>
                </div>        
                <!-- Info del producto -->
                <div class="w-size14 p-t-30 respon5">
                  <h4 class="product-detail-name m-text16 p-b-13" id="producto_detalle">
                    ${data[0].name}
                  </h4>
                  <span id="productPrice" class="m-text17">
                    ${data[0].precio} €
                  </span>
                  <p class="s-text8 p-t-10">
                    ${data[0].estado}
                  </p>
                  <p class="s-text8 p-t-10">
                    ${data[0].descripcion}
                  </p>
                  
                  <div class="p-t-33 p-b-60">
                    <form action="/cart/add" method="post" id="form_buy">
                      <!-- Cantidad y botón Agregar al carrito -->
                      <div class="flex-r-m flex-w p-t-12">
                        <div class="w-size160 flex-m flex-w">
                          <div class="flex-w bo5 of-hidden m-r-22 m-t-10 m-b-10">
                            <button class="btn-num-product-down color1 flex-c-m size7 bg8 eff2">
                              <i class="fs-12 fa fa-minus" aria-hidden="true"></i>
                            </button>
                            <input class="size8 m-text18 t-center num-product" type="number" id="Quantity" name="num-product" value="1">
                            <button class="btn-num-product-up color1 flex-c-m size7 bg8 eff2">
                              <i class="fs-12 fa fa-plus" aria-hidden="true"></i>
                            </button>
                          </div>
                          <div class="btn-addcart-product-detail size9 trans-0-4 m-t-10 m-b-10">
                            <button id="boton_relacionados" class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4" type="button">
                              Add to Cart
                            </button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
  
                  <div class="p-b-45">
                    <span class="s-text8 m-r-35">Marca:  ${data[0].marca}</span> 
                    <span class="s-text8">
                      Categorias: 
                      `;
                      for(let row in data[4][0]){
                      content += `<a class="categoria_relacionada" id="${data[4][0][row].name}">${data[4][0][row].name}</a>, `;
                      }

                      content += `
                    </span>

                  </div>
                    <div class="product-features">
                      <div class="feature-item">
                                  <button
                        id="like-detail"
                        data-id="${data[0].id_accesorio}"
                        class="feature-icon"
                        onclick="
                          event.preventDefault();
                          event.stopPropagation();
                          click_like(this);
                        "
                      >
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <div class="feature-text">…</div>
                      </div>
                    </div>
                    
                   <div class="product-features">
                   

                      `;
                      for (let row in data[2][0]) {
                          content += `
                          <div class="feature-item">
                              <div class="feature-icon">
                                  <i class="${data[2][0][row].icono}"></i>
                              </div>
                              <div class="feature-text">
                                  <p class="feature-title">${data[2][0][row].titulo}</p>
                                  <p class="feature-subtitle">${data[2][0][row].descripcion}</p>
                              </div>
                          </div>`;
                      }
                      content += `
                  </div>
                    <div class="wrap-dropdown-content bo6 p-t-15 p-b-14 active-dropdown-content">
                      <h5 class="js-toggle-dropdown-content flex-sb-m cs-pointer m-text19 color0-hov trans-0-4">
                          Description
                      </h5>
                      <div class="dropdown-content p-t-15 p-b-23">
                          <p class="s-text8">
                          ${data[0].descripcion_larga}
                          </p>
                      </div>
                  </div>
                  <div class="wrap-dropdown-content bo6 p-t-15 p-b-14">
                      <h5 class="js-toggle-dropdown-content flex-sb-m cs-pointer m-text19 color0-hov trans-0-4">
                          Reviews
                      </h5>
                      <div class="dropdown-content dis-none p-t-15 p-b-23">
                          <p class="s-text8">
                              No hay reseñas aún. ¡Sé el primero en opinar sobre este producto!
                          </p>
                      </div>
                  </div>
                  </div>
                </div>
              </div>
            </div>
             <h3 class="m-text5 t-center"> Ubicación del accesorio</h3>
            <div id="map-container" style="width: 80%; max-width: 800px; height: 400px; background: #eee; margin: 40px auto; border-radius: 10px; overflow: hidden;">
              <div id="map1" style="width: 100%; height: 100%;"></div>
            </div>
            <!-- Sección de productos relacionados -->
            <section class="relateproduct bgwhite p-t-45 p-b-138">
              <div class="container">
                <div class="sec-title p-b-60">
                  <h3 class="m-text5 t-center">
                    Recomendado Para Ti
                  </h3>
                </div>
                <div class="wrap-slick2">
                  <div class="slick2" id="related-products-carrusel">
                  `;
                  for(let row in data[3][0]){
                    content += `
                    <div class="item-slick2 p-l-15 p-r-15" >
                      <div class="block2 details_accesorio ${data[3][0][row].id_accesorio}" id="${data[3][0][row].id_accesorio}">
                        <div class="block2-img wrap-pic-w of-hidden pos-relative">
                          <a href="#">
                            <img class="imagen-fija" src="${data[3][0][row].imagen_principal}" alt="${data[3][0][row].name}">
                          </a>
                          <div class="block2-overlay trans-0-4">
                            <div class="block2-btn-addcart w-size1 trans-0-4">
                              <button class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4">
                                Añadir al carrito
                              </button>
                            </div>
                          </div>
                        </div>
                        <div class="block2-txt p-t-20">
                        <a href="#" class="block2-name dis-block s-text3  p-b-5" >${data[3][0][row].name}</a>
                        <span class="block2-price m-text6 p-r-5 " >${data[3][0][row].precio} €</span>
                      </div>
                      </div>
                    </div>
                  `;
                  }
                  content += `
                  </div>
                </div>
        <div id="related-products-list" class="related-products-grid"> 
        </div> 
         <div class="ver-mas-container">
              <button id="ver-mas-btn" onclick="carrusel_off('${id}')">Ver más</button>
            </div>
                 <h3 class="m-text5 t-center" style="margin-top: 50px;">
                   Complementos
                  </h3>
            <div class="wrap-slick2">
            <div class="slick2" id="complements-products-carrusel">
         
            `;
            for(let row in data[5][0]){
              content += `
              <div class="item-slick2 p-l-15 p-r-15" >
                <div class="block2 details_accesorio ${data[5][0][row].id_accesorio}" id="${data[5][0][row].id_accesorio}">
                  <div class="block2-img wrap-pic-w of-hidden pos-relative">
                    <a href="#">
                      <img class="imagen-fija" src="${data[5][0][row].imagen_principal}" alt="${data[5][0][row].name}">
                    </a>
                    <div class="block2-overlay trans-0-4">
                      <div class="block2-btn-addcart w-size1 trans-0-4">
                        <button class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4">
                          Añadir al carrito
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="block2-txt p-t-20">
                  <a href="#" class="block2-name dis-block s-text3  p-b-5" >${data[5][0][row].name}</a>
                  <span class="block2-price m-text6 p-r-5 " >${data[5][0][row].precio} €</span>
                </div>
                </div>
              </div>
            `;
            }
            content += `
            </div>
          </div>
                <div id="related-products-list2" class="related-products-grid2"> 
        </div> 
                <div class="ver-mas-container">
              <button id="ver-mas-btn2" onclick="carrusel_off2('${id}')">Ver más</button>
            </div>
          </div>
                
         </div>     
          <script>
          $('.numeros').change(function () {
          const numero = $(this).val(); 
          const id = $(this).data('id'); 
          console.log("ID del accesorio:", id);
          console.log("Número seleccionado:", numero);
          ajaxpromise('POST', 'module/shop/controller/controller_shop.php?op=rating', { 'rating': numero, 'id_accesorio': id }, 'json')
          .then(function(data) {
              console.log("Respuesta del servidor:", data);
          })
          .catch(function(error) {
              console.error("Error en la llamada AJAX:", error);
          });
        });
          </script>
            </section>
          `;
          $(".container-shop").html(content);
          load_user_likes();

          detailsmap(data);

          $("#related-products-carrusel").slick({
            slidesToShow: 4,        
            slidesToScroll: 1,    
            infinite: true,        
            dots: false,          
            arrows: true,         
            autoplay: true,
            autoplaySpeed: 3000,
            prevArrow: '<button class="arrow-slick2 prev-slick2 slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></button>',
            nextArrow: '<button class="arrow-slick2 next-slick2 slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></button>',
            responsive: [
              {
                breakpoint: 1120,
                settings: {
                  slidesToShow: 3
                }
              },
              {
                breakpoint: 768,
                settings: {
                  slidesToShow: 2
                }
              },
              {
                breakpoint: 480,
                settings: {
                  slidesToShow: 1
                }
              }
            ]
          });

          $("#complements-products-carrusel").slick({
            slidesToShow: 4,        
            slidesToScroll: 1,    
            infinite: true,        
            dots: false,          
            arrows: true,         
            autoplay: true,
            autoplaySpeed: 3000,
            prevArrow: '<button class="arrow-slick2 prev-slick2 slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></button>',
            nextArrow: '<button class="arrow-slick2 next-slick2 slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></button>',
            responsive: [
              {
                breakpoint: 1120,
                settings: {
                  slidesToShow: 3
                }
              },
              {
                breakpoint: 768,
                settings: {
                  slidesToShow: 2
                }
              },
              {
                breakpoint: 480,
                settings: {
                  slidesToShow: 1
                }
              }
            ]
          });


          $('.slick-carousel').slick({
            infinite: true,
            dots: true,
            slidesToShow: 1, 
            slidesToScroll: 1,
            prevArrow: '<button class="arrow-slick2 prev-slick2 slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></button>',
            nextArrow: '<button class="arrow-slick2 next-slick2 slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></button>',
            adaptiveHeight: true
          });
        });
/*     detailsmap(data);
 */  }
 let items = 4;
 let loaded = 4;
 let items1 = 4;
 let loaded1 = 4;

 function carrusel_off(id_accesorio){
  $('#related-products-carrusel').slick('slickSetOption', 'arrows', false, true);
  $('#related-products-carrusel').slick('slickSetOption', 'autoplay', false, true);
  $('#related-products-carrusel').slick('slickSetOption', 'draggable', false, true);
  $('#related-products-carrusel').slick('slickSetOption', 'infinite', false, true);
  $('#related-products-carrusel').slick('slickSetOption', 'slidesToShow', 4, true);
  $('#related-products-carrusel').slick('slickGoTo', 0, true);
  $("#related-products-carrusel .slick-slide").css("transition", "none")

    ajaxpromise("Post","index.php?module=shop&op=count_relacionados", { 'categoria': id_accesorio} ,"json" )
    .then(function (data, status) { 
      var total = data;
      añadir_relacioandos(items, id_accesorio, total);
      items = items + 4;
    }); 
}




function añadir_relacioandos(offset, id, total) {
  ajaxpromise("Post", "index.php?module=shop&op=relacionados", { 'id_accesorio': id, 'offset': offset, 'limit': 4 }, "json")
  .then(function (data, status) {
    let content = ""; 
    let accesorios = total - loaded;
    let boton = accesorios - 4;
    if (accesorios > 4) {
      for (let row in data) {
        content += `
          <div class="item-slick2 p-l-15 p-r-15">
            <div class="block2 details_accesorio ${data[row].id_accesorio}" id="${data[row].id_accesorio}">
              <div class="block2-img wrap-pic-w of-hidden pos-relative">
                <a href="#">
                  <img class="imagen-fija" src="${data[row].imagen_principal}" alt="${data[row].name}">
                </a>
                <div class="block2-overlay trans-0-4">
                  <div class="block2-btn-addcart w-size1 trans-0-4">
                    <button class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4">
                      Añadir al carrito
                    </button>
                  </div>
                </div>
              </div>
              <div class="block2-txt p-t-20">
                <a href="#" class="block2-name dis-block s-text3 p-b-5">${data[row].name}</a>
                <span class="block2-price m-text6 p-r-5">${data[row].precio} €</span>
              </div>
            </div>
          </div>
        `;
      }
      $(".related-products-grid").append(content);
    }
    if(boton < 4){
      $("#ver-mas-btn").remove();

    }
    loaded = loaded + 4;

  })
  .catch(function (error) {
    console.error("Error en AJAX:", error);
  });
}

function carrusel_off2(id_accesorio){
  $('#complements-products-carrusel').slick('slickSetOption', 'arrows', false, true);
  $('#complements-products-carrusel').slick('slickSetOption', 'autoplay', false, true);
  $('#complements-products-carrusel').slick('slickSetOption', 'draggable', false, true);
  $('#complements-products-carrusel').slick('slickSetOption', 'infinite', false, true);
  $('#complements-products-carrusel').slick('slickSetOption', 'slidesToShow', 4, true);
  $('#complements-products-carrusel').slick('slickGoTo', 0, true);
  $("#complements-products-carrusel .slick-slide").css("transition", "none");
;
   ajaxpromise("Post","index.php?module=shop&op=count_complementos_relacionados", { 'categoria': id_accesorio} ,"json" )
  .then(function (data1, status) { 
    console.log("data", data1);
   var total1 = data1;
    añadir_complementos(items1, id_accesorio, total1);
    items1 = items1 + 4; 
  });  
}

function añadir_complementos(offset, id, total1) {
  ajaxpromise("Post", "index.php?module=shop&op=complementos", { 'id_accesorio': id, 'offset': offset, 'limit': 4 }, "json")
  .then(function (data, status) {
    let content = ""; 
    let accesorios = total1 - loaded1;
    let boton = accesorios - 4;
    if (accesorios > 4) {
      for (let row in data) {
        content += `
          <div class="item-slick2 p-l-15 p-r-15">
            <div class="block2 details_accesorio ${data[row].id_accesorio}" id="${data[row].id_accesorio}">
              <div class="block2-img wrap-pic-w of-hidden pos-relative">
                <a href="#">
                  <img class="imagen-fija" src="${data[row].imagen_principal}" alt="${data[row].name}">
                </a>
                <div class="block2-overlay trans-0-4">
                  <div class="block2-btn-addcart w-size1 trans-0-4">
                    <button class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4">
                      Añadir al carrito
                    </button>
                  </div>
                </div>
              </div>
              <div class="block2-txt p-t-20">
                <a href="#" class="block2-name dis-block s-text3 p-b-5">${data[row].name}</a>
                <span class="block2-price m-text6 p-r-5">${data[row].precio} €</span>
              </div>
            </div>
          </div>
        `;
      }
      $(".related-products-grid2").append(content);
    }
    if(boton < 4){
      $("#ver-mas-btn2").remove();

    }
    loaded1 = loaded1 + 4;

  })
  .catch(function (error) {
    console.error("Error en AJAX:", error);
  });
} 

  function clicks(){
    $(document).on('click', '.categoria_relacionada', function () {
      const id = $(this).attr('id'); 
      console.log("ID del accesorio:", id);
      ajaxpromise('POST', 'index.php?module=shop&op=añadir_visitas_categoria', { 'categoria': id }, 'json')
      .then(function(data) {
      var filter = [];
          localStorage.removeItem('filter_marcas');
          localStorage.removeItem('filter_estados');
          localStorage.removeItem('filter_ciudades');
          localStorage.removeItem('filter_categorias');
          localStorage.removeItem('filter');
          filter.push(['id_categoria', id, 'categorias']);
          localStorage.setItem('filter_categorias', id); 
          localStorage.setItem('filter', JSON.stringify(filter));
          window.location.href = 'index.php?module=controller_shop&op=list';
          console.log("Respuesta del servidor:", data);
      })
      .catch(function(error) {
          console.error("Error en la llamada AJAX:", error);
      });
  });
  }
  $('.wrap-dropdown-content.active-dropdown-content .dropdown-content').show();
  $(document).on('click', '.js-toggle-dropdown-content', function () {
    $(this).parent('.wrap-dropdown-content').toggleClass('active-dropdown-content');
    $(this).next('.dropdown-content').slideToggle();
  });
  $(window).on('load', function() {
    mostrar_modal();
    filtroshtml();
    filter_button();
    //loadaccesorios();
    load_user_likes();
    Remove_filter(); 
    //detalles();
    pagination();
    paginar();
    carrusel_off2();
    carrusel_off();
    clicks();
    clickdetails();
  });
  
  /* for (let row in data) {
    content += `
      <div class="item-slick2 p-l-15 p-r-15">
        <div class="block2">
          <div class="block2-img wrap-pic-w of-hidden pos-relative">
            <a href="#">
              <img class="imagen-fija" src="${data[row].image}" alt="${data[row].name}">
            </a>
            <div class="block2-overlay trans-0-4">
              <div class="block2-btn-addcart w-size1 trans-0-4">
                <button class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4">
                  Ir a ${data[row].name}
                </button>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    `;
  } */
