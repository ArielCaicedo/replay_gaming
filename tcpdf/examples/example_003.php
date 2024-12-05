<?php
//============================================================+
// File name   : example_003.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 003 for TCPDF class
//               Custom Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Custom Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 * @group header
 * @group footer
 * @group page
 * @group pdf
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');


// Crear una nueva instancia de TCPDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Establecer información del documento
$pdf->SetCreator('Mi Aplicación');
$pdf->SetAuthor('Autor');
$pdf->SetTitle('Diploma');
$pdf->SetSubject('Diploma de Excelencia');

// Agregar una página
$pdf->AddPage('L', 'A4');

// Configurar fuente y tamaño
$pdf->SetFont('helvetica', 'B', 16);

// Agregar el nombre y apellidos del alumno/a
$nombreCompleto = 'Juan Pérez';
$pdf->Cell(0, 10, $nombreCompleto, 0, 1, 'C');

// Agregar una imagen ilustrada (reemplaza la URL con la imagen real)
$imagenUrl = 'https://example.com/imagen_alumno.jpg';
$pdf->Image($imagenUrl, 50, 30, 100, 0, 'JPG');

// Generar un QR con el nombre y apellidos del alumno/a
$qrData = $nombreCompleto;
$qrSize = 50;
$pdf->write2DBarcode($qrData, 'QRCODE,H', 160, 30, $qrSize, $qrSize);

// Agregar la descripción del título
$pdf->SetFont('helvetica', 'I', 12);
$titulo = 'Diploma de Excelencia en Programación';
$descripcion = 'Este certificado se otorga a ' . $nombreCompleto . ' por su destacada habilidad en programación.';
$pdf->MultiCell(0, 10, $titulo, 0, 'C');
$pdf->SetFont('helvetica', '', 10);
$pdf->MultiCell(0, 10, $descripcion, 0, 'C');

// Generar el archivo PDF
$pdf->Output('practica_01', 'D');

