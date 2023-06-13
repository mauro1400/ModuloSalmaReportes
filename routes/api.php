<?php

use App\Http\Controllers\Excel\ReporteCertificadoOrigen\ExcelReporteCertificadoOrigen;
use App\Http\Controllers\reporte\ReporteCertificadoOrigenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/busquedaCertificadoOrigen', [ReporteCertificadoOrigenController::class, 'busquedaCertificadoOrigen']);
Route::get('/exportReporteCO', [ExcelReporteCertificadoOrigen::class, 'ExcelReporteCertificadoOrigen']);
Route::post('/filtrosBusqueda', [ReporteCertificadoOrigenController::class, 'filtrosBusqueda']);
