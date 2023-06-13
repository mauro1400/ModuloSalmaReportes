<template>
    <div class="container-fluid">
        <section class="gradient-custom">
            <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                <h3 class="card-header">Reporte Certificados de Origen</h3>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-11 mb-4">
                            <form @submit.prevent="submitForm">
                                <div class="row">
                                    <div class="col-md-2 mb-4" style="margin-top: 24px;">
                                        <label class="form-label" for="regional">Regional</label>
                                        <select class="form-control form-control-sm" id="regional" v-model="regional">
                                            <option value="">Seleccione Regional</option>
                                            <option v-for="option in regionales" :value="option.name">{{ option.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-4" style="margin-top: 24px;">
                                        <label class="form-label" for="primer_apellido">Fecha Inicio</label>
                                        <input class="form-control form-control-sm" type="text" id="fachainicio"
                                            v-model="fechainicio" placeholder="Ej. año-mes-dia">
                                    </div>
                                    <div class="col-md-2 mb-4" style="margin-top: 24px;">
                                        <label class="form-label" for="primer_apellido">Fecha Fin</label>
                                        <input class="form-control form-control-sm" type="text" id="fechafin"
                                            v-model="fechafin" placeholder="Ej. año-mes-dia">
                                    </div>
                                    <div class="col-md-2 mb-4" style="margin-top: 24px;">
                                        <label class="form-label" for="ci">Servidor Publico</label>
                                        <select class="form-control form-control-sm" id="servidor" v-model="solicitante">
                                            <option value="">Seleccione Servidor Publico</option>
                                            <option v-for="option in solicitantes" :value="option.name">{{ option.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-4" style="margin-top: 24px;">
                                        <label class="form-label" for="celular">Tipo Certificado</label>
                                        <select class="form-control form-control-sm" id="certificado" v-model="certificado">
                                            <option value="">Seleccione Tipo de Certificado</option>
                                            <option v-for="option in certificados" :value="option.description">{{
                                                option.description
                                            }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-4 d-flex justify-content-end align-items-center"
                                        style="margin-top: 24px;">
                                        <button type="submit" class="btn btn-outline-success"><i
                                                class="fa-sharp fa-solid fa-magnifying-glass"></i></button><span
                                            style="margin: 0 10px;"></span>
                                        <button type="button" class="btn btn-outline-danger" @click="resetForm"><i
                                                class="fa-solid fa-trash-can"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-1 mb-4 d-flex justify-content-start align-items-center">
                            <button class="btn btn-outline-success" @click="reporte()"><i
                                    class="fa-regular fa-file-excel"></i></button>
                        </div>
                    </div>
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
        // En el método reporte() del componente index.vue
        reporte() {
            const requestData = {
                regional: this.regional,
                fechainicio: this.fechainicio,
                fechafin: this.fechafin,
                solicitante: this.solicitante,
                certificado: this.certificado
            };
            axios.get('/api/exportReporteCO', { params: requestData, responseType: 'blob' })
                .then(response => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', 'datos.xlsx');
                    document.body.appendChild(link);
                    link.click();
                })
                .catch(error => {
                    console.error(error);
                });
        },
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
            this.fechainicio = '';
            this.fechafin = '';
            this.solicitante = '';
            this.certificado = '';
            this.busquedas = [];
        },
    },
};
</script>