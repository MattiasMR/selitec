#!/bin/bash
# Script para actualizar enlaces de PDFs

# Mantencion y produccion
find curso -name "index.html" -type f ! -path "*/ejemplo-curso/*" \
  -exec sed -i 's|assets/temarios/Metrología-Ajustes-y-Tolerancias\.pdf|assets/temarios/mantencion_y_produccion/Metrología-Ajustes-y-Tolerancias.pdf|g' {} \; \
  -exec sed -i 's|assets/temarios/Temario-Operación-de-Autoclaves\.pdf|assets/temarios/mantencion_y_produccion/Temario-Operación-de-Autoclaves.pdf|g' {} \; \
  -exec sed -i 's|assets/temarios/Técnicas-y-Maniobras-Rigger\.pdf|assets/temarios/mantencion_y_produccion/Técnicas-y-Maniobras-Rigger.pdf|g' {} \; \
  -exec sed -i 's|assets/temarios/Técnicas-de-Prevención-de-Riesgos-Operacionales-0225\.pdf|assets/temarios/mantencion_y_produccion/Técnicas-de-Prevención-de-Riesgos-Operacionales-0225.pdf|g' {} \; \
  -exec sed -i 's|assets/temarios/Técnicas-de-Gasfisteria-e-Instalaciones-Sanotarias-0222\.pdf|assets/temarios/mantencion_y_produccion/Técnicas-de-Gasfisteria-e-Instalaciones-Sanotarias-0222.pdf|g' {} \; \
  -exec sed -i 's|assets/temarios/Operación-y-Mantención-de-Transpaleta-Eléctrica-24-Horas\.pdf|assets/temarios/mantencion_y_produccion/Operación-y-Mantención-de-Transpaleta-Eléctrica-24-Horas.pdf|g' {} \; \
  -exec sed -i 's|assets/temarios/Mecánica-Mantención-Máquinas-y-Equipos-Industriales-0289\.pdf|assets/temarios/mantencion_y_produccion/Mecánica-Mantención-Máquinas-y-Equipos-Industriales-0289.pdf|g' {} \; \
  -exec sed -i 's|assets/temarios/Interpretación-Planos-Electricos\.pdf|assets/temarios/mantencion_y_produccion/Interpretación-Planos-Electricos.pdf|g' {} \; \
  -exec sed -i 's|assets/temarios/Instalaciones-y-Reparaciones-Eléctricas\.pdf|assets/temarios/mantencion_y_produccion/Instalaciones-y-Reparaciones-Eléctricas.pdf|g' {} \; \
  -exec sed -i 's|assets/temarios/Neumática-Aplicada-0156-02\.pdf|assets/temarios/mantencion_y_produccion/Neumática-Aplicada-0156-02.pdf|g' {} \; \
  -exec sed -i 's|assets/temarios/Interpretación-de-Planos-Mécanicos-02\.pdf|assets/temarios/mantencion_y_produccion/Interpretación-de-Planos-Mécanicos-02.pdf|g' {} \; \
  -exec sed -i 's|assets/temarios/Temario-Calderas-y-Autoclaves-1\.pdf|assets/temarios/mantencion_y_produccion/Temario-Calderas-y-Autoclaves-1.pdf|g' {} \; \
  -exec sed -i 's|assets/temarios/Operación-y-Mantención-de-Grúas-Horquillas-2017-1\.pdf|assets/temarios/mantencion_y_produccion/Operación-y-Mantención-de-Grúas-Horquillas-2017-1.pdf|g' {} \; \
  -exec sed -i 's|assets/temarios/Administracion-de-Bodegas-1\.pdf|assets/temarios/mantencion_y_produccion/Administracion-de-Bodegas-1.pdf|g' {} \; \
  -exec sed -i 's|assets/temarios/Administración-de-Bodegas-II\.pdf|assets/temarios/mantencion_y_produccion/Administración-de-Bodegas-II.pdf|g' {} \;

# Computacion
find curso -name "index.html" -type f ! -path "*/ejemplo-curso/*" \
  -exec sed -i 's|assets/temarios/EXCEL-BASICO-35-HORAS\.pdf|assets/temarios/computacion/EXCEL-BASICO-35-HORAS.pdf|g' {} \; \
  -exec sed -i 's|assets/temarios/EXCEL-AVANZADO-35-HORAS02\.pdf|assets/temarios/computacion/EXCEL-AVANZADO-35-HORAS02.pdf|g' {} \;

# Habilidades blandas
find curso -name "index.html" -type f ! -path "*/ejemplo-curso/*" \
  -exec sed -i 's|assets/temarios/Técnicas-Laborales-para-el-Desarrollo-y-Evaluacion-del-Trabajo-en-Equipo\.pdf|assets/temarios/habilidades_blandas/Técnicas-Laborales-para-el-Desarrollo-y-Evaluacion-del-Trabajo-en-Equipo.pdf|g' {} \; \
  -exec sed -i 's|assets/temarios/Administración-del-Tiempo-y-Control-de-Tareas-16-Hrs\.pdf|assets/temarios/habilidades_blandas/Administración-del-tiempo-y-control-de-tareas-ok.pdf|g' {} \;

# Idiomas
find curso -name "index.html" -type f ! -path "*/ejemplo-curso/*" \
  -exec sed -i 's|assets/temarios/ESPAÑOL-BÁSICO-INTEGRACION-LABORAL\.pdf|assets/temarios/idiomas/Español-Básico-para-la-Integración-Laboral.pdf|g' {} \;

echo "Enlaces actualizados exitosamente"
