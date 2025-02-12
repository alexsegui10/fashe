function cargarproductos() {
    ajaxpromise('POST', 'module/shop/controller/controller_shop.php?op=list-productos', null, 'json')
      .then(function (data) {
        console.log("Datos recibidos (shop):", data);
        let content = "";
        for (let row in data) {
          content += `
            <!-- Producto 1 -->
            <div class="col-sm-12 col-md-6 col-lg-4 p-b-50">
              <div class="block2">
                <div class="block2-img wrap-pic-w of-hidden pos-relative">
                  <a href="/collections/all/products/boxy-t-shirt-with-roll-sleeve-detail">
                    <img class="imagen-fija" src="${data[row].image}"
                         alt="${data[row].image}">
                  </a>
                  <div class="block2-overlay trans-0-4">
                    <a href="#" class="block2-btn-addwishlist hov-pointer trans-0-4"></a>
                    <div class="block2-btn-addcart w-size1 trans-0-4">
                      <button class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4">
                        Add to Cart
                      </button>
                    </div>
                  </div>
                </div>
                <div class="block2-txt p-t-20">
                  <a href="/collections/all/products/boxy-t-shirt-with-roll-sleeve-detail" class="block2-name dis-block s-text3 p-b-5">
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
  
        $("#custom-products").html(content);
      })
      .catch(error => {
        console.error("Error en la llamada AJAX (ciudades):", error);
      });
  }
  

  
  $(window).on('load', function() {
    cargarproductos();
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