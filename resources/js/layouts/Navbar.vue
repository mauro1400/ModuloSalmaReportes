<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Reportes Salma</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <router-link :to="{name:'reporteCertificadoOrigen'}" class="nav-link color-1">Reporte Certificados de Origen</router-link>
        </li>
        <li class="nav-item">
          <router-link :to="{name:'reporteArticulos'}" class="nav-link color-2">Reporte de Articulo</router-link>
        </li>
        <li class="nav-item">
          <router-link to="/" class="nav-link color-3">Reporte de Partida</router-link>
        </li>
        <li class="nav-item">
          <router-link to="/" class="nav-link color-4">Solicitud de Articulo</router-link>
        </li>
        <li class="nav-item">
          <router-link to="/" class="nav-link color-5">Formulario de Inexistencia</router-link>
        </li>
      </ul>
    </div>
  </nav>
</template>

<style>
.navbar-nav .nav-link {
  color: black; /* Color de las letras */
  text-decoration: none; /* Elimina el subrayado predeterminado */
  transition: color 0.9s; /* Animación de transición para el cambio de color */
}

.navbar-nav .nav-link.color-1:hover {
  color: red; /* Color de las letras al pasar el ratón para la opción 1 */
  border-bottom: 4px solid red;
}

.navbar-nav .nav-link.color-2:hover {
  color: blue; /* Color de las letras al pasar el ratón para la opción 2 */
  border-bottom: 4px solid blue;
}

.navbar-nav .nav-link.color-3:hover {
  color: green; /* Color de las letras al pasar el ratón para la opción 3 */
  border-bottom: 4px solid green;
}

.navbar-nav .nav-link.color-4:hover {
  color: orange; /* Color de las letras al pasar el ratón para la opción 4 */
  border-bottom: 4px solid orange;
}

.navbar-nav .nav-link.color-5:hover {
  color: purple; /* Color de las letras al pasar el ratón para la opción 5 */
  border-bottom: 4px solid purple;
}
</style>

<script>
export default {
  name: 'Navbar',
};
</script>
