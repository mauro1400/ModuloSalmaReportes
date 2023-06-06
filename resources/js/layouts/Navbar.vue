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
            <router-link :to="{name:'certidicadoOrigen'}" class="nav-link">Reporte Certificados de Origen</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/" class="nav-link">Reporte de Articulo</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/" class="nav-link">Reporte de Partida</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/" class="nav-link">Solicitud de Articulo</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/" class="nav-link">Formulario de Inexistencia</router-link>
          </li>
        </ul>
      </div>
    </nav>
  </template>
  
  <script>
  export default {
    name: 'Navbar',
  };
  </script>

  