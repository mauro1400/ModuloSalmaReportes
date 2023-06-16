<?php

use App\Http\Controllers\Excel\ReporteCertificadoOrigen\ExcelReporteCertificadoOrigen;
use App\Http\Controllers\reporte\ReporteCertificadoOrigenController;
use App\Http\Controllers\reporte\ReporteArticulosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//REPORTE CO
Route::post('/busquedaCertificadoOrigen', [ReporteCertificadoOrigenController::class, 'busquedaCertificadoOrigen']);
Route::post('/filtrosBusqueda', [ReporteCertificadoOrigenController::class, 'filtrosBusqueda']);
Route::post('/exportReporteCO', [ExcelReporteCertificadoOrigen::class, 'ExcelReporteCertificadoOrigen']);
Route::post('/exportPDFReporteCO', [ExcelReporteCertificadoOrigen::class, 'PDFReporteCertificadoOrigen']);
//REPORTE ARTICULOS
Route::post('/busquedaArticulos', [ReporteArticulosController::class, 'busquedaArticulos']);
Route::post('/filtrosBusquedaArticulos', [ReporteArticulosController::class, 'filtrosBusqueda']);
Route::post('/exportReporteArticulos', [ExcelReporteArticulos::class, 'ExcelReporteCertificadoOrigen']);
Route::post('/exportPDFReporteArticulos', [ExcelReporteArticulos::class, 'PDFReporteCertificadoOrigen']);
