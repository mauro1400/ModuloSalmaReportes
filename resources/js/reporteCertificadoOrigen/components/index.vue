<template>
    <div class="container-fluid">
        <section class="gradient-custom">
            <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                <div class="card-body p-4 p-md-4">
                    <h3>Reporte Certificados de Origen</h3>
                    <hr>
                    <form @submit.prevent="submitForm">
                        <div class="row">
                            <div class="col-md-2 mb-4">
                                <label class="form-label" for="regional">Regional</label>
                                <select class="form-control form-control-sm" id="regional" v-model="regional">
                                    <option value="">Seleccione Regional</option>
                                    <option v-for="option in regionales" :value="option.name">{{ option.name }}</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-4">
                                <label class="form-label" for="primer_apellido">Fecha Inicio</label>
                                <input class="form-control form-control-sm" type="text" id="fachainicio"
                                    v-model="fechainicio" placeholder="Ej. año-mes-dia">
                            </div>
                            <div class="col-md-2 mb-4">
                                <label class="form-label" for="primer_apellido">Fecha Fin</label>
                                <input class="form-control form-control-sm" type="text" id="fechafin" v-model="fechafin"
                                    placeholder="Ej. año-mes-dia">
                            </div>
                            <div class="col-md-2 mb-4">
                                <label class="form-label" for="ci">Servidor Publico</label>
                                <select class="form-control form-control-sm" id="servidor" v-model="solicitante">
                                    <option value="">Seleccione Servidor Publico</option>
                                    <option v-for="option in solicitantes" :value="option.name">{{ option.name }}</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-4">
                                <label class="form-label" for="celular">Tipo Certificado</label>
                                <select class="form-control form-control-sm" id="certificado" v-model="certificado">
                                    <option value="">Seleccione Tipo de Certificado</option>
                                    <option v-for="option in certificados" :value="option.description">{{ option.description
                                    }}</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-4">
                                <br>
                                <button type="submit" class="btn btn-outline-success">Buscar</button>
                                <button type="button" class="btn btn-outline-   " @click="resetForm">Reiniciar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <hr>
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
                            <th>Block Certificado</th>
                            <th>Entregado</th>
                            <th>Observacion</th>
                            <th>Del</th>
                            <th>Al</th>
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
                            <td>{{ item.observacion }}</td>
                            <td>{{ item.del }}</td>
                            <td>{{ item.al }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</template>
<style>
.small-font {
    font-size: 12px;
}
</style>
<script>
import axios from 'axios';
export default {
    data() {
        return {
            regional: '',
            fechainicio: '',
            fechafin: '',
            solicitante: '',
            certificado: '',
            busquedas: [],
            regionales: [],
            solicitantes: [],
            certificados: [],
        };

    },
    mounted() {
        this.filtrosBusqueda();
    },
    methods: {
        async submitForm() {
            try {
                const respuesta = await axios.post('/api/busquedaCertificadoOrigen', {
                    regional: this.regional,
                    fechainicio: this.fechainicio,
                    fechafin: this.fechafin,
                    solicitante: this.solicitante,
                    certificado: this.certificado,
                }, {
                    headers: {
                        'Accept': 'application/json',
                    },
                });
                console.log(respuesta.data)
                this.busquedas = respuesta.data.busqueda
            } catch (error) {
                console.error(error);
            }
        },
        async filtrosBusqueda() {
            try {
                const respuesta = await axios.post('/api/filtrosBusqueda', {
                    headers: {
                        'Accept': `application/json`,
                    },
                });
                console.log(respuesta.data.regional)
                this.regionales = respuesta.data.regional
                this.solicitantes = respuesta.data.solicitante
                this.certificados = respuesta.data.certificado
            }
            catch (error) {
                console.error(error);
            }
        },
        resetForm() {
            this.regional = '';
            this.fachaInicio = '';
            this.fechaFin = '';
            this.servidor = '';
            this.certificado = '';
            this.busquedas = [];
        },
    },
};
</script>