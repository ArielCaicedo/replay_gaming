 // JavaScript para cambiar el fondo del navbar cuando se hace scroll
 window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar-custom');
    if (window.scrollY > 50) {
      navbar.classList.add('scrolled'); // Aplica la clase cuando se hace scroll
    } else {
      navbar.classList.remove('scrolled'); // Elimina la clase cuando se vuelve a la parte superior
    }
  });

  // Añade spinner al botón de buscar
  document.getElementById('search').addEventListener('submit', function() {
    const button = document.getElementById('searchButton');
    button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Buscando...';
    button.disabled = true;
  });


  document.addEventListener('DOMContentLoaded', () => {
    const cartButtons = document.querySelectorAll('.add-to-cart');

    cartButtons.forEach(button => {
      button.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const token = this.getAttribute('data-token');

        addProducto(id, token); // Llamar la función que ya tienes
        triggerConfetti();
      });
    });
  });

  function triggerConfetti() {
    confetti({
      particleCount: 100, // Número de partículas
      startVelocity: 30, // Velocidad inicial
      spread: 360, // Ángulo de dispersión
      origin: {
        x: 0.9, // Coordenadas relativas del origen (90% a la derecha)
        y: 0.1 // Coordenadas relativas del origen (10% desde arriba)
      }
    });
  }

  function addProducto(id, token) {
    let url = 'clases/carrito.php';
    let formData = new FormData();
    formData.append('id', id);
    formData.append('token', token);

    fetch(url, {
        method: 'POST',
        body: formData,
        mode: 'cors'
      }).then(response => response.json())
      .then(data => {
        if (data.ok) {
          let numCart = document.getElementById("num_cart");
          numCart.innerHTML = data.numero;

          let carrito = document.querySelector(".cart");
          carrito.classList.add('vibrar');

          setTimeout(() => {
            carrito.classList.remove('vibrar');
          }, 800);
        }
      })
      .catch(error => console.error('Error:', error));
  }
  // Inicializar los popovers de los botones de esta sección
  document.addEventListener('DOMContentLoaded', function() {
    const popoverButtons = document.querySelectorAll('.section.cta [data-bs-toggle="popover"]');
    popoverButtons.forEach(function(button) {
      new bootstrap.Popover(button);
    });
  });