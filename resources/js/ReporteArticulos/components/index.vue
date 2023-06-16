<template>
    <div class="container-fluid">
        <section class="gradient-custom">
            <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                <h3 class="card-header">Reporte de Articulos</h3>
                <div class="card-body">
                    <h5 class="card-title">Inventario General de Almacenes Físico Valorado</h5>
                    <div class="col-md-12 d-flex justify-content-center align-items-center">
                        <form @submit.prevent="submitForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="fechainicio">Fecha Inicio</label>
                                    <input class="form-control form-control-sm" type="text" id="fachainicio"
                                        v-model="fechainicio" placeholder="Ej. año-mes-dia">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="fechafin">Fecha Fin</label>
                                    <input class="form-control form-control-sm" type="text" id="fechafin" v-model="fechafin"
                                        placeholder="Ej. año-mes-dia">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="ci">Palabra Clave</label>
                                    <input class="form-control form-control-sm" type="text" id="palabra" v-model="palabraclave"
                                        placeholder="Palabra clave">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="certificado">Buscar en Regional</label>
                                    <select class="form-control form-control-sm" id="regional" v-model="regional">
                                        <option value="">Seleccione Regional</option>
                                        <option v-for="option in regionales" :value="option.name">{{
                                            option.name
                                        }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="solicitante">Solicitante</label>
                                    <select class="form-control form-control-sm" id="solicitante" v-model="solicitante">
                                        <option value="">Solicitante</option>
                                        <option v-for="option in solicitantes" :value="option.name">{{
                                            option.name
                                        }}</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="partida">Partida</label>
                                    <select class="form-control form-control-sm" id="partida" v-model="material">
                                        <option value="">Seleccione Partida</option>
                                        <option v-for="option in materiales" :value="option.description">{{
                                            option.description
                                        }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 d-flex justify-content-end align-items-center"
                                    style="margin-top: 24px;">
                                    <button type="submit" class="btn btn-outline-success"><i
                                            class="fa-sharp fa-solid fa-magnifying-glass"></i></button><span
                                        style="margin: 0 10px;"></span>
                                    <button type="button" class="btn btn-outline-danger" @click="resetForm"><i
                                            class="fa-solid fa-trash-can"></i></button>
                                </div>
                                <div class="col-md-6 d-flex justify-content-start align-items-center"
                                    style="margin-top: 24px;">

                                    <button class="btn btn-outline-success" @click="reporte()"><i
                                            class="fa-regular fa-file-excel"></i></button><span
                                        style="margin: 0 10px;"></span>
                                    <button class="btn btn-outline-danger" @click=""><i
                                            class="fa-regular fa-file-pdf"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div v-if="errorMessage" class="alert alert-danger" v-text="errorMessage" :class="{ fadeOut: fadeOut }">
                </div>
                <div class="card-footer">
                    <template v-if="busquedas.length === 0">
                        <no-hay-resultados></no-hay-resultados>
                    </template>
                    <template v-else>
                        <table class="table table-sm small-font">
                            <thead class="table-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Fecha de Entrega</th>
                                    <th>Nro Solicitud</th>
                                    <th>Solicitante </th>
                                    <th>Administrador</th>
                                    <th>Departamento</th>
                                    <th>Articulo</th>
                                    <th>Pedido</th>
                                    <th>Entregado</th>
                                    <th>Total Entregado</th>
                                    <th>Codigo</th>
                                    <th>Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in busquedas" :key="index">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ item.fecha_entrega }}</td>
                                    <td>{{ item.nro_solicitud }}</td>
                                    <td>{{ item.solicitante }}</td>
                                    <td>{{ item.administrador }}</td>
                                    <td>{{ item.departamento }}</td>
                                    <td>{{ item.articulo }}</td>
                                    <td>{{ item.pedido }}</td>
                                    <td>{{ item.entregado }}</td>
                                    <td>{{ item.total_entregado}}</td>
                                    <td>{{ item.codigo }}</td>
                                    <td>{{ item.code }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </template>
                </div>
            </div>
        </section>
    </div>
</template>
<style>
.small-font {
    font-size: 12px;
}

.fadeOut {
    transition: opacity 1s;
    animation: fadeOut 1s forwards;
}

@keyframes fadeOut {
    0% {
        opacity: 1;
    }

    100% {
        opacity: 0;
    }
}
</style>
<script>
import axios from 'axios';
import NoHayResultados from '../../witgets/noHayResultados.vue';
export default {
    components: {
        NoHayResultados,
    },
    data() {
        return {
            // VARIABLES DEL FORMULARIO
            palabraclave: '',
            fechainicio: '',
            fechafin: '',
            regional: '',
            solicitante: '',
            material: '',
            // VARIBLE PARA LA CONSULTA 
            busquedas: [],
            // VARIBLE PARA LOS CARGAR FILTROS 
            regionales: [],
            solicitantes: [],
            materiales: [],
            errorMessage: '',
            fadeOut: false,
        };

    },
    mounted() {
        this.filtrosBusqueda();
    },
    methods: {
        // En el método reporte() del componente index.vue
        reporte() {
            const requestData = {
                palabraclave: this.palabraclave,
                fechainicio: this.fechainicio,
                fechafin: this.fechafin,
                regional: this.regional,
                solicitante: this.solicitante,
                material: this.material,
            };

            if (!this.regional && !this.fechainicio && !this.fechafin && !this.solicitante && !this.material && !this.palabraclave) {
                this.errorMessage = "Se requiere al menos un valor para realizar la consulta.";
                this.fadeOut = false;
                setTimeout(() => {
                    this.fadeOut = true;
                    setTimeout(() => {
                        this.errorMessage = '';
                    }, 1000);
                }, 5000);
                return;
            }

            axios.get('/api/exportReporteArticulos', { params: requestData, responseType: 'blob' })
                .then(response => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', 'ReporteArticulos.xlsx');
                    document.body.appendChild(link);
                    link.click();
                })
                .catch(error => {
                    console.error(error);
                });
        },

        async submitForm() {
            try {
                const respuesta = await axios.post('/api/busquedaArticulos', {
                    palabraclave: this.palabraclave,
                    fechainicio: this.fechainicio,
                    fechafin: this.fechafin,
                    regional: this.regional,
                    solicitante: this.solicitante,
                    material: this.material,
                }, {
                    headers: {
                        'Accept': 'application/json',
                    },
                });
                this.busquedas = respuesta.data.busqueda
            } catch (error) {
                console.error(error);
            }
        },
        async filtrosBusqueda() {
            try {
                const respuesta = await axios.post('/api/filtrosBusquedaArticulos', {
                    headers: {
                        'Accept': `application/json`,
                    },
                });
                this.regionales = respuesta.data.regional
                this.solicitantes = respuesta.data.solicitante
                this.materiales = respuesta.data.material
            }
            catch (error) {
                console.error(error);
            }
        },
        resetForm() {
            this.palabraclave = '';
            this.fechainicio = '';
            this.fechafin = '';
            this.regional = '';
            this.solicitante = '';
            this.material = '';
            this.busquedas = [];
        },
    },
};
</script>