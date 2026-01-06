#!/usr/bin/env node
/**
 * Generador de sitemap.xml para SELITEC
 * Genera un sitemap completo con todas las URLs del sitio
 */

const fs = require('fs');
const path = require('path');

// Importar datos de cursos
const CURSOS_DATA = require('./cursos-data.js');

// Configuración
const BASE_URL = 'https://www.selitec.cl';
const OUTPUT_FILE = 'sitemap.xml';

// URLs estáticas con prioridad y frecuencia de cambio
const staticPages = [
    { url: '/', priority: 1.0, changefreq: 'weekly' },
    { url: '/cursos/', priority: 0.9, changefreq: 'daily' },
    { url: '/programacion/', priority: 0.8, changefreq: 'weekly' },
    { url: '/nivelacion/', priority: 0.7, changefreq: 'monthly' },
    { url: '/empresa/', priority: 0.6, changefreq: 'monthly' },
    { url: '/contacto/', priority: 0.7, changefreq: 'monthly' }
];

// Función para formatear fecha en formato ISO
function getCurrentDate() {
    return new Date().toISOString().split('T')[0];
}

// Función para generar XML de una URL
function generateUrlEntry(loc, lastmod, changefreq, priority) {
    return `  <url>
    <loc>${BASE_URL}${loc}</loc>
    <lastmod>${lastmod}</lastmod>
    <changefreq>${changefreq}</changefreq>
    <priority>${priority}</priority>
  </url>`;
}

// Función principal para generar sitemap
function generateSitemap() {
    const currentDate = getCurrentDate();
    let xml = `<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
`;

    // Agregar páginas estáticas
    staticPages.forEach(page => {
        xml += generateUrlEntry(page.url, currentDate, page.changefreq, page.priority);
        xml += '\n';
    });

    // Agregar páginas de cursos individuales
    CURSOS_DATA.forEach(course => {
        const courseUrl = `/curso/${course.slug}/`;
        xml += generateUrlEntry(courseUrl, currentDate, 'monthly', 0.8);
        xml += '\n';
    });

    // Cerrar el XML
    xml += `</urlset>`;

    return xml;
}

// Guardar sitemap
function saveSitemap() {
    console.log('🗺️  Generando sitemap.xml...\n');
    
    const sitemap = generateSitemap();
    const outputPath = path.join(__dirname, OUTPUT_FILE);
    
    try {
        fs.writeFileSync(outputPath, sitemap, 'utf8');
        
        console.log('✅ Sitemap generado exitosamente!');
        console.log(`📁 Ubicación: ${outputPath}`);
        console.log(`\n📊 Estadísticas:`);
        console.log(`   • Páginas estáticas: ${staticPages.length}`);
        console.log(`   • Páginas de cursos: ${CURSOS_DATA.length}`);
        console.log(`   • Total de URLs: ${staticPages.length + CURSOS_DATA.length}`);
        console.log(`\n🌐 URL del sitemap: ${BASE_URL}/sitemap.xml`);
        
        return true;
    } catch (error) {
        console.error('❌ Error al generar sitemap:', error.message);
        return false;
    }
}

// Ejecutar si es llamado directamente
if (require.main === module) {
    saveSitemap();
}

module.exports = { generateSitemap, saveSitemap };
