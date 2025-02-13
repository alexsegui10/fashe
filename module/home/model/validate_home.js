function cargarciudad() {
  ajaxpromise('POST', 'module/home/controller/controller_home.php?op=ciudad', null, 'json')
    .then(function (data) {
      console.log("Datos recibidos (ciudades):", data);

      let content = "";
      for (let row in data) {
        content += `
          <article class="card__article">
            <img class="card__img" src="${data[row].image}" alt="${data[row].name}">
            <div class="card__data">
               <span class="card__description">${data[row].nproductos} productos</span>
               <h2 class="card__title">${data[row].name}</h2>
               <a href="#" class="card__button">Ver Mas</a>
            </div>
          </article>
        `;
      }    
      $("#categorias").html(content);
      $("#categorias").slick({
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

    })
    .catch(error => {
      console.error("Error en la llamada AJAX (ciudades):", error);
    });
}
function cargarprecio() {
  ajaxpromise('POST', 'module/home/controller/controller_home.php?op=prueba', null, 'json')
    .then(function (data) {
      console.log("Datos recibidos (marcas):", data);

      let content = "";
      for (let row in data) {
        content += `
          <article class="card__article">
            <img class="card__img" src="${data[row].image}" alt="${data[row].name}">
            <div class="card__data">
               <span class="card__description">${data[row].nproductos} productos</span>
               <h2 class="card__title">${data[row].name}</h2>
               <a href="#" class="card__button">Ver Mas</a>
            </div>
          </article>
        `;
      }    
      $("#marcas").html(content);
      $("#marcas").slick({
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

    })
    .catch(error => {
      console.error("Error en la llamada AJAX (ciudades):", error);
    });
}


function cargarcategorias() {
  ajaxpromise('POST', 'module/home/controller/controller_home.php?op=categorias', null, 'json')
    .then(function (data) {
      console.log("Datos recibidos (categorias):", data);
      let content = "";
      for (let row in data) {
        content += `   
        <div class="col-md-4">
          <div class="block1 hov-img-zoom pos-relative m-b-30">
          <a href="#">
            <img src="${data[row].image}" alt="${data[row].image}">
          </a>
          <div class="block1-wrapbtn w-size2">
            <a href="#" class="flex-c-m size2 m-text2 bg3 hov1 trans-0-4">${data[row].name}</a>
          </div>
        </div>
      </div>
      `;
      }
      $("#categorias-prinicipales").html(content);
    })
    .catch(error => {
      console.error("Error en la llamada AJAX (ciudades):", error);
    });
}



/* function slick(){
  if ($('.slick2').hasClass('slick-initialized')) {
    $('.slick2').slick('unslick');
  }
  $('.slick2').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    infinite: true,
    dots: false,
    arrows: true,
    prevArrow: '<button class="arrow-slick2 prev-slick2"><i class="fa fa-angle-left" aria-hidden="true"></i></button>',
    nextArrow: '<button class="arrow-slick2 next-slick2"><i class="fa fa-angle-right" aria-hidden="true"></i></button>',
    autoplay: true,
    autoplaySpeed: 3000,
    responsive: [
      {
        breakpoint: 992,
        settings: { slidesToShow: 3 }
      },
      {
        breakpoint: 768,
        settings: { slidesToShow: 2 }
      },
      {
        breakpoint: 576,
        settings: { slidesToShow: 1 }
      }
    ]
  });
} */

$(window).on('load', function() {
  cargarprecio();
  cargarciudad();
  cargarcategorias();
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